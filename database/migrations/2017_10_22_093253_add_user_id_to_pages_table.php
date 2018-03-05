<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CoreClasses\Models\BaseModel;

class AddUserIdToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('slug', 'url');
            $table->renameColumn('title', 'h1');
            $table->integer('user_id')->comment('Ид кто добавил запись');
            $table->integer('active')->default(BaseModel::ACTIVE)->comment('Публикация');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
}
