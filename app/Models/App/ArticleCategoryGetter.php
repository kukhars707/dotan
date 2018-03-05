<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ArticleCategoryGetter extends BaseModel
{
    protected $table = 'article_categories';
    protected $titleForCrumb = 'Статьи';
    protected $urlForCrumb = 'stati';
}
