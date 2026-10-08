<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends BaseController
{
  protected $post;

  protected $viewPath = 'web.pages.';

  public function __construct(Post $post)
  {
    parent::__construct();
    $this->post = $post;
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
   * Bildungskrippen
   */

  public function nursery()
  {
    return view($this->viewPath . 'nursery', ['title' => 'Bildungskrippen']);
  }

  /**
   * Über uns
   */

  public function about()
  {
    return view($this->viewPath . 'about', ['title' => 'Über uns']);
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
