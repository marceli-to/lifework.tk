<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $dates = ['date'];

	protected $fillable = [
    'date',
    'title',
    'text',
		'publish',
  ];

  /**
   * Get the full date
   *
   * @return string
   */
  public function getDateStrAttribute()
  {
    return strftime('%d. %B %Y', strtotime($this->date->format('d.m.Y')));
  }

  /**
   * Get the full date with weekday
   *
   * @return string
   */
  public function getDateStrFullAttribute()
  {
    return strftime('%A,  %d. %B %Y', strtotime($this->date->format('d.m.Y')));
  }
}
