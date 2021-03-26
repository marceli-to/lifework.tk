@component('mail::message')
<h1>Bestägung Anmeldung</h1>
<p>Vielen Dank für Ihre Anmeldung, welche wir gerne wie folgt bestätigen:</p>
<div class="table">
  <table cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td style="width: 175px;">Veranstaltung</td>
        <td>{{$eventSubscriber->event_title}}</td>
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
        <td>Bemerkungen</td>
        <td>{!! nl2br($eventSubscriber->remarks) !!}</td>
      </tr>
      <tr>
        <td>Organisation</td>
        <td>{{$eventSubscriber->organisation}}</td>
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