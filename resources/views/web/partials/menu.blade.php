<nav class="site__nav js-menu">
  <div>
    <ul>
      <li>
        <a href="{{route('page.services')}}" class="{{ request()->routeIs('page.services') ? 'is-active' : '' }}">
          Angebot
        </a>
      </li>
      <li>
        <a href="{{route('page.topics')}}" class="{{ request()->routeIs('page.topics') ? 'is-active' : '' }}">Themen</a>
      </li>
      <li>
        <a href="{{route('page.events')}}" class="{{ request()->routeIs('page.events') ? 'is-active' : '' }}">Veranstaltungen</a>
      </li>
    </ul>
    <ul>
      <li>
        <a href="{{route('page.about')}}" class="{{ request()->routeIs('page.about') ? 'is-active' : '' }}">Über uns</a>
      </li>
      <li>
        <a href="{{route('page.team')}}" class="{{ request()->routeIs('page.team') ? 'is-active' : '' }}">Team</a>
      </li>
      <li>
        <a href="{{route('page.network')}}" class="{{ request()->routeIs('page.network') ? 'is-active' : '' }}">Netzwerk</a>
      </li>
      <li>
        <a href="{{route('page.blog')}}" class="{{ request()->routeIs('page.blog') ? 'is-active' : '' }}">Blog</a>
      </li>
    </ul>
    <ul>
      <li>
        <a href="{{route('page.toc')}}" class="{{ request()->routeIs('page.toc') ? 'is-active' : '' }}">AGB</a>
      </li>
      <li>
        <a href="{{route('page.contact')}}" class="{{ request()->routeIs('page.contact') ? 'is-active' : '' }}">Kontakt</a>
      </li>
      <li>
        <a href="{{route('page.home')}}">Home</a>
      </li>
    </ul>
  </div>
</nav>