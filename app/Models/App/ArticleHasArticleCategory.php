<?php

namespace App\Models\App;

use App\CoreClasses\Models\BaseModel;

class ArticleHasArticleCategory extends BaseModel
{
    protected $table = 'article_has_article_category';

    /**
     * @param int $categoryId
     * @return mixed
     */
    public static function getModelsByCategoryId(int $categoryId)
    {
        return self::select(['url','h1','image'])
            ->where('article_has_article_category.article_category_id',$categoryId)
            ->join('articles','article_has_article_category.article_id','=','articles.id')
            ->isActive('articles')
            ->sort('articles')
            ->paginate();
    }
}
