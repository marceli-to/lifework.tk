@component('mail::message')
# Anmeldung für «{{$eventSubscriber->event_title}}»
<div class="table">
  <table cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td style="min-width: 175px;">Veranstaltung</td>
        <td>{{$eventSubscriber->event_title}}</td>
      </tr>
      <tr>
        <td>Datum</td>
        <td>{{$eventSubscriber->event_date}}</td>
      </tr>
      <tr>
        <td>Datum</td>
        <td>{{$eventSubscriber->event_date}}</td>
      </tr>
      <tr>
        <td>Zeit</td>
        <td>{{$eventSubscriber->event_time}}</td>
      </tr>
      <tr>
        <td>Ort</td>
        <td>{{$eventSubscriber->event_location}}</td>
      </tr>
      <tr>
        <td>Vorname</td>
        <td>{{$eventSubscriber->firstname}}</td>
      </tr>
      <tr>
        <td>Name</td>
        <td>{{$eventSubscriber->name}}</td>
      </tr>
      <tr>
        <td>Telefon</td>
        <td>{{$eventSubscriber->phone}}</td>
      </tr>
      <tr>
        <td>E-Mail</td>
        <td>{{$eventSubscriber->email}}</td>
      </tr>
      <tr>
        <td>Rechnungsadresse</td>
        <td>{!! nl2br($eventSubscriber->address) !!}</td>
      </tr>
      <tr>
        <td>Organisation</td>
        <td>{{$eventSubscriber->organisation}}</td>
      </tr>
      <tr>
        <td>Mitglied</td>
        <td>{{ $eventSubscriber->is_member == 1 ? 'Ja' : 'Nein' }}</td>
      </tr>
      @if ($eventSubscriber->type == 2)
        <tr>
          <td colspan="2"><br>Daten Teilnehmer*in</td>
        </tr>
        <tr>
          <td>Vorname</td>
          <td>{{$eventSubscriber->participant_firstname}}</td>
        </tr>
        <tr>
          <td>Name</td>
          <td>{{$eventSubscriber->participant_name}}</td>
        </tr>
        <tr>
          <td>E-Mail</td>
          <td>{{$eventSubscriber->participant_email}}</td>
        </tr>
        <tr>
          <td>Telefon</td>
          <td>{{$eventSubscriber->participant_phone}}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
<p class="signature">
  Freundliche Grüsse<br>
  lifework tk ag<br>
  Untere Vogelsangstrasse 11<br>
  8400 Winterthur<br>
  mail@lifework.ch
</p>
@endcomponent