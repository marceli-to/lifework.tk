@extends('web.layout.app')
@section('seo_title', 'Passwort vergessen')
@section('seo_description', '')
@section('content')
<section class="site__content theme-dark">
  <article class="content-text">
    <div class="content-text__inner">
      <h2>{{ __('Confirm Password') }}</h2>
      <p>{{ __('Please confirm your password before continuing.') }}</p>
      <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <x-text-field label="Passwort" type="password" name="password" />
        <div class="form-buttons align-end">
          <x-button label="senden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
        </div>
      </form>
    </div>
  </article>
</section>
@endsection