<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CoreClasses\Models\BaseModel;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->comment('Ссылка');
            $table->string('h1')->comment('H1');
            $table->string('name')->comment('Имя для админки');
            $table->string('text')->comment('Текст статьи');
            $table->string('meta_title')->comment('Мета тайтл');
            $table->text('meta_description')->nullable()->comment('Мета дескрипшн');
            $table->string('image')->nullable()->comment('Превью изображение');
            $table->string('alt_image')->comment('alt изображению');
            $table->integer('sort')->nullable()->comment('Сортировка');
            $table->integer('user_id')->comment('Кто добавил');
            $table->boolean('active')->default(BaseModel::ACTIVE)->comment('Публикация');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
