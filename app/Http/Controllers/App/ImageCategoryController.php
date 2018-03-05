<?php

namespace App\Http\Controllers\App;

use App\CoreClasses\Controllers\BaseController;
use App\Models\App\ImageHasImageCategoryGetter;
use App\Models\App\ImageCategoryGetter;

class ImageCategoryController extends BaseController
{
    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($url)
    {
        $model = ImageCategoryGetter::getByUrl($url);

        return view($this->getView('image-category.index'), [
            'breadcrumbs' => ImageCategoryGetter::getBredcrumbsForModelById($model, 'ImageCategoryGetter'),
            'images' => ImageHasImageCategoryGetter::getImagesByCategoryId($model->id),
            'model' => $model
        ]);
    }
}