<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ImageHasImageCategoryGetter extends BaseModel
{
    protected $table = 'image_has_image_category';
    public $pivotField = 'image_id';

    /**
     * @param int $categoryId
     * @return mixed
     */
    public static function getImagesByCategoryId(int $categoryId)
    {
        return self::select(['url','h1','image'])
            ->where('image_has_image_category.image_category_id',$categoryId)
            ->join('images','image_has_image_category.image_id','=','images.id')
            ->isActive('images')
            ->sort('images')
            ->paginate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function images()
    {
        return $this->hasOne('App\Models\App\ImageGetter', 'id', 'image_id');
    }
}
