<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;

class MenuGetter extends Model
{
    protected $table = 'menu_items';

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return self::orderBy('rgt', 'asc')->get();
    }
}
