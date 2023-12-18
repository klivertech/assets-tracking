<!doctype html>

<html lang="en">
  <head>

    @include('includes.meta')

    <title>@yield('title') - Assets Management</title>
    <!-- CSS files -->
    @stack('before-style')
    @include('includes.style')
    @yield('style')
    @stack('after-style')

  </head>
  <body >
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
      <!-- Navbar -->
      {{-- @include('includes.navbar') --}}

        <livewire:component.navbar>


      {{ $slot }}
    </div>

    <!-- Libs JS -->
    @stack('before-script')
    @include('includes.script')
    @yield('script')
    @stack('after-script')
  </body>
</html>
