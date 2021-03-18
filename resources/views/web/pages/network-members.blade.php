@extends('web.layout.app')
@section('seo_title', 'Netzwerk – Personen')
@section('content')
<section class="site__content theme-light">
  @if ($members)
    @foreach($members as $member)
      <article class="content-list content-list--team">
        <div class="content-list__inner">
          <a href="javascript:;" class="btn-arrow is-first js-btn-article"></a>
          <h2>{{ $member->firstname }} {{ $member->name }}:</h2>
          @if ($member->quote)
            <a href="javascript:;" class="js-btn-article">«{{ $member->quote }}»</a>
          @endif
          <div class="content-list__body is-hidden">
            {!! $member->text !!}
          </div>
        </div>
        <div class="content-list__media is-hidden">
          <figure>
            <figcaption>
              <p>
                {{ $member->firstname }} {{ $member->name }}<br>
                @if ($member->description)
                  {!! nl2br($member->description) !!}
                @endif
              </p>
              <p>
                @if ($member->files)
                  @foreach($member->files as $file)
                    <a href="/storage/uploads/{{ $file->name }}" target="_blank" title="Profil {{ $member->firstname }} {{ $member->name }}">Profil</a>
                  @endforeach
                @endif
              </p>
            </figcaption>
            @if ($member->images)
              @foreach($member->images as $image)
                @if ($loop->first)
                  <img src="/img/cache/{{$image->name}}?w=600&h=800&c={{$image->coords}}" width="1333" height="1000" alt="{{ $member->firstname }} {{ $member->name }}">
                @endif
              @endforeach
            @endif
          </figure>
        </div>
      </article>
    @endforeach
  @endif
</section>
@endsection