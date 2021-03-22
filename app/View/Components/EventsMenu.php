<?php
namespace App\View\Components;
use App\Models\Event;
use Illuminate\View\Component;

class EventsMenu extends Component
{ 

  public $events = [];

  /**
   * Create a new component instance.
   *
   * @param $type
   * @return void
   */
  public function __construct(Event $event)
  {
    $this->event = $event;
    $this->events['nurseries'] = $this->event->nurseries()->get();
    $this->events['kitas'] = $this->event->kitas()->get();
    $this->events['leaders'] = $this->event->leaders()->get();
    $this->events['companies'] = $this->event->companies()->get();
    $this->events['other'] = $this->event->other()->get();
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.menu.events');
  }
}
