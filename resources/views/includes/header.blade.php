@php
    $path = $_SERVER['REQUEST_URI'];   
@endphp
<nav class="navbar navbar-expand-md navbar-dark bg-dark main-nav">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse w-100">
            
        </div>
        <a class="navbar-brand order-first order-md-0 mx-0" href="/">Covid Data</a>
        <div class="collapse navbar-collapse w-100">
            <ul class="nav navbar-nav ml-auto login">
                <li class="nav-item">
                    @if($path == "/register")
                        <a class="nav-link" href="/">Login</a>
                    @else
                        @if(Auth::check())
                            <a class="nav-link" href="javascript:void(0)" onclick="$('#logout').submit();">Log Out</a>
                            <form method="POST" id="logout" action="/logout">@CSRF</form>
                        @else
                            <a class="nav-link" href="/register">Sign Up</a>
                        @endif
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>