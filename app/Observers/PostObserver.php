<?php
namespace App\Observers;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
  public function __construct(Post $post)
  {
    $this->post = $post;
  }

  /**
   * Handle the post "created" event.
   *
   * @param  \App\Models\Post $post
   * @return void
   */
  public function created(Post $post)
  {
    //
  }

  /**
   * Handle the post "updated" event.
   *
   * @param  \App\Models\Post $post
   * @return void
   */
  public function updated(Post $post)
  {
    //
  }

  /**
   * Handle the post "deleting" event.
   *
   * @param  \App\Models\Post $post
   * @return void
   */
  public function deleting(Post $post)
  {
    $post = $this->post->with('images')->find($post->id);
    foreach($post->images as $image)
    {
      // Delete all images from storage
      $directories = Storage::allDirectories('public');
      foreach($directories as $d)
      {
        Storage::delete($d . '/'. $image->name);
      }
    }

    $post->images()->delete();
  }

  /**
   * Handle the post "restored" event.
   *
   * @param  \App\Models\Post $post
   * @return void
   */
  public function restored(Post $post)
  {
    //
  }

  /**
   * Handle the post "force deleted" event.
   *
   * @param  \App\Models\Post $post
   * @return void
   */
  public function forceDeleted(Post $post)
  {
    //
  }
}
