@extends('web.layout.app')
@section('seo_title', 'Passwort vergessen')
@section('seo_description', '')
@section('content')
<section class="site__content theme-dark">
  <article class="content-text">
    <div class="content-text__inner">
      <h2>Passwort vergessen?</h2>
      @if ($errors->any())
        <x-alert type="danger" message="{{__('messages.general_error')}}" />
      @endif
      @if (session('status'))
        <x-alert type="success" message="{{ session('status') }}" />
      @endif
      <form method="POST" class="auth" action="{{ route('password.email') }}">
        @csrf
        <x-text-field label="E-Mail" type="email" name="email" />
        <div class="form-buttons align-end">
          <x-button label="senden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
        </div>
      </form>
    </div>
  </article>
</section>
@endsection