<footer class="footer-section">
    <div class="container">
        <div class="row footer-items">
            <div class="col-lg-3 col-sm-6 sm-padding">
                <div class="footer-item">
                    <a class="brand" href="/"><img src="{{asset('public/client/img/logo-2.png')}}" alt="logo"></a>
                    <p>Our success in creating business solutions is due in large part to our talented and highly
                        committed team.</p>
                    <ul class="social-list">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 sm-padding">
                <div class="footer-item footer-list">
                    <div class="widget-title">
                        <h3>Usefull Links</h3>
                    </div>
                    <ul class="footer-links">
                        <li><a href="upcoming-matches.html">Tournaments</a></li>
                        <li><a href="faq-page.html">Help Center</a></li>
                        <li><a href="about.html">Privacy and Policy</a></li>
                        <li><a href="about.html">Terms of Use</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 sm-padding">
                <div class="footer-item">
                    <div class="widget-title">
                        <h3>Contact Us</h3>
                    </div>
                    <ul class="footer-contact">
                        <li><span>Location:</span>22 Hong Ha, District Tan Binh, Ward 2, Ho Chi Minh City</li>
                        <li><span>Join Us:</span>bd@dwvarena.com</li>
                        <li><span>Phone:</span>+84 889 22 99 22</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 sm-padding">
                <div class="footer-item subscribe-wrap">
                    <div class="widget-title">
                        <h3>Newsletter Signup</h3>
                    </div>
                    <form action="#" class="subscribe-form">
                        <input class="form-control" type="email" name="email" placeholder="Your Email" required="">
                        <input type="hidden" name="action" value="mailchimpsubscribe">
                        <button class="submit">Subscribe Now</button>
                        <div class="clearfix"></div>
                        <div id="subscribe-result">
                            <div class="subscription-success"></div>
                            <div class="subscription-error"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <p>© <span id="currentYear"></span> DWV Arena copyright by Wetaps.</p>
        </div>
    </div>
    <!--copyright-wrap-->
</footer>
<!--footer-section-->

<div id="scrollup">
    <button id="scroll-top" class="scroll-to-top hover-target"><i class="las la-arrow-up"></i></button>
</div>
<!--scrollup-->

<!--jQuery Lib-->

<script src="{{asset('public/client/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/jquery.ajaxchimp.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/popper.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/odometer.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/waypoints.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/venobox.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/swiper.min.js')}}"></script>
<script src="{{asset('public/client/js/vendor/smooth-scroll.js')}}"></script>
<script src="{{asset('public/client/js/vendor/wow.min.js')}}"></script>
<script src="{{asset('public/client/js/contact.js')}}"></script>
<script src="{{asset('public/client/js/main.js')}}"></script>

<script>
    function convertDateTime(isoTime, time){
        // let getDate = isoTime.split("T")[0].split("-").reverse().join("/"); 
        let getDate = new Date(isoTime).getDate()< 10 ? `0${new Date(isoTime).getDate()}` : new Date(isoTime).getDate();
        let getMonth = new Date(isoTime).getMonth()+1 < 10?`0${new Date(isoTime).getMonth()+1}`:new Date(isoTime).getMonth()+1;
        let getYear = new Date(isoTime).getFullYear();
        let getHour = new Date(isoTime).getHours() < 10 ? `0${new Date(isoTime).getHours()}` : new Date(isoTime).getHours();
        let getMinute = new Date(isoTime).getMinutes() < 10 ? `0${new Date(isoTime).getMinutes()}` : new Date(isoTime).getMinutes();;
        let getSecond = new Date(isoTime).getSeconds() < 10 ? `0${new Date(isoTime).getSeconds()}` : new Date(isoTime).getSeconds();;
        let result;
        if(time==undefined){
            result = `${getDate}/${getMonth}/${getYear}`;
        }else{
            result = `${getDate}/${getMonth}/${getYear} ${getHour}:${getMinute}:${getSecond}`;
        } 
        return result;
    }
    function decodeDatetime(isoTime){
        let getMonth = new Date(isoTime).getMonth()+1 < 10?`0${new Date(isoTime).getMonth()+1}`:new Date(isoTime).getMonth()+1;
        let getYear = new Date(isoTime).getFullYear();
        let result = `${getYear}${getMonth}`;
        return result;
    }
    function convertDateTimeDB(isoTime, type){
        let getDate = new Date(isoTime).getDate() < 10 ? `0${new Date(isoTime).getDate()}` : new Date(isoTime).getDate();
        let getMonth = new Date(isoTime).getMonth()+1 < 10?`0${new Date(isoTime).getMonth()+1}`:new Date(isoTime).getMonth()+1;
        let getYear = new Date(isoTime).getFullYear();
        let result;
        if(type=="input"){
            result = `${getYear}-${getMonth}-${getDate}`;
        }else{
            result = `${getDate}-${getMonth}-${getYear}`;
        } 
        return result;
    }
    function getCookie(cookieName) {
        var cookieValue = document.cookie;
        var cookieStart = cookieValue.indexOf(cookieName + '=');
        if (cookieStart === -1) {
            return null; // Cookie not found
        }
        cookieStart = cookieValue.indexOf('=', cookieStart) + 1;
        var cookieEnd = cookieValue.indexOf(';', cookieStart);
        if (cookieEnd === -1) {
            cookieEnd = cookieValue.length;
        }
        return decodeURIComponent(cookieValue.substring(cookieStart, cookieEnd));
    }
    function logout(){
		$.ajax({
		    url: host + "/api/user/logout"
		})
        .done(()=>{
            window.location.href = "/admin/login";
        })
	}
    function briefContent(content, limit){
        if(content.length>limit){
            content = content.slice(0,limit+1) + "..."
        }
        return content
    }
    const debounce = (func, delay) => {
        let timerId;
        return function () {
            clearTimeout(timerId)
            timerId = setTimeout(() => func.apply(this, arguments), delay)
        };
    };
</script>