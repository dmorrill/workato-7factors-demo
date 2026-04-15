<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ContentExtractorService
{
    public function extract(string $url): array
    {
        if ($this->isYouTube($url)) {
            return $this->extractFromYouTube($url);
        }

        return $this->extractFromWebPage($url);
    }

    private function isYouTube(string $url): bool
    {
        return str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be');
    }

    private function extractFromYouTube(string $url): array
    {
        $videoId = $this->parseYouTubeId($url);
        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        $text = '';

        // Get metadata via oEmbed
        $meta = Http::get("https://www.youtube.com/oembed", [
            'url'    => $url,
            'format' => 'json',
        ])->json();

        $title = $meta['title'] ?? '';
        $author = $meta['author_name'] ?? '';

        // Try to get auto-captions (timedtext API, works for public videos)
        try {
            $captionList = Http::timeout(10)->get(
                "https://www.youtube.com/api/timedtext",
                ['v' => $videoId, 'type' => 'list']
            )->body();

            // Try English captions
            $transcript = Http::timeout(10)->get(
                "https://www.youtube.com/api/timedtext",
                ['v' => $videoId, 'lang' => 'en', 'fmt' => 'json3']
            )->json();

            if (!empty($transcript['events'])) {
                $segments = [];
                foreach ($transcript['events'] as $event) {
                    if (isset($event['segs'])) {
                        foreach ($event['segs'] as $seg) {
                            $segments[] = $seg['utf8'] ?? '';
                        }
                    }
                }
                $text = implode(' ', $segments);
                $text = preg_replace('/\s+/', ' ', trim($text));
            }
        } catch (\Throwable $e) {
            // Transcript unavailable — proceed with metadata only
        }

        // Fall back to fetching the page description if no transcript
        if (empty($text)) {
            try {
                $html = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; bot/1.0)'])
                    ->get("https://www.youtube.com/watch?v={$videoId}")
                    ->body();

                // Extract description from meta tags
                preg_match('/<meta name="description" content="([^"]+)"/', $html, $m);
                $text = $m[1] ?? '';
            } catch (\Throwable $e) {
                $text = "YouTube video: {$title} by {$author}";
            }
        }

        return [
            'type'       => 'youtube',
            'title'      => $title,
            'author'     => $author,
            'video_url'  => $embedUrl,
            'source_url' => $url,
            'text'       => "Title: {$title}\nBy: {$author}\n\n{$text}",
        ];
    }

    private function extractFromWebPage(string $url): array
    {
        $response = Http::timeout(20)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; bot/1.0)'])
            ->get($url);

        $html = $response->body();

        // Extract title
        preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $titleMatch);
        $title = html_entity_decode(trim($titleMatch[1] ?? ''));

        // Extract meta description
        preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\'](.*?)["\'][^>]*>/i', $html, $descMatch);
        $description = html_entity_decode(trim($descMatch[1] ?? ''));

        // Strip scripts, styles, nav, footer, header
        $html = preg_replace('/<(script|style|nav|footer|header)[^>]*>.*?<\/\1>/si', '', $html);

        // Convert block elements to newlines
        $html = preg_replace('/<(p|h[1-6]|li|br|div|section|article)[^>]*>/i', "\n", $html);

        // Strip remaining tags
        $text = strip_tags($html);

        // Collapse whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = trim($text);

        // Limit to ~8000 chars to avoid massive token usage
        if (strlen($text) > 8000) {
            $text = substr($text, 0, 8000) . '...';
        }

        return [
            'type'        => 'webpage',
            'title'       => $title,
            'description' => $description,
            'video_url'   => null,
            'source_url'  => $url,
            'text'        => "Title: {$title}\nDescription: {$description}\n\n{$text}",
        ];
    }

    private function parseYouTubeId(string $url): string
    {
        // Handle youtu.be/ID and youtube.com/watch?v=ID and /embed/ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }
        if (preg_match('/\/embed\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }
        return '';
    }
}
