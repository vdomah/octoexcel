<?php namespace Vdomah\Excel\Classes;

use October\Rain\Support\Traits\Singleton;
use Maatwebsite\Excel\Sheet;

class Excel
{
    use Singleton;

    protected $excel;

    protected function init()
    {
        \App::register('\Maatwebsite\Excel\ExcelServiceProvider');

        $facade = \Illuminate\Foundation\AliasLoader::getInstance();
        $facade->alias('Excel', '\Maatwebsite\Excel\Facades\Excel');

        $this->excel = \App::make('excel');

        Sheet::macro('freezePane', function (Sheet $sheet, $pane) {
            $sheet->getDelegate()->getActiveSheet()->freezePane($pane);  // <-- https://stackoverflow.com/questions/49678273/setting-active-cell-for-excel-generated-by-phpspreadsheet
        });

        \PhpOffice\PhpSpreadsheet\IOFactory::registerReader('xlsx_styled', XlsxStyled::class);
    }
    
    public static function excel()
    {
        return self::instance()->excel;
    }

    public static function export($object, $filename, $type = 'csv')
    {
        if (is_string($object) && class_exists($object)) {
            $object = new $object;
        }

        return self::excel()->download($object, $filename.'.'.$type);
    }

    public static function import($object, $file_path)
    {
        if (is_string($object) && class_exists($object)) {
            $object = new $object;
        }

        return self::excel()->import($object, $file_path);
    }

}