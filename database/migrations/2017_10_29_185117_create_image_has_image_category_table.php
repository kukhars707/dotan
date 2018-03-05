<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageHasImageCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_has_image_category', function (Blueprint $table) {
            $table->integer('image_id')->comment('Ид изображения');
            $table->integer('image_category_id')->comment('Ид категории изображения');

            $table->primary(['image_id', 'image_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_has_image_category');
    }
}
