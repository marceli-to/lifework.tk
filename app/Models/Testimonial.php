<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Base
{
	protected $fillable = [
    'title',
    'text',
    'publish',
    'order',
  ];
}
