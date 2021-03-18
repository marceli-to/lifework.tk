<?php
namespace App\Http\Controllers\Api;
use App\Models\Member;
use App\Models\MemberImage;
use App\Http\Resources\DataCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberImageController extends Controller
{
  protected $memberImage;
  
  /**
   * Constructor
   * 
   * @param MemberImage $memberImage
   */

  public function __construct(MemberImage $memberImage)
  {
    $this->memberImage = $memberImage;
  }

  /**
   * Get images for a member
   * 
   * @param Member $member
   * @return \Illuminate\Http\Response
   */
  public function get(Member $member)
  {
    $images = $this->memberImage->with('member')->where('member_id', '=', $member->id)->get();
    return new DataCollection($images);
  }

  /**
   * Store a newly added member image
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Store product image
    $memberImage = MemberImage::create($request->all());
    $memberImage->save();
    return response()->json(['memberImageId' => $memberImage->id]);
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
      $i = $this->memberImage->find($image['id']);
      $i->order = $image['order'];
      $i->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given image
   *
   * @param  MemberImage $memberImage
   * @return \Illuminate\Http\Response
   */
  public function toggle(MemberImage $memberImage)
  {
    $memberImage->publish = $memberImage->publish == 0 ? 1 : 0;
    $memberImage->save();
    return response()->json($memberImage->publish);
  }

  /**
   * Update the cropping coords of the specified resource.
   *
   * @param MemberImage $memberImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function coords(MemberImage $memberImage, Request $request)
  {
    $image = $this->memberImage->findOrFail($memberImage->id);
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
    $record = $this->memberImage->where('name', '=', $image)->first();
    
    if ($record)
    {
      $record->delete();
    }
    
    return response()->json('successfully deleted');
  }

  /**
   * Remove cached version of the image
   *
   * @param MemberImage $memberImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  private function removeCachedImage(MemberImage $memberImage)
  {
    // Get an instance of the ImageCache class
    $imageCache = new \Intervention\Image\ImageCache();

    // Get a cached image from it and apply all of your templates / methods
    $image = $imageCache->make(storage_path('app/public/uploads/') . $memberImage->name)->filter(new \App\Filters\Image\Template\Cache);

    // Remove the image from the cache by using its internal checksum
    Cache::forget($image->checksum());
  }
}
