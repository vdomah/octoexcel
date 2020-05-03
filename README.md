# Excel plugin
This plugin is a wrapper for Maatwebsite/Laravel-Excel package. It adds convenient tools to import/export excel files.

If after installation you got any errors related to the maatwebsite/excel vendor not found: please run from your project's root
````
composer require maatwebsite/excel:3.1
````

The complete documentation can be found at: http://www.maatwebsite.nl/laravel-excel/docs

Please see the Upgrade Guide tab to understand the new code paradigm.

## Example using plugin 3.x Vdomah.Excel
drived by 3.x Maatwebsite.Excel

####Example export from page code section
````
use Vdomah\Excel\Classes\Excel;
use Vdomah\Excel\Classes\ExportExample;
function onStart()
{
    return Excel::export(ExportExample::class, 'my_export_filename');
}

// export class
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExample implements FromCollection, WithHeadings, WithEvents
{
    // set the headings
    public function headings(): array
    {
        return [
            'Company name', 'Flyer name', 'Co Company', 'Post Code', 'Online invitation', 'Pending'
        ];
    }

    // freeze the first row with headings
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->freezePane('A2', 'A2');
            },
        ];
    }

    // get the data
    public function collection()
    {
        $data = [];
// fill your export data
        return collect($data);
    }
}
````
####Example import
````
// importing data somewhere, e.g. in your CMS page:
function onStart()
{
    Excel::excel()->import(new PartsImport, $filePath);
}

// import class
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use RainLab\User\Models\User;

class ExampleImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // manipulate with imported data in $row; e.g. you got some $data formed;
        return User::create($data);
    }
}
````

####New export code paradigm

Now instead of closures in v2 you need to create new class to export your data in v3. 
The main goal while moving from v2 to v3 is to get your export data in collection() method of your Export class (see demo using faker).
Example export class is provided with plugin: 

## Examples using plugin 1.x Vdomah.Excel
Drived by 2.x Maatwebsite.Excel

## Usage
    use Vdomah\Excel\Classes\Excel;

    Excel::excel()->load(base_path() . '/storage/app/media/file.xlsx', function($reader) {

        dd($reader);

    });

### Importing a file

To start importing a file, you can use **->load($filename)**. The callback is optional.

    Excel::load('file.xls', function($reader) {

    // Getting all results
    $results = $reader->get();

    // ->all() is a wrapper for ->get() and will work the same
    $results = $reader->all();

    });

### Collections

Sheets, rows and cells are collections, this means after doing a **->get()** you can use all default collection methods.

    // E.g. group the results
    $reader->get()->groupBy('firstname');

Getting the first sheet or row

To get the first sheet or row, you can **utilise ->first()**.

    $reader->first();