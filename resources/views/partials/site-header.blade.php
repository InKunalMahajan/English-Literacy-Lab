<a href="#main" class="ell-skip-link">Skip to content</a>
<header class="ell-site-header">
  <nav aria-label="Main navigation" class="ell-site-nav">
    <a class="ell-brand" href="{{ route('home') }}">English Literacy Lab <span class="ell-brand-short">(ELL)</span></a>
    <div class="ell-nav-links">
      <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a>
      <a href="{{ route('curriculum.index') }}" @if(request()->routeIs('curriculum.*')) aria-current="page" @endif>Curriculum</a>
      @auth
        <a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a>
        @if(auth()->user()->is_active && auth()->user()->is_content_editor)
          <a href="{{ route('authoring.index') }}" @if(request()->routeIs('authoring.*')) aria-current="page" @endif>Authoring</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="ell-nav-logout">@csrf<button type="submit">Sign out</button></form>
      @else
        <a href="{{ route('login') }}" @if(request()->routeIs('login')) aria-current="page" @endif>Sign in</a>
      @endauth
    </div>
  </nav>
</header>
