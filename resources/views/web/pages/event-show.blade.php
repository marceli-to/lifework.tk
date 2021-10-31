@extends('web.layout.app')
@section('seo_title', $event->title .', '. $event->category)
@section('seo_description', strip_tags($event->description))
@section('content')
<section class="site__content theme-dark" id="app">
  @if ($event)
    <article class="content-list content-list--events">
      <div class="content-list__inner">
        <a href="javascript:;history.back()" class="btn-arrow is-first"></a>
        <h3>{{$event->category}}</h3>
        <h2>{{$event->title}}</h2>
        <div class="content-list__body">
          @if ($event->description)
            <p>{!! $event->description !!}</p>
          @endif
          <div class="list">
            @if ($event->target_group)
              <div class="list__item">
                Zielgruppe: {{$event->target_group}}
              </div>
            @endif
            @if ($event->date)
              <div class="list__item">
                Datum: {{$event->date}}
              </div>
            @endif
            @if ($event->time)
              <div class="list__item">
                Zeit: {{$event->time}}
              </div>
            @endif
            @if ($event->location)
              <div class="list__item">
                Ort: {{$event->location}}
              </div>
            @endif
            @if ($event->host)
              <div class="list__item">
                Moderator/in: {{$event->host}}
              </div>
            @endif
            @if ($event->dateDeadline)
              <div class="list__item">
                Anmeldefrist: {{date('d.m.Y', strtotime($event->dateDeadline))}}
              </div>
            @endif
            @if ($event->cost)
              <div class="list__item">
                Kosten: {{$event->cost}}
              </div>
            @endif
            @if ($event->state != 'Ausgebucht' && $event->bookable)
              <div class="list__item list__item--button">
                @if ($event->hasForm)
                  <a href="javascript:;" class="btn-primary js-btn-form">buchen</a>
                @else
                  <a href="mailto:{{$event->email}}?subject=Anfrage%20Termin%20«{{$event->title}}» – lifework.ch" class="btn-primary">kontakt</a>
                @endif
              </div>
            @else
              <div class="list__item list__item--button">
                @if ($event->state == 'Ausgebucht') Dieser Kurs ist bereits ausgebucht. @endif
                @if (!$event->bookable) Die Anmeldefrist ist leider bereits vorbei. @endif
              </div>
            @endif
          </div>
        </div>
      </div>
      <section class="event-form is-hidden">
        <register-form event-id="{{$event->id}}"></register-form>
      </section>
    </article>        
  @endif
</section>
@endsection