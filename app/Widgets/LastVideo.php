<?php

namespace App\Widgets;

use App\Models\App\VideoGetter;
use Arrilot\Widgets\AbstractWidget;

class LastVideo extends AbstractWidget
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

        return view('widgets.app.last_video', [
            'config' => $this->config,
            'lastVideo' => VideoGetter::getFirst()
        ]);
    }
}
