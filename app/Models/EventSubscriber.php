<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EventSubscriber extends Base
{
	protected $fillable = [
    'firstname',
    'name',
    'email',
    'phone',
    'organisation',
    'address',
    'participant_firstname',
    'participant_name',
    'type',
    'remarks',
    'is_member',
    'event_title',
    'event_date',
    'event_time',
    'event_location',
  ];
}