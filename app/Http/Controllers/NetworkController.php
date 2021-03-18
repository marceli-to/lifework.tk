<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Member;
use App\Models\Organisation;
use Illuminate\Http\Request;

class NetworkController extends BaseController
{
  protected $viewPath = 'web.pages.';

  protected $category = 1;

  public function __construct(Member $member, Organisation $organisation)
  {
    parent::__construct();
    $this->member = $member;
    $this->organisation = $organisation;
  }

  /**
   * Members
   */

  public function members()
  {
    $members = $this->member->with('publishedImages', 'publishedFiles')->published()->where('category_id', '=', $this->category)->get();
    return view($this->viewPath . 'network-members', ['title' => 'Personen', 'members' => $members]);
  }

  /**
   * Organisations
   */

  public function organisations()
  {
    $organisations = $this->organisation->published()->orderBy('order')->get();
    return view($this->viewPath . 'network-organisations', ['title' => 'Organisationen', 'organisations' => $organisations]);
  }
}
