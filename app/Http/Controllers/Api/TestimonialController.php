<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Testimonial;
use App\Http\Requests\TestimonialStoreRequest;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
  public function __construct(Testimonial $testimonial)
  {
    $this->testimonial = $testimonial;
  }

  /**
   * Get a list of testimonial
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->testimonial->orderBy('order')->get());
  }

  /**
   * Get a single testimonial for a given testimonial or authenticated testimonial
   * 
   * @param Testimonial $testimonial
   * @return \Illuminate\Http\Response
   */
  public function find(Testimonial $testimonial)
  {
    $testimonial = $this->testimonial->findOrFail($testimonial->id);
    return response()->json($testimonial);
  }

  /**
   * Store a newly created Testimonial
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(TestimonialStoreRequest $request)
  {
    $testimonial = Testimonial::create($request->all());
    $testimonial->save();
    return response()->json(['testimonialId' => $testimonial->id]);
  }

  /**
   * Update a Testimonial for a given Testimonial
   *
   * @param Testimonial $testimonial
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Testimonial $testimonial, TestimonialStoreRequest $request)
  {
    $testimonial = $this->testimonial->findOrFail($testimonial->id);
    $testimonial->update($request->all());
    $testimonial->save();
    return response()->json('successfully updated');
  }

  /**
   * Update the order of the given testimonials
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function order(Request $request)
  {
    $testimonials = $request->get('testimonials');
    foreach($testimonials as $testimonial)
    {
      $p = $this->testimonial->find($testimonial['id']);
      $p->order = $testimonial['order'];
      $p->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given Testimonial
   *
   * @param  Testimonial $testimonial
   * @return \Illuminate\Http\Response
   */
  public function toggle(Testimonial $testimonial)
  {
    $testimonial->publish = $testimonial->publish == 0 ? 1 : 0;
    $testimonial->save();
    return response()->json($testimonial->publish);
  }

  /**
   * Remove a Testimonial
   * \Observers\TestimonialObserver observes and deletes child elements.
   * @param  Testimonial $testimonial
   * @return \Illuminate\Http\Response
   */
  public function destroy(Testimonial $testimonial)
  {
    $testimonial->delete();
    return response()->json('successfully deleted');
  }
}
