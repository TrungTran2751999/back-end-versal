<!--[if lt IE 8]>
        <p Author coder by DucNM</p>
    <![endif]-->

    <div class="site-preloader">
        <div class="spinner"></div>
    </div>
    <!--site preloader-->

    <header class="header">
        <div class="primary-header">
            <div class="container">
                <div class="primary-header-inner">
                    <div class="header-logo">
                        <a href="/">
                            <img class="logo" src="{{asset('public/client/img/logo.png')}}" width="50%" alt="Logo">
                        </a>
                    </div><!-- /.header-logo -->
                    <div class="header-menu-wrap">
                        <ul class="nav-menu">
                            <li id="home"><a href="/">Home</a>
                                {{-- <ul>
                                    <li><a href="/">Home Default</a></li>
                                    <li><a href="index-2.html">Home eSports</a></li>
                                </ul> --}}
                            </li>
                            {{-- <li><a href="#">Tournament</a>
                                <ul>
                                    <li><a href="upcoming-matches.html">Game Esports</a></li>
                                    <li><a href="stream-schedule.html">Contest</a></li>
                                    <li><a href="match-details.html">Sports</a></li>
                                    <li><a href="player-details.html">Hackathon</a></li>
                                    <li><a href="team-details.html">Team Details</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li><a href="#">About Us</a>
                                <ul>
                                    <li><a href="about.html">Our Team</a></li>
                                    <li><a href="our-gamers.html">Our Gamers</a></li>
                                    <li><a href="sponsors.html">Sponsors & Partner</a></li>
                                    <li><a href="faq-page.html">Help &amp; Faq's</a></li>
                                    <li><a href="404.html">404 Error</a></li>
                                </ul>
                            </li> --}}
                     
                            <li id="blog"><a href="/Blog">Blog</a>
                              
                        {{-- </li>
                            <li><a href="contact.html">Contact</a></li>
                        --}}
                        </ul> 
                    </div><!-- /.header-menu-wrap -->
                    <div class="header-right">
                        <div class="search-icon dl-search-icon"><i class="las la-search"></i></div>
                        <a class="default-btn" href="#">Join Our Team</a>
                        <!-- Burger menu -->
                        <div class="mobile-menu-icon">
                            <div class="burger-menu">
                                <div class="line-menu line-half first-line"></div>
                                <div class="line-menu"></div>
                                <div class="line-menu line-half last-line"></div>
                            </div>
                        </div>
                    </div><!-- /.header-right -->
                </div><!-- /.primary-header-one-inner -->
            </div>
        </div><!-- /.primary-header -->
    </header><!-- /.site-header-->
    <div id="popup-search-box">
        <div class="box-inner-wrap d-flex align-items-center">
            <form id="form" action="#" method="get" role="search">
                <input id="popup-search" type="text" name="s" placeholder="Type keywords here...">
                <button id="popup-search-button" type="submit" name="submit"><i class="las la-search"></i></button>
            </form>
        </div>
    </div><!-- /#popup-search-box -->
    <script>
        let url = window.location.href;
        let urlArr = url.split(host);
        console.log(urlArr);
        if(urlArr[1]=="/"){
            $(".nav-menu #home").addClass("active")
        }
        if(urlArr[1].includes("/Blog")){
            $(".nav-menu #blog").addClass("active")
        }
    </script>