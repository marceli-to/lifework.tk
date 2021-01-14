<?php
namespace App\Tasks;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Imports\Events;
use Maatwebsite\Excel\Facades\Excel;

class EventsImport
{
  public function __invoke()
  {
    $file = storage_path('app/public/uploads') . '/events.xlsx';
    if (file_exists($file))
    {
      // Clear table
      \App\Models\Event::truncate();

      // Import
      \Excel::import(new \App\Imports\Events, $file, null, \Maatwebsite\Excel\Excel::XLSX);
    }
  }
}