<?php

namespace App\Providers;

use App\CoreClasses\Helpers\StringHelper;
use App\Models\App\ArticleCategoryGetter;
use App\Models\App\ArticleGetter;
use App\Models\App\ImageGetter;
use App\Models\App\ManualGetter;
use App\Models\App\SiteSettingGetter;
use App\Models\App\VideoGetter;
use App\Models\App\VideoCategoryGetter;
use App\Models\App\ImageCategoryGetter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*  == CUSTOM VALIDATION RULES ==  */
        Validator::extend('unique_all_tables', function ($attribute, $value, $parameters, $validator) {
            if (ArticleGetter::getExistModel($value) ||
                ImageGetter::getExistModel($value) ||
                VideoGetter::getExistModel($value) ||
                ManualGetter::getExistModel($value) ||
                VideoCategoryGetter::getExistModel($value) ||
                ImageCategoryGetter::getExistModel($value) ||
                ArticleCategoryGetter::getExistModel($value)
            ) {
                return false;
            }
            return true;
        });

        /* == SOME VARIABLES IN VIEW == */
        View::share('breadcrumbs', []);
        /* == SOME MODELS IN VIEW == */
        View::share('stringHelper', new StringHelper());
        View::share('manualModel', new ManualGetter());
        View::share('articleModel', new ArticleGetter());
        View::share('siteSettingModel', new SiteSettingGetter());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
