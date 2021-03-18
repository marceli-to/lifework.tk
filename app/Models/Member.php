<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Member extends Base
{
	protected $fillable = [
    'firstname',
    'name',
    'quote',
    'description',
    'text',
    'order',
		'publish',
		'category_id'
  ];

	public function images()
	{
		return $this->hasMany('App\Models\MemberImage', 'member_id', 'id');
	}

	public function publishedImages()
	{
		return $this->hasMany('App\Models\MemberImage', 'member_id', 'id')->where('publish', '=', 1);
	}

	public function files()
	{
		return $this->hasMany('App\Models\MemberFile', 'member_id', 'id');
	}

	public function publishedFiles()
	{
		return $this->hasMany('App\Models\MemberFile', 'member_id', 'id')->where('publish', '=', 1);
	}

	public function category()
	{
		return $this->hasOne('App\Models\MemberCategory', 'category_id', 'id');
	}
}
