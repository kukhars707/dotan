<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;

class SiteSettingGetter extends Model
{
    protected $table = 'settings';

    /**
     * @param string $key
     * @return string
     */
    public function getValue(string $key)
    {
        $model = self::where('key',$key)->first();
        if(!is_null($model)){
            return $model->value;
        }
        return 'Error with key';
    }
}
