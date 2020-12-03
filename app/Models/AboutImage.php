<?php
namespace App\Models;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AboutImage extends Base
{
  use HasTranslations;

	public $translatable = [
    'caption'
	];

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
    'about_id',
	];

  public function about()
  {
    return $this->belongsTo('App\Models\About');
  }
}
