<nav class="site__nav js-menu">
  <div>
    <ul>
      <li>
        <a href="{{ route('page.services') }}" class="{{ request()->routeIs('page.services') ? 'is-active' : '' }}">Angebot</a>
      </li>
      <li>
        <a href="{{ route('page.nursery') }}" class="{{ request()->routeIs('page.nursery') ? 'is-active' : '' }}">Bildungskrippen</a>
      </li>
      <li>
        <a href="{{ route('page.events') }}" class="{{ request()->routeIs('page.events') ? 'is-active' : '' }}">Veranstaltungen</a>
      </li>
    </ul>
    <ul>
      <li>
        <a href="{{ route('page.about') }}" class="{{ request()->routeIs('page.about') ? 'is-active' : '' }}">Über uns</a>
      </li>
      <li>
        <a href="{{ route('page.team') }}" class="{{ request()->routeIs('page.team') ? 'is-active' : '' }}">Team</a>
      </li>
      <li>
        <a href="{{ route('page.network.members') }}" class="{{ request()->routeIs('page.network*') ? 'is-active' : '' }}">Netzwerk</a>
        <ul style="{{ request()->routeIs('page.network*') ? 'display: block;' : 'display: none;' }}">
          <li>
            <a href="{{ route('page.network.members') }}" class="{{ request()->routeIs('page.network.members') ? 'is-active' : '' }}">Personen</a>
          </li>
          <li>
            <a href="{{ route('page.network.organisations') }}" class="{{ request()->routeIs('page.network.organisations') ? 'is-active' : '' }}">Organisationen</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="{{ route('page.testimonials') }}" class="{{ request()->routeIs('page.testimonials') ? 'is-active' : '' }}">Stimmen</a>
      </li>
    </ul>
    <ul>
      <li>
        <a href="{{ route('page.blog') }}" class="{{ request()->routeIs('page.blog') ? 'is-active' : '' }}">Blog</a>
      </li>
      <li>
        <a href="{{ route('page.contact') }}" class="{{ request()->routeIs('page.contact') ? 'is-active' : '' }}">Kontakt</a>
      </li>
      <li class="is-home">
        <a href="{{ route('page.home') }}">Home</a>
      </li>
    </ul>
  </div>
</nav>