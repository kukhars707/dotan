<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ArticleGetter extends BaseModel
{
    use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;

    protected $table = 'articles';
    protected static $breadcrumbs = [];
    protected $titleForCrumb = 'Статьи';
    protected $urlForCrumb = 'stati';
    protected $parentFieldPivot = 'category_article_id';


    /**
     * how much show articles
     */
    const COUNT_SHOW_LAST = 5;

    /**
     * how much get articles in bd
     */
    const COUNT_GET_ARTICLES_IN_ARTICLE = 2;

    /**
     * @return array
     */
    public static function getBredcrumbsForAll()
    {
        return self::$breadcrumbs = [

        ];
    }
}
