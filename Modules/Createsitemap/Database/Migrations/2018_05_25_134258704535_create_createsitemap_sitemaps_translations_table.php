<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreatesitemapSitemapsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('createsitemap__sitemaps_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('sitemaps_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['sitemaps_id', 'locale']);
            $table->foreign('sitemaps_id')->references('id')->on('createsitemap__sitemaps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('createsitemap__sitemaps_translations', function (Blueprint $table) {
            $table->dropForeign(['sitemaps_id']);
        });
        Schema::dropIfExists('createsitemap__sitemaps_translations');
    }
}
