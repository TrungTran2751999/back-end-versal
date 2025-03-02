@include('layout/client/header')
<body>
    @include('layout/client/topbar')
    <section class="page-header">
        <div class="page-header-shape">
            <div class="shape"></div>
            <div class="shape center"></div>
            <div class="shape center back"></div>
            <div class="shape right"></div>
        </div>
        <div class="container">
            <div class="page-header-info">
                <h4>Blog News</h4>
                <h2>Gaming News &amp; Insights</h2>
                <p>Our success in creating business solutions is due in large part <br>to our talented and highly
                    committed team.</p>
            </div>
        </div>
    </section><!-- /.page-header -->

    <section class="blog-section blog-page padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 sm-padding">
                    <div class="row grid-post" id="container-blog">

                    </div>
                    <ul class="pagination-wrap text-left mt-40" id="container-paginate">
                        <li><a href="javascript:void(0)" onclick="clickArrow('pre')"><i class="las la-arrow-left"></i></a></li>
                        <span id="index-page">
                            {{-- <li><a href="javascript:void(0)" class="active" onclick="paginate(1)">1</a></li>
                            <li><a href="javascript:void(0)" onclick="paginate(2)">2</a></li>
                            <li><a href="javascript:void(0)" onclick="paginate(3)">3</a></li> --}}
                        </span>
                        <li><a href="javascript:void(0)" onclick="clickArrow('next')"><i class="las la-arrow-right"></i></a></li>
                    </ul>
                    <!--Pagination-->
                </div>
                <!--Blog Grid-->
                <div class="col-lg-4 sm-padding">
                    <div class="sidebar-widget">
                        <form action="" class="search-form">
                            <input type="text" class="form-control" placeholder="Search">
                            <button class="search-btn" type="button"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <!--Search Form-->
                    {{-- <div class="sidebar-widget">
                        <div class="widget-title">
                            <h3>Categories</h3>
                        </div>
                        <ul class="category-list">
                            <li><a href="javascript:void(0)">Business Strategy</a><span>23</span></li>
                            <li><a href="javascript:void(0)">Project Management</a><span>05</span></li>
                            <li><a href="javascript:void(0)">Digital Marketing</a><span>18</span></li>
                            <li><a href="javascript:void(0)">Customer Experience</a><span>04</span></li>
                            <li><a href="javascript:void(0)">Partnership System</a><span>15</span></li>
                        </ul>
                    </div> --}}
                    <!--Categories-->
                    <div class="sidebar-widget">
                        <div class="widget-title">
                            <h3>Recent Articles</h3>
                        </div>
                        <ul class="thumb-post" id="thumb-post" >
                            
                        </ul>
                    </div>
                    <!--Recent Thumb Post-->
                    {{-- <div class="sidebar-widget">
                        <div class="widget-title">
                            <h3>Tags</h3>
                        </div>
                        <ul class="tags">
                            <li><a href="javascript:void(0)">business</a></li>
                            <li><a href="javascript:void(0)">marketing</a></li>
                            <li><a href="javascript:void(0)">startup</a></li>
                            <li><a href="javascript:void(0)">design</a></li>
                            <li><a href="javascript:void(0)">consulting</a></li>
                            <li><a href="javascript:void(0)">strategy</a></li>
                            <li><a href="javascript:void(0)">development</a></li>
                            <li><a href="javascript:void(0)">tips</a></li>
                            <li><a href="javascript:void(0)">Seo</a></li>
                        </ul>
                    </div> --}}
                    <!--Tags-->
                </div>
                <!--Sidebar-->
            </div>
        </div>
    </section>
    <!--Blog Section-->
    @include('layout/client/footer')
    <script>
        let limit = 4;
        let maxCount = 0;
        let isStart = true;
        let page = 1;
        function initData(){
            if(isStart) {
                loadingBlog()
                locadingRecent()
                $("#container-paginate").css("display","none")
            }
            
            $.ajax({
                url : host + `/api/blog/client?page=${page}&limit=${limit}`
            })
            .done(res=>{
                $("#container-paginate").css("display","")
                let blogTotal = "";
                for(let i=0; i<res.length; i++){
                    let blog = `
                    <div class="col-md-6 padding-15">
                        <div class="post-card" style="height:266px">
                            <div class="post-thumb">
                                {{-- <img src="client/img/post-1.jpg" alt="post"> --}}
                                {{-- <a href="javascript:void(0)" class="post-category">Business</a> --}}
                            </div>
                            <div class="post-content-wrap">
                                <ul class="post-meta">
                                    <li><i class="las la-calendar"></i>${convertDateTimeDB(res[i].createdAt)}</li>
                                    <li><i class="las la-user"></i>${res[i].name}</li>
                                </ul>
                                <div class="post-content">
                                    <h3><a href="/Blog/detail?id=${res[i].id}">${briefContent(res[i].title, 60)}</a></h3>
                                    <p>${briefContent(res[i].brief, 50)}</p>
                                    <a href="/Blog/detail?id=${res[i].id}" class="read-more">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>`
                    blogTotal+=blog
                }
                $("#container-blog").html(blogTotal);

                if(isStart){
                    let lis = ""
                    for(let i=0; i<res.length; i++){
                        let li = `
                        <li style="width:100%">
                            <div class="thumb">
                                <img src="public/client/img/logo.png" alt="thumb">
                            </div>
                            <div class="thumb-post-info">
                                <h3><a href="/Blog/detail?id=${res[i].id}">${briefContent(res[i].title, 60)}</a></h3>
                                <a href="/Blog/detail?id=${res[i].id}" class="date">${convertDateTimeDB(res[i].createdAt)}</a>
                            </div>
                        </li>`
                        lis+=li
                    }
                    $("#thumb-post").html(lis);
                    $.ajax({
                        url: host + "/api/blog/count?type=DA DUYET"
                    })
                    .done(res=>{
                        maxCount = Math.ceil(res["count"]/limit);
                        let maxCountt = maxCount > 3 ? 3: maxCount
                        let li = "";
                        for(let i=1; i<=maxCountt; i++){
                            let lis = `<li><a href="javascript:void(0)" onclick="paginate(${i})" class="${i==1?"active":""}">${i}</a></li>`
                            li+=lis
                        }
                        $("#index-page").html(li)
                        maxCountt > 0 ? $("#container-paginate").css("display","") : $("#container-paginate").css("display","none");
                    })
                    isStart=false;
                }
            })
            .fail(err=>{

            })
        }
        initData()
        function paginate(indexCurrent){
            let li = ""
            if(maxCount >=3 ){
                if(indexCurrent!=1 && indexCurrent!=maxCount){
                    li = `
                    <li><a href="javascript:void(0)" onclick="paginate(${indexCurrent-1})">${indexCurrent-1}</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(${indexCurrent})" class="active" >${indexCurrent}</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(${indexCurrent+1})">${indexCurrent+1}</a></li>`
                }else if(indexCurrent==1){
                    li = `
                    <li><a href="javascript:void(0)" onclick="paginate(1})" class="active">1</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(2)">2</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(3)">3</a></li>`
                }else if(indexCurrent==maxCount){
                    li = `
                    <li><a href="javascript:void(0)" onclick="paginate(${maxCount-2})">${maxCount-2}</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(${maxCount-1})">${maxCount-1}</a></li>
                    <li><a href="javascript:void(0)" onclick="paginate(${maxCount})" class="active">${maxCount}</a></li>`
                }
            }else{
                for(let i=1; i<=maxCount; i++){
                    li += `
                    <li><a href="javascript:void(0)" onclick="paginate(${i})" class="${indexCurrent==i?"active":""}">${i}</a></li>`
                }
            }
            indexCurrentt = indexCurrent
            page = indexCurrent
            loadingBlog()
            $("#index-page").html(li);

            callBackPaginate()
        }
        let callBackPaginate = debounce(initData, 1000);
        let indexCurrentt = 1;
        function clickArrow(type){
            if(type=="next" && indexCurrentt<maxCount){
                indexCurrentt++
            }else if(type=="pre" && indexCurrentt>1){
                indexCurrentt--
            }
            paginate(indexCurrentt);
        }
        //loading blog
        function loadingBlog(){
            let rows = ""
            for(let i=1; i<=4; i++){
                let row = `
                <div class="col-md-6 padding-15">
                    <div class="post-card placeholder" style="height:266px">
                        <div class="post-content-wrap">
                            <ul class="post-meta">
                               
                            </ul>
                            <div class="post-content">
                                
                            </div>
                        </div>
                    </div>
                </div>`
                rows+=row;
            }
            $("#container-blog").html(rows);
        }
        //loading recent article
        function locadingRecent(){
            let lis = ""
            for(let i=1; i<=4; i++){
                let li = `
                <li style="width:100%" class="placeholder">
                    <div class="placeholder thumb">
                        
                    </div>
                    <div class="placeholder thumb-post-info">
                        
                    </div>
                </li>`
                lis+=li;
            }
            $("#thumb-post").html(lis);
        }
    </script>
</body>