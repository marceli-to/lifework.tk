<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Organisation;
use App\Http\Requests\OrganisationStoreRequest;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
  public function __construct(Organisation $organisation)
  {
    $this->organisation = $organisation;
  }

  /**
   * Get a list of organisation
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->organisation->orderBy('order')->get());
  }

  /**
   * Get a single organisation for a given organisation or authenticated organisation
   * 
   * @param Organisation $organisation
   * @return \Illuminate\Http\Response
   */
  public function find(Organisation $organisation)
  {
    $organisation = $this->organisation->findOrFail($organisation->id);
    return response()->json($organisation);
  }

  /**
   * Store a newly created Organisation
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(OrganisationStoreRequest $request)
  {
    $organisation = Organisation::create($request->all());
    $organisation->save();
    return response()->json(['organisationId' => $organisation->id]);
  }

  /**
   * Update a Organisation for a given Organisation
   *
   * @param Organisation $organisation
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Organisation $organisation, OrganisationStoreRequest $request)
  {
    $organisation = $this->organisation->findOrFail($organisation->id);
    $organisation->update($request->all());
    $organisation->save();
    return response()->json('successfully updated');
  }

  /**
   * Update the order of the given organisations
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function order(Request $request)
  {
    $organisations = $request->get('organisations');
    foreach($organisations as $organisation)
    {
      $p = $this->organisation->find($organisation['id']);
      $p->order = $organisation['order'];
      $p->save(); 
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status a given Organisation
   *
   * @param  Organisation $organisation
   * @return \Illuminate\Http\Response
   */
  public function toggle(Organisation $organisation)
  {
    $organisation->publish = $organisation->publish == 0 ? 1 : 0;
    $organisation->save();
    return response()->json($organisation->publish);
  }

  /**
   * Remove a Organisation
   * \Observers\OrganisationObserver observes and deletes child elements.
   * @param  Organisation $organisation
   * @return \Illuminate\Http\Response
   */
  public function destroy(Organisation $organisation)
  {
    $organisation->delete();
    return response()->json('successfully deleted');
  }
}
