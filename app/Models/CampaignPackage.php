<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignPackage extends Model
{
    protected $fillable = ['campaign_id', 'channel', 'title', 'copy', 'status'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function channelLabel(): string
    {
        return match($this->channel) {
            'blog'       => 'Blog post',
            'linkedin'   => 'LinkedIn',
            'twitter'    => 'Twitter / X',
            'newsletter' => 'Newsletter',
            'video'      => 'Video script',
            'tutorial'   => 'Developer tutorial',
            default      => ucfirst($this->channel),
        };
    }
}
