<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use PdfReport;
use ExcelReport;
use App\Models\User;

class MapController extends Controller
{

    

  
    public function displayReport()
{
    $fromDate = '2020-01-01';
    $toDate = '2020-04-01';
    $sortBy = 'name';

    $title = 'Registered User Report'; // Report title

    $meta = [ // For displaying filters description on header
        'Registered on' => $fromDate . ' To ' . $toDate,
        'Sort By' => $sortBy
    ];

    $queryBuilder = User::select(['name', 'email', 'created_at']) // Do some querying..
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->orderBy($sortBy);

    $columns = [ // Set Column to be displayed
        'Name' => 'name',
        'Created At', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
        'Email' => 'email',
        'Status' => function($result) { // You can do if statement or any action do you want inside this closure
            return ($result->isActive==1) ? 'Active' : 'Not Active';
        }
    ];

    // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    return PdfReport::of($title, $meta, $queryBuilder, $columns)
                    ->editColumn('Created At', [ // Change column class or manipulate its data for displaying to report
                        'displayAs' => function($result) {
                            return $result->created_at->format('d M Y');
                        },
                        'class' => 'left'
                    ])
                    ->editColumns(['Email', 'Status'], [ // Mass edit column
                        'class' => 'right bold'
                    ])
                    ->limit(20) // Limit record to be showed
                    ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
}

}
