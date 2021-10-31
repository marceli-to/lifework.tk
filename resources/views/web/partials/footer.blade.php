<script src="{{ mix('assets/js/app.js') }}" type="text/javascript"></script>
@if (request()->routeIs('page.event*'))
<script src="{{ mix('assets/js/events.js') }}" type="text/javascript"></script>
@endif
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9FFXWH8ZBX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-9FFXWH8ZBX');
</script>
</body>
<!-- made with ❤ by marceli.to & alexandranoth.ch -->
</html>