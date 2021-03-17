<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Post extends Base
{
	protected $fillable = [
    'date',
    'title',
    'text',
		'publish',
  ];

	public function images()
	{
		return $this->hasMany('App\Models\PostImage', 'post_id', 'id')->orderBy('order');
	}

	public function publishedImages()
	{
		return $this->hasMany('App\Models\PostImage', 'post_id', 'id')->where('publish', '=', 1)->orderBy('order');
	}
}
