<?php
namespace App\Http\Controllers\Api;
use App\Models\Member;
use App\Models\MemberFile;
use App\Http\Resources\DataCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberFileController extends Controller
{
  protected $memberFile;
  
  /**
   * Constructor
   * 
   * @param MemberFile $memberFile
   */

  public function __construct(MemberFile $memberFile)
  {
    $this->memberFile = $memberFile;
  }

  /**
   * Get files for a member
   * 
   * @param Member $member
   * @return \Illuminate\Http\Response
   */
  public function get(Member $member)
  {
    $files = $this->memberFile->with('member')->where('member_id', '=', $member->id)->get();
    return new DataCollection($files);
  }

  /**
   * Store a newly added member file
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Store product file
    $memberFile = MemberFile::create($request->all());
    $memberFile->save();
    return response()->json(['memberFileId' => $memberFile->id]);
  }

  /**
   * Update the order of the given files
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function order(Request $request)
  {
    $files = $request->get('files');
    foreach($files as $file)
    {
      $i = $this->memberFile->find($file['id']);
      $i->order = $file['order'];
      $i->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given file
   *
   * @param  MemberFile $memberFile
   * @return \Illuminate\Http\Response
   */
  public function toggle(MemberFile $memberFile)
  {
    $memberFile->publish = $memberFile->publish == 0 ? 1 : 0;
    $memberFile->save();
    return response()->json($memberFile->publish);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  string $file
   * @return \Illuminate\Http\Response
   */
  
  public function destroy($file)
  {
    // Delete file from database
    $record = $this->memberFile->where('name', '=', $file)->first();
    
    if ($record)
    {
      $record->delete();
    }
    
    return response()->json('successfully deleted');
  }
}
