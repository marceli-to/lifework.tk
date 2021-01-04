@extends('web.layout.app')
@section('seo_title', 'Angebot')
@section('seo_description', '')
@section('content')
<section class="site__content theme-light">
  @if ($posts)
    @foreach($posts as $p)
      <article class="content-list">
        <div class="content-list__inner">
          <a href="javascript:;" class="btn-arrow is-first js-btn-article"></a>
          <h3>{{$p->dateStr}}</h3>
          <h2><a href="javascript:;" class="js-btn-article">{{$p->title}}</a></h2>
          <div class="content-list__body is-hidden">
            {!! $p->text !!}
          </div>
        </div>
      </article>
    @endforeach
  @endif
</section>
@endsection