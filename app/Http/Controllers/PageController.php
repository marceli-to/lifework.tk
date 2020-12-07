<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PageController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Home
   */

  public function index()
  { 
    return view($this->viewPath . 'home');
  }

  /**
   * Angebot
   */

  public function services()
  {
    return view($this->viewPath . 'services', ['title' => 'Angebot']);
  }

  /**
   * Themen
   */

  public function topics()
  {
    return view($this->viewPath . 'topics', ['title' => 'Themen']);
  }

  /**
   * Veranstaltungen
   */

  public function events()
  {
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen']);
  }

  /**
   * Über uns
   */

  public function about()
  {
    return view($this->viewPath . 'about', ['title' => 'Über uns']);
  }

  /**
   * Team
   */

  public function team()
  {
    return view($this->viewPath . 'team', ['title' => 'Team']);
  }

  /**
   * Netzwerk
   */

  public function network()
  {
    return view($this->viewPath . 'network', ['title' => 'Netzwerk']);
  }

  /**
   * Blog
   */

  public function blog()
  {
    return view($this->viewPath . 'blog', ['title' => 'Blog']);
  }

  /**
   * AGB
   */

  public function toc()
  {
    return view($this->viewPath . 'toc', ['title' => 'AGB']);
  }

  /**
   * Kontakt
   */

  public function contact()
  {
    return view($this->viewPath . 'contact', ['title' => 'Kontakt']);
  }
}
