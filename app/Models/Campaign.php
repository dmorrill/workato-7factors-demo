<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'slug', 'name', 'source_url', 'source_urls', 'source_type', 'video_url', 'title',
        'hero_headline', 'hero_subheadline', 'framework_name', 'framework_intro',
        'context_headline', 'context_body', 'cta_headline', 'cta_body',
        'extracted_content', 'status', 'personas',
    ];

    protected $casts = [
        'personas'    => 'array',
        'source_urls' => 'array',
    ];

    /** Display name: user-provided name if set, otherwise generated title. */
    public function displayName(): string
    {
        return $this->name ?: ($this->title ?: 'Untitled');
    }

    public function concepts()
    {
        return $this->hasMany(CampaignConcept::class)->orderBy('sort_order');
    }

    public function packages()
    {
        return $this->hasMany(CampaignPackage::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
