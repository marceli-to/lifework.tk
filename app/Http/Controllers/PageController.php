<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Post;
use App\Models\Event;
use Illuminate\Http\Request;

class PageController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct(Post $post, Event $event)
  {
    parent::__construct();
    $this->post = $post;
    $this->event = $event;
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
    $events = $this->event->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
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

  public function partner()
  {
    return view($this->viewPath . 'partner', ['title' => 'Partner']);
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
