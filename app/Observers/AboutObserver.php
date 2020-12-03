<?php
namespace App\Observers;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class AboutObserver
{
  public function __construct(About $about)
  {
    $this->about = $about;
  }

  /**
   * Handle the about "created" event.
   *
   * @param  \App\Models\About $about
   * @return void
   */
  public function created(About $about)
  {
    //
  }

  /**
   * Handle the about "updated" event.
   *
   * @param  \App\Models\About $about
   * @return void
   */
  public function updated(About $about)
  {
    //
  }

  /**
   * Handle the about "deleting" event.
   *
   * @param  \App\Models\About $about
   * @return void
   */
  public function deleting(About $about)
  {
    $about = $this->about->with('images')->find($about->id);
    foreach($about->images as $image)
    {
      // Delete all images from storage
      $directories = Storage::allDirectories('public');
      foreach($directories as $d)
      {
        Storage::delete($d . '/'. $image->name);
      }
    }
  }

  /**
   * Handle the about "restored" event.
   *
   * @param  \App\Models\About $about
   * @return void
   */
  public function restored(About $about)
  {
    //
  }

  /**
   * Handle the about "force deleted" event.
   *
   * @param  \App\Models\About $about
   * @return void
   */
  public function forceDeleted(About $about)
  {
    //
  }
}
