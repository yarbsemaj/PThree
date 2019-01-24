<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 15/01/19
 * Time: 16:25
 */

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'layouts.results', 'App\Http\View\Composers\ResultsComposer'
        );

        View::composer(
            'layouts.results-wide', 'App\Http\View\Composers\ResultsComposer'
        );

        View::composer(
            "layouts.test.show", 'App\Http\View\Composers\TestDetailsComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}