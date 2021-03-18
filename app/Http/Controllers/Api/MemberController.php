<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Member;
use App\Models\MemberImage;
use App\Models\MemberFile;
use App\Http\Requests\MemberStoreRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
  public function __construct(Member $member)
  {
    $this->member = $member;
  }

  /**
   * Get a list of member
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->member->orderBy('order')->get());
  }

  /**
   * Get a single member for a given member or authenticated member
   * 
   * @param Member $member
   * @return \Illuminate\Http\Response
   */
  public function find(Member $member)
  {
    $member = $this->member->with('images', 'files')->findOrFail($member->id);
    return response()->json($member);
  }

  /**
   * Store a newly created Member
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(MemberStoreRequest $request)
  {
    $member = Member::create($request->all());
    $member->save();

    // Store images
    if (!empty($request->images))
    {
      foreach($request->images as $i)
      {
        $image = new MemberImage([
          'member_id'   => $member->id,
          'name'        => $i['name'],
          'caption'     => $i['caption'],
          'coords_w'    => $i['coords_w'] ? round($i['coords_w'], 12) : NULL,
          'coords_h'    => $i['coords_h'] ? round($i['coords_h'], 12) : NULL,
          'coords_x'    => $i['coords_x'] ? round($i['coords_x'], 12) : NULL,
          'coords_y'    => $i['coords_y'] ? round($i['coords_y'], 12) : NULL,
          'publish'     => $i['publish'] ? $i['publish'] : 0,
          'orientation' => $i['orientation'] ? $i['orientation'] : NULL,
        ]);
        $image->save();
      }
    }

    if (!empty($request->files))
    {
      foreach($request->files as $i)
      {
        $file = new MemberFile([
          'member_id'   => $member->id,
          'name'        => $i['name'],
          'caption'     => $i['caption'],
          'publish'     => $i['publish'] ? $i['publish'] : 0,
        ]);
        $file->save();
      }
    }

    return response()->json(['memberId' => $member->id]);
  }

  /**
   * Update a Member for a given Member
   *
   * @param Member $member
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Member $member, MemberStoreRequest $request)
  {
    $member = $this->member->findOrFail($member->id);
    $member->update($request->all());
    $member->save();

    // Update or add images
    if (!empty($request->images))
    {
      foreach($request->images as $i)
      {        
        $image = MemberImage::updateOrCreate(
          ['id' => $i['id']], 
          [
            'member_id'      => $member->id,
            'name'         => $i['name'],
            'caption'      => $i['caption'],
            'coords_w'     => $i['coords_w'] ? round($i['coords_w'], 12) : NULL,
            'coords_h'     => $i['coords_h'] ? round($i['coords_h'], 12) : NULL,
            'coords_x'     => $i['coords_x'] ? round($i['coords_x'], 12) : NULL,
            'coords_y'     => $i['coords_y'] ? round($i['coords_y'], 12) : NULL,
            'publish'      => $i['publish'] ? $i['publish'] : 0,
            'orientation'  => $i['orientation'] ? $i['orientation'] : NULL,
          ]
        );
      }
    }

    // Update or add files
    if (!empty($request->files))
    {
      foreach($request->files as $i)
      {        
        $file = MemberFile::updateOrCreate(
          ['id' => $i['id']], 
          [
            'member_id'      => $member->id,
            'name'         => $i['name'],
            'caption'      => $i['caption'],
            'publish'      => $i['publish'] ? $i['publish'] : 0,
          ]
        );
      }
    }

    return response()->json('successfully updated');
  }

  /**
   * Update the order of the given members
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function order(Request $request)
  {
    $members = $request->get('member');
    foreach($members as $member)
    {
      $p = $this->member->find($member['id']);
      $p->order = $member['order'];
      $p->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given Member
   *
   * @param  Member $member
   * @return \Illuminate\Http\Response
   */
  public function toggle(Member $member)
  {
    $member->publish = $member->publish == 0 ? 1 : 0;
    $member->save();
    return response()->json($member->publish);
  }

  /**
   * Remove a Member
   * \Observers\MemberObserver observes and deletes child elements.
   * @param  Member $member
   * @return \Illuminate\Http\Response
   */
  public function destroy(Member $member)
  {
    $member->delete();
    return response()->json('successfully deleted');
  }
}
