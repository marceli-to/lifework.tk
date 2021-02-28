@extends('web.layout.app')
@section('seo_title', 'Veranstaltungen')
@section('content')
<section class="site__content theme-dark" id="app">
  @if ($events)
    @foreach($events as $e)
      <article class="content-list content-list--events">
        <div class="content-list__inner">
          <a href="javascript:;" class="btn-arrow @if ($loop->first) is-first @endif js-btn-article"></a>
          <h3>{{$e->category}}</h3>
          <h2><a href="javascript:;" class="js-btn-article">{{$e->title}}</a></h2>
          <div class="content-list__body is-hidden">
            @if ($e->description)
              <p>{!! $e->description !!}</p>
            @endif
            <div class="list">
              @if ($e->target_group)
                <div class="list__item">
                  Zielgruppe: {{$e->target_group}}
                </div>
              @endif
              @if ($e->date)
                <div class="list__item">
                  Datum: {{$e->date}}
                </div>
              @endif
              @if ($e->time)
                <div class="list__item">
                  Zeit: {{$e->time}}
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
                  Kosten: {{$e->cost}}
                </div>
              @endif
              @if ($e->state != 'Ausgebucht' && $e->bookable)
                <div class="list__item list__item--button">
                  @if ($e->hasForm)
                    <a href="javascript:;" class="btn-primary js-btn-form">buchen</a>
                  @else
                    <a href="mailto:{{$e->email}}?subject=Anfrage%20Termin%20«{{$e->title}}» – lifework.ch" class="btn-primary">kontakt</a>
                  @endif
                </div>
              @else
                <div class="list__item list__item--button">
                  @if ($e->state == 'Ausgebucht') Dieser Kurs ist bereits ausgebucht. @endif
                  @if (!$e->bookable) Die Anmeldefrist ist leider bereits vorbei. @endif
                </div>
              @endif
            </div>
          </div>
        </div>
        <section class="event-form is-hidden">
          <register-form event-id="{{$e->id}}"></register-form>
        </section>
      </article>        
    @endforeach
  @endif
</section>
@endsection