<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends BaseController
{
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
   * Themen
   */

  public function topics()
  {
    return view($this->viewPath . 'topics', ['title' => 'Themen']);
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
    $posts = $this->post->published()->orderBy('date', 'DESC')->get();
    return view($this->viewPath . 'blog', ['title' => 'Blog', 'posts' => $posts]);
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
