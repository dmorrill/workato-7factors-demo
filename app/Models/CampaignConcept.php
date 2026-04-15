<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignConcept extends Model
{
    protected $fillable = ['campaign_id', 'sort_order', 'number', 'name', 'principle'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
