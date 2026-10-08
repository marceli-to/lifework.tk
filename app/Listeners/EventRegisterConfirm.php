<?php
namespace App\Listeners;
use App\Events\EventRegister;
use App\Mail\RegistrationMail;
use App\Mail\ConfirmationMail;
use App\Models\EventSubscriber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class EventRegisterConfirm
{
  protected $eventSubscriber;

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(EventSubscriber $eventSubscriber)
  {
    $this->eventSubscriber = $eventSubscriber;
  }

  /**
   * Handle the event.
   *
   * @param  OrderCreate $event
   * @return void
   */
  public function handle(EventRegister $event)
  {
    // Get the subscriber
    $eventSubscriber = $event->eventSubscriber->find($event->eventSubscriber->id);

    // Send registration to owner
    $this->sendRegistration($eventSubscriber);
    
    // Send confirmation to subscriber
    $this->sendConfirmation($eventSubscriber);
  }

  /**
   * Send registration email
   * 
   * @param EventSubscriber $eventSubscriber
   * @return void
   */

  public function sendRegistration($eventSubscriber)
  {
    Mail::to(\Config::get('lifework.email.recipient'))
          ->send(
              new RegistrationMail(
                [
                  'eventSubscriber' => $eventSubscriber,
                ]
          )
    );
  }

  /**
   * Send confirmation email
   * 
   * @param EventSubscriber $eventSubscriber
   * @return void
   */

  public function sendConfirmation($eventSubscriber)
  {
    Mail::to($eventSubscriber->email)
          ->send(
              new ConfirmationMail(
                [
                  'eventSubscriber' => $eventSubscriber,
                ]
          )
    );
  }
}
