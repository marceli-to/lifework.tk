@extends('web.layout.app')
@section('seo_title', 'Veranstaltungen')
@section('content')
<section class="site__content theme-dark">
  @if ($events)
    @foreach($events as $e)
      <article class="content-list content-list--events">
        <div class="content-list__inner">
          <a href="javascript:;" class="btn-arrow @if ($loop->first) is-first @endif js-btn-article"></a>
          <h3>{{$e->category}}</h3>
          <h2><a href="javascript:;" class="js-btn-article">{{$e->title}}</a></h2>
          <div class="content-list__body is-hidden">
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            <p>Vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            <div class="list">
              @if ($e->date)
                <div class="list__item">
                  Datum: {{$e->date}}
                </div>
              @endif
              @if ($e->time)
                <div class="list__item">
                  Zeiten: {{$e->time}}
                </div>
              @endif
              @if ($e->location)
                <div class="list__item">
                  Ort: {{$e->location}}
                </div>
              @endif
              @if ($e->host)
                <div class="list__item">
                  Moderator/in: {{$e->host}}
                </div>
              @endif
              @if ($e->cost)
                <div class="list__item">
                  Kosten: CHF 300
                </div>
              @endif
              <div class="list__item list__item--button">
                <a href="javascript:;" class="btn-primary js-btn-form">buchen</a>
              </div>
            </div>
          </div>
        </div>
        <form class="events is-hidden">
          @csrf
          <input type="hidden" name="event_id" value="{{$e->id}}">
          <div>
            <header>Ja, ich melde mich an</header>
            <div class="form-group">
              <label>Vorname</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>Strasse / Nr.</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>PLZ / Ort</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>Telefon P</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>Telefon G</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group">
              <label>E-Mail</label>
              <input type="text" value="" name="">
            </div>
            <div class="form-group-checkbox">
              <div>
                <input type="checkbox" name="toc" value="1" id="toc">
                <div class="checkbox"><span></span></div>
              </div>
              <label for="toc">Ich bin mit den <a href="{{route('page.toc')}}" target="_blank">AGBs</a> einverstanden</label>
            </div>
            <div class="form-group form-group-button">
              <input type="submit" class="btn-primary" value="anmelden">
            </div>
          </div>
        </form>
      </article>        
    @endforeach
  @endif
</section>
@endsection