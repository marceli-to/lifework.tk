<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
  public $data;

  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $mail = $this->from([ 'address' => \Config::get('lifework.email.from'), 'name' => \Config::get('lifework.company')])
                 ->subject('Anmeldung für ' . $this->data['eventSubscriber']->event_title)
                 ->with(['eventSubscriber' => $this->data['eventSubscriber']])
                 ->markdown('mail.registration');
    return $mail;
  }
}
