<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct(Event $event)
  {
    parent::__construct();
    $this->event = $event;
  }

  public function index()
  {
    $events = $this->event->get();
    return view($this->viewPath . 'events', ['title' => 'Veranstaltungen', 'events' => $events]);
  }

  /**
   * Veranstaltungen
   */

  public function thankYou()
  {
    return view($this->viewPath . 'events-thank-you', ['title' => 'Veranstaltungen']);
  }


}
