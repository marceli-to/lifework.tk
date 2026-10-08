<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Member;
use Illuminate\Http\Request;

class TeamController extends BaseController
{
  protected $member;

  protected $viewPath = 'web.pages.';

  protected $category = 2;

  public function __construct(Member $member)
  {
    parent::__construct();
    $this->member = $member;
  }

  /**
   * Member
   */

  public function index()
  {
    $members = $this->member->with('publishedImages', 'publishedFiles')->published()->where('category_id', '=', $this->category)->get();
    return view($this->viewPath . 'team', ['title' => 'Team', 'members' => $members]);
  }
}
