@extends('web.layout.app')
@section('seo_title', 'Angebot')
@section('seo_description', '')
@section('content')
<section class="site__content theme-light">
  @if ($posts)
    @foreach($posts as $p)
      <article class="content-list content-list--blog">
        <div class="content-list__inner">
          @if ($p->date)
            <h3>{{$p->date}}</h3>
          @endif
          <h2 class="underline">
            <span>{{$p->title}}</span>
          </h2>
          <div class="content-list__body">
            {!! $p->text !!}
          </div>
        </div>
        @if ($p->images)
          <div class="content-list__media">
            @foreach($p->images as $image)
              <figure>
                <img src="/img/cache/{{$image->name}}?w=1600&h=1000&c={{$image->coords}}" width="1600" height="1000" alt="{{$image->caption}}">
                <figcaption>{{$image->caption}}</figcaption>
              </figure>
            @endforeach
          </div>
        @endif
      </article>
    @endforeach
  @endif
</section>
@endsection