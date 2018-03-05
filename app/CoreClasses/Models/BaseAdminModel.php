<?php
/**
 * Created by PhpStorm.
 * User: Виталик
 * Date: 29.10.2017
 * Time: 0:30
 */

namespace App\CoreClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BaseAdminModel extends Model
{
    const NOT_ACTIVE = 0;
    const ACTIVE = 1;

    /*** === FUNCTIONS === ***/

    public function getClassForStatus()
    {
        return $this->active == self::NOT_ACTIVE ? 'disabled' : '';
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function getExistsModel($field, $value)
    {
        return self::where($field, $value)->exists();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getRelationsModel($id, $field, $pluck)
    {
        return self::where($field, $id)->pluck($pluck)->toArray();
    }

    /**
     * @param array $attr
     * @param array $array
     */
    public static function storeInsert(array $attr, array $array)
    {
        if (count($attr) && count($array)) {
            $arrayInsert = [];
            foreach ($array as $item) {
                $arrayInsert[] = [
                    $attr['parent_key'] => $attr['key'],
                    $attr['second_key'] => $item
                ];
            }
            self::insert($arrayInsert);
        }
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function removeByFieldAndValue($field, $value)
    {
        return self::where($field, $value)->delete();

    }
}