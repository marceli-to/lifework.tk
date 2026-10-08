<?php
namespace App\Observers;
use App\Models\MemberFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class MemberFileObserver
{
  protected $memberFile;

  public function __construct(MemberFile $memberFile)
  {
    $this->memberFile = $memberFile;
  }

  /**
   * Handle the memberFile "created" event.
   *
   * @param  \App\Models\MemberFile $memberFile
   * @return void
   */
  public function created(MemberFile $memberFile)
  {
    //
  }

  /**
   * Handle the memberFile "updated" event.
   *
   * @param  \App\Models\MemberFile $memberFile
   * @return void
   */
  public function updated(MemberFile $memberFile)
  {
    //
  }

  /**
   * Handle the memberFile "deleting" event.
   *
   * @param  \App\Models\MemberFile $memberFile
   * @return void
   */
  public function deleting(MemberFile $memberFile)
  {
    $directories = Storage::allDirectories('public');
    foreach($directories as $d)
    {
      Storage::delete($d . '/'. $memberFile->name);
    }
  }

  /**
   * Handle the memberFile "restored" event.
   *
   * @param  \App\Models\MemberFile $memberFile
   * @return void
   */
  public function restored(MemberFile $memberFile)
  {
    //
  }

  /**
   * Handle the memberFile "force deleted" event.
   *
   * @param  \App\Models\MemberFile $memberFile
   * @return void
   */
  public function forceDeleted(MemberFile $memberFile)
  {
    //
  }
}
