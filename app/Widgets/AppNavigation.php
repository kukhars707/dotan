<?php

namespace App\Widgets;

use App\Models\App\MenuGetter;
use Arrilot\Widgets\AbstractWidget;

class AppNavigation extends AbstractWidget
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

        return view('widgets.app.navigation', [
            'menus' => MenuGetter::getAll(),
            'config' => $this->config,
        ]);
    }
}
