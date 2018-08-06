# Excel plugin
This plugin is a wrapper for Maatwebsite/Laravel-Excel package. It adds convenient tools to import/export excel files.

The complete documentation can be found at: http://www.maatwebsite.nl/laravel-excel/docs

## Usage
        use Vdomah\Excel\Classes\Excel;

        Excel::excel()->load(base_path() . '/storage/app/media/file.xlsx', function($reader) {

            dd($reader);

        });

### Importing a file

To start importing a file, you can use __->load($filename)__. The callback is optional.

        Excel::load('file.xls', function($reader) {

        // Getting all results  
        $results = $reader->get();

        // ->all() is a wrapper for ->get() and will work the same  
        $results = $reader->all();

        });

### Collections

Sheets, rows and cells are collections, this means after doing a __->get()__ you can use all default collection methods.

        // E.g. group the results  
        $reader->get()->groupBy('firstname');

Getting the first sheet or row

To get the first sheet or row, you can __utilise ->first()__.

        $reader->first();
