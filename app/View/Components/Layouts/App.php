<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class App extends Component
{
    /**
     * The page title.
     *
     * @var string|null
     */
    public $title;

    /**
     * Additional styles to inject into the head.
     *
     * @var string|null
     */
    public $styles;

    /**
     * Additional scripts to inject before closing body.
     *
     * @var string|null
     */
    public $scripts;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $title
     * @param  string|null  $styles
     * @param  string|null  $scripts
     * @return void
     */
    public function __construct($title = null, $styles = null, $scripts = null)
    {
        $this->title = $title;
        $this->styles = $styles;
        $this->scripts = $scripts;
    }

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('layouts.app');
    }
}
