<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct(People $people)
  {
    parent::__construct();
    $this->people = $people;
  }

  /**
   * People
   */

  public function index()
  {
    $people = $this->people->published()->get();
    return view($this->viewPath . 'people', ['title' => 'Veranstaltungen', 'people' => $people]);
  }
}
