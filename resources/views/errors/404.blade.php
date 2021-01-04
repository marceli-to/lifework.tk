@extends('web.layout.app')
@section('content')
<section class="site__content theme-light">
  <article class="content-text">
    <div class="content-text__inner">
      <h2 class="underline"><span>{{__('page.header-404')}}</span></h2>
      <p>{{__('page.content-404')}}</p>
    </div>
  </article>
</section>
@endsection
