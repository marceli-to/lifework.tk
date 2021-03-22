<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data = array())
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
    $mail = $this->from(['address' => \Config::get('lifework.email.from'), 'name' => \Config::get('lifework.company')])
                 ->subject($this->data['eventSubscriber']->event_title)
                 ->with(['eventSubscriber' => $this->data['eventSubscriber']])
                 ->markdown('mail.confirmation');
    return $mail;
  }
}
