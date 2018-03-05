<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->comment('Ссылка на категорию');
            $table->string('h1')->comment('h1 на категорию');
            $table->string('name')->comment('Имя для админки');
            $table->string('meta_title')->comment('meta-title');
            $table->string('meta_description')->nullable()->comment('meta-description');
            $table->integer('sort')->nullable()->comment('Поле сортировки');
            $table->integer('user_id')->comment('ИД кто добавил');
            $table->text('description')->nullable()->comment('Описание категории');
            $table->integer('parent_id')->nullable()->comment('ИД категории родител');
            $table->boolean('active')->comment('Ссылка на категорию');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->integer('image_category_id')->nullable()->comment('Ид категории изображения');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_categories');
    }
}
