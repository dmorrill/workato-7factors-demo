<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('source_url');
            $table->string('source_type')->default('webpage'); // webpage | youtube
            $table->string('video_url')->nullable();
            $table->string('title');
            $table->string('hero_headline');
            $table->text('hero_subheadline');
            $table->string('framework_name');
            $table->text('framework_intro');
            $table->string('context_headline')->nullable();
            $table->text('context_body')->nullable();
            $table->string('cta_headline')->nullable();
            $table->text('cta_body')->nullable();
            $table->longText('extracted_content')->nullable();
            $table->string('status')->default('draft'); // draft | published
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
