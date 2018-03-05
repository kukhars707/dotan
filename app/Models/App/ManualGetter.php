<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ManualGetter extends BaseModel
{
    protected $table = 'manuals';
    protected $titleForCrumb = 'Гайды';
    protected $urlForCrumb = 'gaydy';
}
