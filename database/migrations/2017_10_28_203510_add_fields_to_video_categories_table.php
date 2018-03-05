<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CoreClasses\Models\BaseModel;

class AddFieldsToVideoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_categories', function (Blueprint $table) {
            $table->string('url')->comment('Ссылка на категорию');
            $table->string('h1')->comment('h1 на категорию');
            $table->string('name')->comment('Имя для админки');
            $table->string('meta_title')->comment('meta-title');
            $table->string('meta_description')->nullable()->comment('meta-description');
            $table->integer('sort')->nullable()->comment('Поле сортировки');
            $table->integer('user_id')->comment('ИД кто добавил');
            $table->boolean('active')->comment('Ссылка на категорию');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_categories', function (Blueprint $table) {
            //
        });
    }
}
