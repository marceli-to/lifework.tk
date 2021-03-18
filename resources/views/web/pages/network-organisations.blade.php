@extends('web.layout.app')
@section('seo_title', 'Netzwerk – Organisationen')
@section('content')
<section class="site__content theme-light">
  @if ($organisations)
    @foreach($organisations as $organisation)
      <article class="content-list">
        <div class="content-list__inner">
          <a href="javascript:;" class="btn-arrow is-first js-btn-article"></a>
          <a href="javascript:;" class="js-btn-article">{{ $organisation->title }}</a>
          @if ($organisation->text)
            <div class="content-list__body is-hidden">
              {!! $organisation->text !!}
            </div>
          @endif
        </div>
      </article>
    @endforeach
  @endif
</section>
@endsection