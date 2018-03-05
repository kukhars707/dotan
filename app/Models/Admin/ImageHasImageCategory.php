<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseAdminModel;

class ImageHasImageCategory extends BaseAdminModel
{
    public $timestamps = false;

    protected $table = 'image_has_image_category';
    protected $fillable = ['image_id','image_category_id'];


}
