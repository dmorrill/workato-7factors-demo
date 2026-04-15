<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignMakerController extends Controller
{
    public function index()
    {
        $campaigns = \App\Models\Campaign::latest()->get();
        return view('make.index', compact('campaigns'));
    }

    public function create()
    {
        return view('make.create');
    }

    public function store(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $extractor  = new \App\Services\ContentExtractorService();
        $generator  = new \App\Services\CampaignGeneratorService();

        $extracted  = $extractor->extract($request->input('url'));
        $generated  = $generator->generate($extracted);

        $landing    = $generated['landing'];
        $packages   = $generated['packages'];

        // Build slug from title
        $slug = \Illuminate\Support\Str::slug($landing['title'] ?? 'campaign-' . time());
        // Ensure unique
        $base = $slug;
        $i = 1;
        while (\App\Models\Campaign::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        $campaign = \App\Models\Campaign::create([
            'slug'              => $slug,
            'source_url'        => $request->input('url'),
            'source_type'       => $extracted['type'],
            'video_url'         => $extracted['video_url'] ?? null,
            'title'             => $landing['title'] ?? $extracted['title'] ?? 'Untitled',
            'hero_headline'     => $landing['hero_headline'] ?? '',
            'hero_subheadline'  => $landing['hero_subheadline'] ?? '',
            'framework_name'    => $landing['framework_name'] ?? '',
            'framework_intro'   => $landing['framework_intro'] ?? '',
            'context_headline'  => $landing['context_headline'] ?? null,
            'context_body'      => $landing['context_body'] ?? null,
            'cta_headline'      => $landing['cta_headline'] ?? null,
            'cta_body'          => $landing['cta_body'] ?? null,
            'extracted_content' => $extracted['text'],
            'status'            => 'draft',
        ]);

        foreach ($landing['concepts'] ?? [] as $i => $concept) {
            $campaign->concepts()->create([
                'sort_order' => $i,
                'number'     => $concept['number'] ?? str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'name'       => $concept['name'] ?? '',
                'principle'  => $concept['principle'] ?? '',
            ]);
        }

        foreach ($packages as $pkg) {
            $campaign->packages()->create([
                'channel' => $pkg['channel'],
                'title'   => $pkg['title'],
                'copy'    => $pkg['copy'],
                'status'  => 'pending',
            ]);
        }

        return redirect()->route('make.show', $campaign->id);
    }

    public function show(\App\Models\Campaign $campaign)
    {
        $campaign->load(['concepts', 'packages']);
        return view('make.show', compact('campaign'));
    }

    public function updatePackage(Request $request, \App\Models\Campaign $campaign, \App\Models\CampaignPackage $package)
    {
        $request->validate(['status' => 'required|in:pending,approved,skipped']);
        $package->update(['status' => $request->input('status')]);
        return back();
    }

    public function publish(\App\Models\Campaign $campaign)
    {
        $campaign->update(['status' => 'published']);
        return back()->with('success', 'Campaign published.');
    }

    public function landingPage(string $slug)
    {
        $campaign = \App\Models\Campaign::where('slug', $slug)
            ->where('status', 'published')
            ->with('concepts')
            ->firstOrFail();

        return view('generated.landing', compact('campaign'));
    }

    public function campaignPage(string $slug)
    {
        $campaign = \App\Models\Campaign::where('slug', $slug)
            ->where('status', 'published')
            ->with(['concepts', 'packages'])
            ->firstOrFail();

        return view('generated.campaign', compact('campaign'));
    }
}
