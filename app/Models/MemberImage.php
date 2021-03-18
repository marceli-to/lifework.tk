<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class MemberImage extends Base
{
	protected $fillable = [
		'name',
    'caption',
		'coords_w',
    'coords_h',
    'coords_x',
    'coords_y',
    'orientation',
    'publish',
    'order',
    'member_id',
  ];
  
  protected $appends = ['coords'];

  public function member()
  {
    return $this->belongsTo('App\Models\Member');
  }

  /**
   * Get coords as string
   */
  
  public function getCoordsAttribute()
  {
    if ($this->coords_w && $this->coords_h && $this->coords_y && $this->coords_x)
    {
      return $this->coords_w . ',' . $this->coords_h . ',' . $this->coords_x . ',' . $this->coords_y;
    }
    return '';
	}
}
