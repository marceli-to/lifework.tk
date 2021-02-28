<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Event extends Base
{
	protected $fillable = [
    'category',
    'title',
    'description',
    'target_group',
    'date',
    'time',
    'location',
    'host',
    'host_title',
    'cost',
    'dateDeadline',
    'hasForm',
    'email',
    'state',
    'dateShowUntil',
    'isBildungskrippe',
    'isKita',
    'isLeadership',
    'isCompany',
    'isOther',
  ];

  protected $casts = [
    'dateDeadline' => 'date:d.m.Y',
    'dateShowUntil' => 'date:d.m.Y',
  ];

  /**
   * Scope for upcoming events
   */

	public function scopeUpcoming($query)
	{
		$constraint = date('Y-m-d', time());
		return $query->where('dateShowUntil', '>=', $constraint)->orWhere('dateShowUntil', '=', NULL);
  }
  
  /**
   * Get bookable attribute
   */
  public function getBookableAttribute()
  {
    $constraint = date('Y-m-d', time());
    if ($this->dateDeadline >= $constraint || $this->dateDeadline == NULL)
    {
      return TRUE;
    }
    return FALSE;
  }

}
