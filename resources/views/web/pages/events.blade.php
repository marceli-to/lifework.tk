@extends('web.layout.app')
@section('seo_title', 'Veranstaltungen')
@section('content')
<section class="site__content theme-dark" id="app">
  @if ($events)
    @foreach($events as $e)
      <article class="content-list content-list--events">
        <div class="content-list__inner">
          <a href="{{route('page.event', ['slug' => Str::slug($e->title), 'event' => $e] )}}" class="btn-arrow is-right @if ($loop->first) is-first @endif js-btn-article"></a>
          <h3>{{$e->category}}</h3>
          <h2><a href="{{route('page.event', ['slug' => Str::slug($e->title), 'event' => $e] )}}" class="js-btn-article">{{$e->title}}</a></h2>
        </div>
      </article>        
    @endforeach
  @endif
</section>
@endsection