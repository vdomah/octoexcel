<?php namespace Vdomah\Excel;

use System\Classes\PluginBase;
use App;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        // Register service providers
        App::register('\Maatwebsite\Excel\ExcelServiceProvider');

        $facade = AliasLoader::getInstance();
        $facade->alias('Excel', '\Maatwebsite\Excel\Facades\Excel');
        $excel = App::make('excel');
    }
}
