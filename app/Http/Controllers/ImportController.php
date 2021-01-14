<?php
namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Imports\EventsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends BaseController
{
  public $filename = 'events.xlsx';

  public function __construct(Event $event)
  {
    $this->event = $event;
  }

  public function import()
  { 
    $file = storage_path('app/public/uploads') . '/' . $this->filename;
    if (file_exists($file))
    {
      // Clear table
      $this->event->truncate();

      // Import
      Excel::import(new EventsImport, $file, null, \Maatwebsite\Excel\Excel::XLSX);
    }
  }
}
