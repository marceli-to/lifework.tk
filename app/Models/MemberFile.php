<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class MemberFile extends Base
{
	protected $fillable = [
    'name',
    'size',
    'type',
    'caption',
    'order',
    'publish',
    'member_id',
  ];

  public function member()
  {
    return $this->belongsTo('App\Models\Member');
  }

}
