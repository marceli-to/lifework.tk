<?php
namespace App\Events;
use App\Models\EventSubscriber;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventRegister
{
  use Dispatchable, SerializesModels;
  
  /**
   * Create a new event instance.
   * 
   * @param EventSubscriber $eventSubscriber
   * @return void
   */
  public function __construct(EventSubscriber $eventSubscriber)
  {
    $this->eventSubscriber = $eventSubscriber;
  }
}
