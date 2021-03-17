<?php
namespace App\Http\Controllers\Api;
use App\Models\Post;
use App\Models\PostImage;
use App\Http\Resources\DataCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostImageController extends Controller
{
  protected $postImage;
  
  /**
   * Constructor
   * 
   * @param PostImage $postImage
   */

  public function __construct(PostImage $postImage)
  {
    $this->postImage = $postImage;
  }

  /**
   * Get images for a post
   * 
   * @param Post $post
   * @return \Illuminate\Http\Response
   */
  public function get(Post $post)
  {
    $images = $this->postImage->with('post')->where('post_id', '=', $post->id)->get();
    return new DataCollection($images);
  }

  /**
   * Store a newly added post image
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Store product image
    $postImage = PostImage::create($request->all());
    $postImage->save();
    return response()->json(['postImageId' => $postImage->id]);
  }

  /**
   * Update the order of the given images
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function order(Request $request)
  {
    $images = $request->get('images');
    foreach($images as $image)
    {
      $i = $this->postImage->find($image['id']);
      $i->order = $image['order'];
      $i->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given image
   *
   * @param  PostImage $postImage
   * @return \Illuminate\Http\Response
   */
  public function toggle(PostImage $postImage)
  {
    $postImage->publish = $postImage->publish == 0 ? 1 : 0;
    $postImage->save();
    return response()->json($postImage->publish);
  }

  /**
   * Update the cropping coords of the specified resource.
   *
   * @param PostImage $postImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function coords(PostImage $postImage, Request $request)
  {
    $image = $this->postImage->findOrFail($postImage->id);
    $image->coords_w = round($request->input('coords_w'), 12);
    $image->coords_h = round($request->input('coords_h'), 12);
    $image->coords_x = round($request->input('coords_x'), 12);
    $image->coords_y = round($request->input('coords_y'), 12);
    $image->save();
    $this->removeCachedImage($image);
    return response()->json('successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  string $image
   * @return \Illuminate\Http\Response
   */
  
  public function destroy($image)
  {
    // Delete image from database
    $record = $this->postImage->where('name', '=', $image)->first();
    
    if ($record)
    {
      $record->delete();
    }
    
    return response()->json('successfully deleted');
  }

  /**
   * Remove cached version of the image
   *
   * @param PostImage $postImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  private function removeCachedImage(PostImage $postImage)
  {
    // Get an instance of the ImageCache class
    $imageCache = new \Intervention\Image\ImageCache();

    // Get a cached image from it and apply all of your templates / methods
    $image = $imageCache->make(storage_path('app/public/uploads/') . $postImage->name)->filter(new \App\Filters\Image\Template\Cache);

    // Remove the image from the cache by using its internal checksum
    Cache::forget($image->checksum());
  }
}
