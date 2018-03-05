<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseModel;

class ArticleHasArticles extends BaseModel
{
    public $timestamps = false;

    protected $table = 'article_has_articles';
    protected $fillable = ['parent_article_id', 'article_id'];

    /**
     * @param $id
     * @return mixed
     */
    public static function getArticleByParentId($id)
    {
        return self::where('parent_article_id', $id)->pluck('article_id')->toArray();
    }
}
