<?php
namespace App\Observers;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class MemberObserver
{
  public function __construct(Member $member)
  {
    $this->member = $member;
  }

  /**
   * Handle the member "created" event.
   *
   * @param  \App\Models\Member $member
   * @return void
   */
  public function created(Member $member)
  {
    //
  }

  /**
   * Handle the member "updated" event.
   *
   * @param  \App\Models\Member $member
   * @return void
   */
  public function updated(Member $member)
  {
    //
  }

  /**
   * Handle the member "deleting" event.
   *
   * @param  \App\Models\Member $member
   * @return void
   */
  public function deleting(Member $member)
  {
    $member = $this->member->with('images')->find($member->id);
    
    // Delete all images
    foreach($member->images as $image)
    {
      // Delete all images from storage
      $directories = Storage::allDirectories('public');
      foreach($directories as $d)
      {
        Storage::delete($d . '/'. $image->name);
      }
    }
    $member->images()->delete();

    // Delete all files
    foreach($member->files as $file)
    {
      // Delete all files from storage
      $directories = Storage::allDirectories('public');
      foreach($directories as $d)
      {
        Storage::delete($d . '/'. $file->name);
      }
    }

    $member->files()->delete();
  }

  /**
   * Handle the member "restored" event.
   *
   * @param  \App\Models\Member $member
   * @return void
   */
  public function restored(Member $member)
  {
    //
  }

  /**
   * Handle the member "force deleted" event.
   *
   * @param  \App\Models\Member $member
   * @return void
   */
  public function forceDeleted(Member $member)
  {
    //
  }
}
