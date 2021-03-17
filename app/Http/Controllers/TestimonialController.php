<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends BaseController
{
  protected $viewPath = 'web.pages.';

  public function __construct(Testimonial $testimonial)
  {
    parent::__construct();
    $this->testimonial = $testimonial;
  }

  /**
   * Testimonial
   */

  public function index()
  {
    $testimonials = $this->testimonial->published()->orderBy('order')->get();
    return view($this->viewPath . 'testimonial', ['title' => 'Stimmen', 'testimonials' => $testimonials]);
  }
}
