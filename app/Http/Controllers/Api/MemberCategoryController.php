<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\MemberCategory;
use Illuminate\Http\Request;

class MemberCategoryController extends Controller
{
  public function __construct(MemberCategory $memberCategory)
  {
    $this->memberCategory = $memberCategory;
  }

  /**
   * Get a list of memberCategory
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->memberCategory->get());
  }

  /**
   * Get a single memberCategory for a given memberCategory or authenticated memberCategory
   * 
   * @param MemberCategory $memberCategory
   * @return \Illuminate\Http\Response
   */
  public function find(MemberCategory $memberCategory)
  {
    $memberCategory = $this->memberCategory->findOrFail($memberCategory->id);
    return response()->json($memberCategory);
  }

}
