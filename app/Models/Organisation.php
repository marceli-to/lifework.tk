<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Base
{
	protected $fillable = [
    'title',
    'text',
    'publish',
    'order',
  ];
}
