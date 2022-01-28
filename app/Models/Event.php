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
    'fmid'
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

  /**
   * Scope for "Bildungskrippen"
   */

	public function scopeNurseries($query)
	{
    $constraint = date('Y-m-d', time());
    return 
      $query->where('isBildungskrippe', '=', '1')
            ->where(function ($query) use ($constraint) {
              $query->where('dateShowUntil', '>=', $constraint)
                    ->orWhere('dateShowUntil', '=', NULL);
    });
  }

  /**
   * Scope for "Kita"
   */

	public function scopeKitas($query)
	{
    $constraint = date('Y-m-d', time());
    return 
      $query->where('isKita', '=', '1')
            ->where(function ($query) use ($constraint) {
              $query->where('dateShowUntil', '>=', $constraint)
                    ->orWhere('dateShowUntil', '=', NULL);
    });
  }

  /**
   * Scope for "Führungspersonen"
   */

	public function scopeLeaders($query)
	{
    $constraint = date('Y-m-d', time());
    return 
      $query->where('isLeadership', '=', '1')
            ->where(function ($query) use ($constraint) {
              $query->where('dateShowUntil', '>=', $constraint)
                    ->orWhere('dateShowUntil', '=', NULL);
    });
  }

  /**
   * Scope for "Unternehmen"
   */

	public function scopeCompanies($query)
	{
    $constraint = date('Y-m-d', time());
    return 
      $query->where('isCompany', '=', '1')
            ->where(function ($query) use ($constraint) {
              $query->where('dateShowUntil', '>=', $constraint)
                    ->orWhere('dateShowUntil', '=', NULL);
    });
  }

  /**
   * Scope for "Andere"
   */

	public function scopeOther($query)
	{
    $constraint = date('Y-m-d', time());
    return 
      $query->where('isOther', '=', '1')
            ->where(function ($query) use ($constraint) {
              $query->where('dateShowUntil', '>=', $constraint)
                    ->orWhere('dateShowUntil', '=', NULL);
    });
  }

}
