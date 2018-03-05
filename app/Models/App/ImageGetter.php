<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ImageGetter extends BaseModel
{
    protected $table = 'images';
    protected $titleForCrumb = 'Картинки';
    protected $urlForCrumb = 'kartinki';
    protected $parentFieldPivot = 'image_category_id';
}
