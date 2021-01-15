<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class EventSubscriber extends Base
{
	protected $fillable = [
    'name',
    'firstname',
    'street',
    'location',
    'phone_business',
    'phone_private',
    'email',
    'event_title',
    'event_date',
  ];
}