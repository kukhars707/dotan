<?php

namespace App\CoreClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    public static $bread;

    const NOT_ACTIVE = 0;
    const ACTIVE = 1;

    const COUNT_PAGINATE_NEXT_AND_PREVIOS = 2;
    const SHOW_MODELS = 5;

    /**
     * @param $category
     * @return mixed
     */
    public static function getRelationModelsByCategoryId($category)
    {
        return self::select(['url', 'h1', 'image'])
            ->where($category->getPivotTable() . '.' . $category->getPivotField(), $category->id)
            ->orWhere($category->getJoinTableName() . '.' . $category->getPivotField(), $category->id)
            ->rightJoin($category->getJoinTableName(), $category->getPivotTable() . '.' . $category->getPivotField(), '=', $category->getJoinTableName() . '.' . $category->getJoinField())
            ->isActive($category->getJoinTableName())
            ->sort($category->getJoinTableName())
            ->paginate(self::SHOW_MODELS);
    }

    /**
     * @param $model
     * @param $pivot
     * @return array
     */
    public static function getBredcrumbsForModelById($model, $pivot)
    {
        $output = [];
        $className = "App\Models\App\\$pivot";
        $modelCategory = new $className();

        $pivotField = $model->getParentPivotField();

        if (is_object($modelCategory) && !is_null($model->$pivotField) || (get_class($modelCategory) && get_class($model) && !is_null($model->$pivotField))) {
            $firstParent = $modelCategory::find($model->$pivotField);
            array_unshift($output, ['title' => $firstParent->getH1(), 'url' => $firstParent->getUrl()]);
            if ($firstParent->parent_id) {
                $secondParent = $modelCategory::find($firstParent->parent_id);
                array_unshift($output, ['title' => $secondParent->getH1(), 'url' => $secondParent->getUrl()]);
                if ($secondParent->parent_id) {
                    $thirdParent = $modelCategory::find($secondParent->parent_id);
                    array_unshift($output, ['title' => $thirdParent->getH1(), 'url' => $thirdParent->getUrl()]);
                }
            }
            array_unshift($output, ['title' => $model->getTitleForCrumb(), 'url' => $model->getUrlForCrumb()]);
        } else {
            $output[] = ['title' => $model->getTitleForCrumb(), 'url' => $model->getUrlForCrumb(), 'withCategory' => true];
        }

        return $output;
    }

    /**
     * @param $url
     * @return mixed
     */
    public static function getExistModel($url)
    {
        return self::where('url', $url)->exists();
    }

    /**
     * @return mixed
     */
    public function getTitleForCrumb()
    {
        return $this->titleForCrumb;
    }

    /**
     * @return mixed
     */
    public function getUrlForCrumb()
    {
        return $this->urlForCrumb;
    }

    /**
     * @return mixed
     */
    public function getJoinTableName()
    {
        return $this->joinTable;
    }

    /**
     * @return mixed
     */
    public function getJoinField()
    {
        if ($this->joinFieldTable) {
            return $this->joinFieldTable;
        }
        return 'id';
    }

    /**
     * @return mixed
     */
    public function getPivotField()
    {
        if ($this->pivotField) {
            return $this->pivotField;
        }
        return 'parent_id';
    }

    /**
     * @return mixed
     */
    public function getPivotTable()
    {
        return $this->pivotManyTable;
    }

    /**
     * @return mixed
     */
    public function getParentPivotField()
    {
        if ($this->parentFieldPivot) {
            return $this->parentFieldPivot;
        }
        return 'parent_id';
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getLast($limit = 5)
    {
        return self::isActive()
            ->sort()
            ->get()
            ->take($limit);
    }

    /**
     * @return mixed
     */
    public static function getFirst()
    {
        return self::isActive()
            ->sort()
            ->first();
    }

    /**
     * @param array $array
     * @return mixed
     */
    public static function getWithoutIds(array $array = [], $limit = 8)
    {
        return self::whereNotIn('id', $array)
            ->isActive()
            ->sort()
            ->get()
            ->take($limit);
    }

    /**
     * @return mixed
     */
    public static function getAllActive($limit = 10)
    {
        return self::isActive()
            ->sort()
            ->paginate($limit);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRandomModels($limit = 3)
    {
        return self::orderByRaw("RAND()")
            ->isActive()
            ->get()
            ->take($limit);
    }

    /**
     * @param string $url
     * @return mixed
     */
    public static function getByUrl(string $url)
    {
        $model = self::isActive()->where('url', $url)->first();

        if ($model) {
            return $model;
        }
        abort(403, 'Страница неактивна');
    }

    /**
     * return string || abort
     */
    public function getName()
    {
        $model = $this->user;
        if ($model) {
            return $model->name;
        }
        return abort(403, 'Not have user_id');
    }

    /**
     * @param array $attr
     * @param array $array
     */
    public static function storeInsert(array $attr, array $array)
    {
        if (count($attr) && count($array)) {
            $array = [];
            foreach ($array as $item) {
                $array[] = [
                    $attr['parent_key'] => $attr['key'],
                    $attr['second_key'] => $item
                ];
            }

            self::insert($array);
        }
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function removeRecords($field, $value)
    {
        return self::where($field, $value)->delete();
    }

    /**
     * @return mixed|void
     */
    public function getUrl()
    {
        return $this->url ? $this->url : abort(404, 'Error with link');
    }

    /**
     * @return mixed|void
     */
    public function getH1()
    {
        return $this->h1 ? $this->h1 : abort(404, 'Error with h1');
    }

    /**
     * @return mixed|void
     */
    public function getDescription()
    {
        return $this->description ? $this->description : null;
    }

    /**
     * @return mixed|string
     */
    public function getImage()
    {
        return $this->image ? $this->image : "/images/assets/r_13.jpg";
    }

    /**
     * @return mixed|string
     */
    public function getAltImage()
    {
        return $this->alt_image ? $this->alt_image : $this->name;
    }

    /*** === RELATIONSHIPS === ***/
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    /*** === SCOPES === ***/

    public function scopeIsActive($query, $tableArg = null)
    {
        $table = is_null($tableArg) ? $this->table : $tableArg;
        return $query->where("$table.active", self::ACTIVE);
    }

    /**
     * @param $query
     * @param null $tableArg
     * @return mixed
     */
    public function scopeSort($query, $tableArg = null)
    {
        $table = is_null($tableArg) ? $this->table : $tableArg;
        return $query->orderBy("$table.sort", 'desc')->orderBy('id', 'desc');
    }

    /*** === CHECKERS === ***/

    /**
     * @param $array
     * @return mixed
     */
    public static function checkUrl(array $array)
    {
        $validator = Validator::make($array,
            [
                'url' => 'unique_all_tables'
            ],
            [
                'url.unique_all_tables' => 'Данная ссылка уже есть в базе выберите другую'
            ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
