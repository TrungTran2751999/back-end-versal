@include('layout/client/header')
<link rel="stylesheet" href="{{asset('public/lib/quill/quill.css')}}">
<body>
    @include('layout/client/topbar')
    <section class="page-header single">
        <div class="page-header-shape">
            <div class="shape"></div>
            <div class="shape center"></div>
            <div class="shape center back"></div>
            <div class="shape right"></div>
        </div>
        <div class="container">
            <div class="page-header-info">
                <h4>Blog Details</h4>
                <h2 id="title-blog">Microsoft Xbox Publishes First <br>Transparency Report!</h2>
                <p id="brief-blog">Our success in creating business solutions is due in large part <br>to our talented and highly
                    committed team.</p>
                <ul class="post-meta">
                    <li><i class="las la-user"></i>
                        <span id="author-blog">
                            Elliot Alderson
                        </span>
                    </li>
                    <li><i class="las la-calendar"></i>
                        <span id="created-blog">
                            Jan 01 2022
                        </span>
                    </li>
                    {{-- <li><i class="las la-comments"></i>Comments 0</li> --}}
                </ul>
            </div>
        </div>
    </section><!-- /.page-header -->

    <section class="blog-section blog-page padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="post-details" id="post-details">
                        
                        <div id="content-blog" class="ql-editor" contenteditable="true">

                        </div>
                        {{-- CONTENT --}}

                        {{-- <ul class="tags">
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Marketing</a></li>
                            <li><a href="#">Startup</a></li>
                            <li><a href="#">Design</a></li>
                        </ul> --}}
                        <!--Tags-->

                        {{-- <ul class="post-navigation" id="post-navigation">
                            <li>
                                <a href="blog-details.html">
                                    <span><i class="las la-angle-left"></i>Previous</span>
                                    How To Start Initiating An Startup In Few Days.
                                </a>
                            </li>
                            <li>
                                <a href="blog-details.html">
                                    <span>Next<i class="las la-angle-right"></i></span>
                                    Fresh Startup Ideas For Digital Business.
                                </a>
                            </li>
                        </ul> --}}
                        <!--Post Navigations-->

                        {{-- <div class="author-box">
                            <div class="author-thumb">
                                <img src="client/img/auhtor.png" alt="img">
                            </div>
                            <div class="author-info">
                                <h3>Elliot Alderson</h3>
                                <p>Our versatile team is built of designers, developers and digital marketers who all
                                    bring unique experience.</p>
                                <ul class="social-icon">
                                    <li><a href="#"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="#"><i class="lab la-instagram"></i></a></li>
                                    <li><a href="#"><i class="lab la-behance"></i></a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <!--Author Box-->

                        {{-- <h3 class="comment-title">Post Comments</h3>
                        <ul class="comments-box">
                            <li class="comment">
                                <div class="comment-inner">
                                    <div class="comment-thumb"><img src="client/img/comment-1.png" alt="img"></div>
                                    <div class="comment-wrap">
                                        <div class="comments-meta">
                                            <h4>Ashton Porter <span>Jan 01, 2022 at 8:00</span></h4>
                                        </div>
                                        <div class="comment-area">
                                            <p>You guys have put so much work, effort, and time while designing this
                                                awesome theme I can see that passion when I incorporated it into my
                                                website.</p>
                                            <a href="#" class="reply">Reply</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="children">
                                    <li class="comment">
                                        <div class="comment-inner">
                                            <div class="comment-thumb"><img src="client/img/comment-2.png" alt="img">
                                            </div>
                                            <div class="comment-wrap">
                                                <div class="comments-meta">
                                                    <h4>Melania Trump <span>Jan 01, 2022 at 8:00</span></h4>
                                                </div>
                                                <div class="comment-area">
                                                    <p>The only thing I LOVE more than this theme and it’s incredible
                                                        options is the support team! They are freaking amazable!</p>
                                                    <a href="#" class="reply">Reply</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="comment">
                                <div class="comment-inner">
                                    <div class="comment-thumb"><img src="client/img/comment-3.png" alt="img"></div>
                                    <div class="comment-wrap">
                                        <div class="comments-meta">
                                            <h4>Elliot Alderson <span>Jan 01, 2022 at 8:00</span></h4>
                                        </div>
                                        <div class="comment-area">
                                            <p>Outstanding quality in this theme, brilliant Effects and perfect crafted
                                                Code. We absolutely love it and can highly recommend ThemeEaster!</p>
                                            <a href="#" class="reply">Reply</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul> --}}
                        {{-- <!--Comments-->

                        <h3 class="comment-title">Leave a Comment</h3>
                        <form action="#" method="post" class="comment-form form-horizontal">
                            <div class="form-group row">
                                <div class="col-sm-6 padding-15">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name*"
                                        required>
                                </div>
                                <div class="col-sm-6 padding-15">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email*"
                                        required>
                                </div>
                                <div class="col-md-12 padding-15">
                                    <textarea id="comment" name="comment" cols="30" rows="5"
                                        class="form-control comment" placeholder="Your Comment*" required></textarea>
                                </div>
                                <div class="col-md-12 padding-15">
                                    <button id="submit" class="default-btn" type="submit">Submit
                                        Comment<span></span></button>
                                    <div id="form-messages" class="alert" role="alert"></div>
                                </div>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog Section-->
    @include('layout/client/footer')
    <script>
        let urlParams = new URLSearchParams(window.location.search); //get all parameters
        let id = urlParams.get('id');
        function initData(){
            //blog content
            $.ajax({
                url: host + `/api/blog/detail?id=${id}`
            })
            .done(res=>{
                $("#title-blog").text(res.title);
                $("#brief-blog").text(res.brief);
                $("#author-blog").text(res.name);
                $("#created-blog").text(convertDateTimeDB(res.createdAt));
                $("#content-blog").html(res.content);
            })
            .fail(err=>{
                window.location.href = "/404"
            })
        }
        initData()
    </script>
</body>