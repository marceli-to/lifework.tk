<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class About extends Base
{
	use HasTranslations;

	protected $table = 'about';


	public $translatable = [
		'text',
	];

	protected $fillable = [
		'text',
		'publish',
  ];

	public function images()
	{
		return $this->hasMany('App\Models\AboutImage', 'about_id', 'id')->orderBy('order');
	}

	public function publishedImages()
	{
		return $this->hasMany('App\Models\AboutImage', 'about_id', 'id')->where('publish', '=', 1)->orderBy('order');
	}
}
