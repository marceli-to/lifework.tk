<?php
namespace App\Http\Controllers\Api;
use App\Models\File as FileModel;
use App\Models\Event as EventModel;
use App\Imports\Events;
use \Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\DataCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use DB;

class FileController extends Controller
{
  protected $file;
  
  /**
   * Constructor
   * 
   * @param FileModel $file
   */

  public function __construct(FileModel $file)
  {
    $this->file = $file;
  }

  /**
   * Get a list of files for listing
   * 
   * @return \Illuminate\Http\Response
   */
  public function fetch()
  {
    return new DataCollection($this->file->get());
  }

  /**
   * Store a newly uploaded file
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $file = FileModel::create($request->all());
    $file->save();
    return response()->json(['id' => $file->id]);
  }

  /**
   * Import a file
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function import(FileModel $file)
  {
    $new_file = storage_path('app/public/uploads') . '/' . $file->name;
    if (file_exists($new_file))
    {
      // Delete any backups
      Schema::dropIfExists('events_backup');

      // Create new backup
      DB::statement('CREATE TABLE events_backup LIKE events;');
      DB::statement('INSERT INTO events_backup SELECT * FROM events;');

      // Clear table
      EventModel::truncate();

      // Import new data
      \Excel::import(new \App\Imports\Events, $new_file, null, \Maatwebsite\Excel\Excel::XLSX);
      $file->delete();
      Schema::dropIfExists('events_backup');
    }

    return response()->json(['id' => $file->id]);
  }

  /**
   * Restore from backup
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function restore()
  {
    Schema::dropIfExists('events');
    Schema::rename('events_backup', 'events');
    FileModel::truncate();
    return response()->json('successfully restored');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param FileModel $file
   * @return \Illuminate\Http\Response
   */
  
  public function destroy(FileModel $file)
  {
    // Delete image from database
    $record = $this->file->findOrFail($file->id);
    if ($record)
    {
      $record->delete();
    }
    return response()->json('successfully deleted');
  }

}
