@component('mail::message')
## Neue Anmeldung für «{{$eventSubscriber->event_title}}»
<div class="table">
  <table cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td style="min-width: 120px;">Veranstaltung</td>
        <td>{{$eventSubscriber->event_title}}</td>
      </tr>
      <tr>
        <td>Datum</td>
        <td>{{$eventSubscriber->event_date}}</td>
      </tr>
      <tr>
        <td>Name</td>
        <td>{{$eventSubscriber->name}}</td>
      </tr>
      <tr>
        <td>Vorname</td>
        <td>{{$eventSubscriber->firstname}}</td>
      </tr>
      <tr>
        <td>Strasse / Nr.</td>
        <td>{{$eventSubscriber->street}}</td>
      </tr>
      <tr>
        <td>PLZ / Ort</td>
        <td>{{$eventSubscriber->location}}</td>
      </tr>
      <tr>
        <td>Telefon (G)</td>
        <td>{{$eventSubscriber->phone_business}}</td>
      </tr>
      <tr>
        <td>Telefon (P)</td>
        <td>{{$eventSubscriber->phone_private}}</td>
      </tr>
      <tr>
        <td>E-Mail</td>
        <td>{{$eventSubscriber->email}}</td>
      </tr>
    </tbody>
  </table>
</div>
<p class="signature">
  Freundliche Grüsse<br>lifework tk
</p>
@endcomponent