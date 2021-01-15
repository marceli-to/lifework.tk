<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'event_id'       => 'required|exists:App\Models\Event,id',
      'name'           => 'required',
      'firstname'      => 'required',
      'street'         => 'required',
      'location'       => 'required',
      'phone_private'  => 'required',
      'email'          => 'required|email:filter',
    ];
  }

  /**
   * Custom message for validation
   *
   * @return array
   */
  public function messages()
  {
    return [
      'event_id.required' => [
        'field' => 'event_id',
        'error' => 'Event wird benötigt!'
      ],
      'event_id.exists' => [
        'field' => 'event_id',
        'error' => 'Kein Event mit dieser Id vorhanden!'
      ],
      'name.required' => [
        'field' => 'name',
        'error' => 'Name wird benötigt!'
      ],
      'firstname.required' => [
        'field' => 'firstname',
        'error' => 'Vorname wird benötigt!'
      ],
      'street.required' => [
        'field' => 'street',
        'error' => 'Strasse / Nr. wird benötigt!'
      ],
      'location.required' => [
        'field' => 'location',
        'error' => 'PLZ / Ort wird benötigt!'
      ],
      'phone_private.required' => [
        'field' => 'phone_private',
        'error' => 'Telefon (P) wird benötigt!'
      ],
      'email.required' => [
        'field' => 'email',
        'error' => 'E-Mail wird benötigt!'
      ],
      'email.email' => [
        'field' => 'email',
        'error' => 'E-Mail ungültig!'
      ],
    ];
  }
}
