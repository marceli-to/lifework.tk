<?php
namespace App\Observers;
use App\Models\MemberImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class MemberImageObserver
{
  protected $memberImage;

  public function __construct(MemberImage $memberImage)
  {
    $this->memberImage = $memberImage;
  }

  /**
   * Handle the memberImage "created" event.
   *
   * @param  \App\Models\MemberImage $memberImage
   * @return void
   */
  public function created(MemberImage $memberImage)
  {
    //
  }

  /**
   * Handle the memberImage "updated" event.
   *
   * @param  \App\Models\MemberImage $memberImage
   * @return void
   */
  public function updated(MemberImage $memberImage)
  {
    //
  }

  /**
   * Handle the memberImage "deleting" event.
   *
   * @param  \App\Models\MemberImage $memberImage
   * @return void
   */
  public function deleting(MemberImage $memberImage)
  {
    $directories = Storage::allDirectories('public');
    foreach($directories as $d)
    {
      Storage::delete($d . '/'. $memberImage->name);
    }
  }

  /**
   * Handle the memberImage "restored" event.
   *
   * @param  \App\Models\MemberImage $memberImage
   * @return void
   */
  public function restored(MemberImage $memberImage)
  {
    //
  }

  /**
   * Handle the memberImage "force deleted" event.
   *
   * @param  \App\Models\MemberImage $memberImage
   * @return void
   */
  public function forceDeleted(MemberImage $memberImage)
  {
    //
  }
}
