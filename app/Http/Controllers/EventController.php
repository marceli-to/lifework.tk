<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends BaseController
{
  protected $event;

  protected $viewPath = 'web.pages.';

  public function __construct(Event $event)
  {
    parent::__construct();
    $this->event = $event;
  }

  /**
   * Events
   */

  public function index()
  {
    $events = $this->event->upcoming()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Event
   * 
   * @param String $slug
   * @param Event $event
   */

  public function show($slug, Event $event)
  {
    $event = $this->event->findOrFail($event->id);
    return view($this->viewPath . 'event-show', ['title' => 'Veranstaltungen', 'event' => $event]);
  }

  /**
   * Events > Bildungskrippen
   */

  public function nurseries()
  {
    $events = $this->event->nurseries()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Events > Kita
   */

  public function kitas()
  {
    $events = $this->event->kitas()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Events > Führungspersonen
   */

  public function leaders()
  {
    $events = $this->event->leaders()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Events > Unternehmen
   */

  public function companies()
  {
    $events = $this->event->companies()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Events > Unternehmen
   */

  public function other()
  {
    $events = $this->event->other()->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }
}
