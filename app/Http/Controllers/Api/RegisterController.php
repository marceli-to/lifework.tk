<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\EventSubscriber;
use App\Models\Event;
use App\Events\EventRegister;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function __construct(Event $event)
  {
    $this->event = $event;
  }

  /**
   * Store a newly created event
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(RegisterRequest $request)
  {
    $event = $this->event->findOrFail($request->event_id);

    $eventSubscriber = EventSubscriber::create($request->all());
    $eventSubscriber->event_title = $event->title;
    $eventSubscriber->event_date = $event->date;
    $eventSubscriber->save();

    // Trigger event
    event(new EventRegister($eventSubscriber));

    return response()->json(['eventSubscriberId' => $eventSubscriber->id]);
  }
}
