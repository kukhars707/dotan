<?php

namespace App\Widgets;

use App\Models\App\ImageGetter;
use Arrilot\Widgets\AbstractWidget;

class NewImage extends AbstractWidget
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

        return view('widgets.app.new_image', [
            'config' => $this->config,
            'lastImage' => ImageGetter::getFirst()
        ]);
    }
}
