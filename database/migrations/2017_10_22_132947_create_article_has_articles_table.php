<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleHasArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_has_articles', function (Blueprint $table) {
            $table->integer('parent_article_id')->comment('ИД к какой статте прикреплять другие статьи');
            $table->integer('article_id')->comment('ИД прикрепленной статьи');

            $table->primary(['parent_article_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_has_articles');
    }
}
