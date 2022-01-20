<!DOCTYPE html>
<html>
    <head>
        {{-- importing head data --}}
        @include('includes.head')
    </head>
    
    <body class="antialiased">
        <header>
            {{-- importing header --}}
            @include('includes.header')
        </header>
        
        {{-- page content --}}
        @yield('content')

        <footer>
            {{-- importing footer --}}
            @include('includes.footer')
        </footer>
    </body>

    {{-- imoporting scripts --}}
    @include('includes.scripts')
</html>
