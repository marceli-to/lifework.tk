<?php
namespace App\Observers;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PostImageObserver
{
  protected $postImage;

  public function __construct(PostImage $postImage)
  {
    $this->postImage = $postImage;
  }

  /**
   * Handle the postImage "created" event.
   *
   * @param  \App\Models\PostImage $postImage
   * @return void
   */
  public function created(PostImage $postImage)
  {
    //
  }

  /**
   * Handle the postImage "updated" event.
   *
   * @param  \App\Models\PostImage $postImage
   * @return void
   */
  public function updated(PostImage $postImage)
  {
    //
  }

  /**
   * Handle the postImage "deleting" event.
   *
   * @param  \App\Models\PostImage $postImage
   * @return void
   */
  public function deleting(PostImage $postImage)
  {
    $directories = Storage::allDirectories('public');
    foreach($directories as $d)
    {
      Storage::delete($d . '/'. $postImage->name);
    }
  }

  /**
   * Handle the postImage "restored" event.
   *
   * @param  \App\Models\PostImage $postImage
   * @return void
   */
  public function restored(PostImage $postImage)
  {
    //
  }

  /**
   * Handle the postImage "force deleted" event.
   *
   * @param  \App\Models\PostImage $postImage
   * @return void
   */
  public function forceDeleted(PostImage $postImage)
  {
    //
  }
}
