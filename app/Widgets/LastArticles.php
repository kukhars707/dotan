<?php

namespace App\Widgets;

use App\Models\App\ArticleGetter;
use Arrilot\Widgets\AbstractWidget;

class LastArticles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.app.last_articles', [
            'config' => $this->config,
            'lastArticles' => ArticleGetter::getLast()
        ]);
    }
}
