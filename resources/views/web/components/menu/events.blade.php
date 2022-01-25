{{-- @if ($events['nurseries']->count() > 0)
  <li>
    <a href="{{ route('page.events.nurseries') }}" class="{{ request()->routeIs('page.events.nurseries') ? 'is-active' : '' }}">für Bildungskrippen</a>
  </li>
@endif --}}
@if ($events['kitas']->count() > 0)
  <li>
    <a href="{{ route('page.events.kitas') }}" class="{{ request()->routeIs('page.events.kitas') ? 'is-active' : '' }}">für Kitas</a>
  </li>
@endif
@if ($events['leaders']->count() > 0)
  <li>
    <a href="{{ route('page.events.leaders') }}" class="{{ request()->routeIs('page.events.leaders') ? 'is-active' : '' }}">für Führungspersonen</a>
  </li>
@endif
@if ($events['companies']->count() > 0)
  <li>
    <a href="{{ route('page.events.companies') }}" class="{{ request()->routeIs('page.events.companies') ? 'is-active' : '' }}">für Unternehmen</a>
  </li>
@endif
@if ($events['other']->count() > 0)
  <li>
    <a href="{{ route('page.events.other') }}" class="{{ request()->routeIs('page.events.other') ? 'is-active' : '' }}">für andere</a>
  </li>
@endif