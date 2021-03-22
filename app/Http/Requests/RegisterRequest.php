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
      'type'           => 'required',
      'name'           => 'required',
      'firstname'      => 'required',
      'email'          => 'required|email:filter',
      'phone'          => 'required',
      'address'        => 'required',
      'participant_firstname' => 'required_if:type,2',
      'participant_name' => 'required_if:type,2',
      'participant_email' => 'required_if:type,2',
      'participant_phone' => 'required_if:type,2',
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
      'email.required' => [
        'field' => 'email',
        'error' => 'E-Mail wird benötigt!'
      ],
      'email.email' => [
        'field' => 'email',
        'error' => 'E-Mail ungültig!'
      ],
      'phone.required' => [
        'field' => 'phone',
        'error' => 'Telefon wird benötigt!'
      ],
      'address.required' => [
        'field' => 'address',
        'error' => 'Rechnungsadresse wird benötigt!'
      ],

      'participant_firstname.required_if' => [
        'field' => 'participant_firstname',
        'error' => 'Teilnehmer Vorname wird benötigt!'
      ],
      'participant_name.required_if' => [
        'field' => 'participant_name',
        'error' => 'Teilnehmer Name wird benötigt!'
      ],
      'participant_email.required_if' => [
        'field' => 'participant_email',
        'error' => 'Teilnehmer E-Mail wird benötigt!'
      ],
      'participant_phone.required_if' => [
        'field' => 'participant_phone',
        'error' => 'Teilnehmer Telefon wird benötigt!'
      ],
    ];
  }
}
