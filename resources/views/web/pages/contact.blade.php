@extends('web.layout.app')
@section('seo_title', 'Kontakt')
@section('seo_description', '')
@section('content')
<section class="site__content theme-dark">
  <article class="content-text content-text--contact">
    <div class="content-text__inner">
      <h2 class="underline"><span>Kontakt</span></h2>
      <p>Theres Hofmann<br><a href="mailto:theres.hofmann@lifework.ch" target="_blank">theres.hofmann@lifework.ch</a></p>
      <p>Kathrin Toberer<br><a href="mailto:kathrin.toberer@lifework.ch" target="_blank">kathrin.toberer@lifework.ch</a></p>
      <p>lifework tk ag<br>Untere Vogelsangstrasse 11<br>8400 Winterthur<br><a href="mailto:mail@lifework.ch" target="_blank">mail@lifework.ch</p>
      <p class="fs-sm">
        <a href="https://goo.gl/maps/yb6nZ8J5xJ6dmoFBA" target="_blank" rel="noopener">Google Maps</a><br>
        <a href="{{route('page.toc')}}">AGB</a>
      </p>
      <h2 class="underline"><span>Impressum</span></h2>
      <p class="fs-sm">
        Inhalt: lifework tk ag<br>
        Portraitfotografie: <a href="https://www.grundstudio.com" target="_blank" rel="noopener">grundstudio</a><br>
        Konzept und Grafikdesign: Alexandra Noth, <a href="https://www.alexandranoth.ch" target="_blank" rel="noopener">alexandranoth.ch</a><br>
        Programmierung: Marcel Stadelmann, <a href="https://marceli.to" target="_blank" rel="noopener">marceli.to</a> 
      </p>
    </div>
  </article>
</section>
@endsection