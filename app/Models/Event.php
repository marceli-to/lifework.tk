<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Event extends Base
{
	protected $fillable = [
    'title',
    'host',
    'host_title',
    'category',
    'target_group',
    'date',
    'time',
    'duration',
    'location'
  ];
}
