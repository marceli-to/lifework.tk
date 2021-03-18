@extends('web.layout.app')
@section('seo_title', 'Stimmen')
@section('content')
<section class="site__content theme-medium">
  @if ($testimonials)
    @foreach($testimonials as $testimonial)
      <article class="content-list content-list--testimonial">
        <div class="content-list__inner">
          <h2>{{ $testimonial->title }}</h2>
          @if ($testimonial->text)
            <div class="content-list__body">
              {!! $testimonial->text !!}
            </div>
          @endif
        </div>
      </article>
    @endforeach
  @endif
</section>
@endsection