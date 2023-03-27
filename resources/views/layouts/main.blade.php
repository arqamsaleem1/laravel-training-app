<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- <script type="text/javascript" src="slick/slick.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    @vite(['resources/css/app.css'])

    @paddleJS
</head>
<body>
    <header>
        <?php 
            use App\Http\Controllers\CartController;
            $cartTotal = CartController::getCartCount();
        ?>
        <div class="container mx-auto px-4">
            <div class="header-inner">
                <div class="h-logo">
                    <!-- <img src="" alt=""> -->
                    <a href="/" class="logo"><span>My Training app</span></a>
                </div>
                <div class="menu-item cats-menu">
                    <a href="#" class="menu-btn cat-btn"><span>Categories</span></a>
                    <div class="dropdown dropdown-cat">
                        <ul class="menu">
                            @foreach ($cats as $cat)
                            @if($cat->parent == null )
                            @php
                            $total_child = count($cat->children);
                            @endphp
                            <li class=" @if( $total_child > 0 ) have-child @endif">
                                <a href="/courses/{{$cat->slug}}">{{ $cat->name }}</a>
                                @if( $total_child > 0 )
                                <ul class="sub-menu">
                                    @foreach ($cat->children as $child_cat)
                                    <li><a href="/courses/{{$child_cat->slug}}">{{ $child_cat->name }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="search-bar">
                    <div class="search-input">
                        <input type="text" name="search" placeholder="Search for anything">
                    </div>
                </div>
                <div class="menu-item subscribe-menu">
                    
                @if (auth()->user() && auth()->user()->subscribed("premium"))
                    <a href="#" class="menu-btn">View catalogue</a>
                @else
                    <a href="{{route('user.subscribe')}}" class="menu-btn">Subscribe</a>
                @endif
                    <div class="dropdown dropdown-my-business">

                    </div>
                </div>
                <div class="menu-item teach-at">
                    <a href="#" class="menu-btn">Teach on Udemy</a>
                    <div class="dropdown dropdown-teach-at">

                    </div>
                </div>
                <div class="menu-item cart">
                    <a href="/cart" class="menu-btn">
                        <i class="fas fa-shopping-cart"></i>
                        @if ($cartTotal)
                        <span class="cart-total">{{$cartTotal}}</span>
                        @endif
                    </a>
                    <div class="dropdown dropdown-cart">

                    </div>
                </div>
                <div class="login">
                @if (Auth::user())
                    
                    <a href="{{ route('profile.edit') }}"><span>{{ Auth::user()->name }}</span></a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outlined">Login</a>
                @endif

                </div>
                <div class="signup">
                @if (Auth::user())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="btn btn-contained" onclick="event.preventDefault();
                                                this.closest('form').submit();">Logout</a>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn btn-contained">Sign up</a>
                @endif

                </div>
            </div>
        </div>
    </header>
    <div class="content-area">
        @yield('content')
    </div>
    <footer>
        <div class="container mx-auto px-4">
            <div class="footer-inner">
                <div class="top-footer">
                    <div class="row flex">
                        <div class="col-6 basis-1/2">
                            <div class="columns-3">
                                <div class="footer-menu-1">
                                    <ul>
                                        <li><a href="#"><span>Udemy Business</span></a></li>
                                        <li><a href="#"><span>Teach on Udemy</span></a></li>
                                        <li><a href="#"><span>Get the app</span></a></li>
                                        <li><a href="#"><span>About us</span></a></li>
                                        <li><a href="#"><span>Contact us</span></a></li>
                                    </ul>
                                </div>
                                <div class="footer-menu-2">
                                    <ul>
                                        <li><a href="#"><span>Careers</span></a></li>
                                        <li><a href="#"><span>Blog</span></a></li>
                                    </ul>
                                </div>
                                <div class="footer-menu-3">
                                    <ul>
                                        <li><a href="#"><span>Careers</span></a></li>
                                        <li><a href="#"><span>Blog</span></a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="f-logo">
                        <span class="logo">My Training app</span>
                    </div>
                    <div class="f-copyright">
                        <span>© 2022 My training app, Inc.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>