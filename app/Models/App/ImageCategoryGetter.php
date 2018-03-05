<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ImageCategoryGetter extends BaseModel
{
    protected $table = 'image_categories';
    protected $titleForCrumb = 'Картинки';
    protected $urlForCrumb = 'kartinki';
}
