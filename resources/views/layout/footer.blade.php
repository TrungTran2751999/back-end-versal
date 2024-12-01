<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->`
<script src="{{asset('public/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('public/assets/extra-libs/sparkline/sparkline.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('public/dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{asset('public/dist/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('public/dist/js/custom.min.js')}}"></script>
<!-- this page js -->
<script src="{{asset('public/js/autocomplete.js')}}"></script>
<script src="{{asset('public/assets/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script>
<script src="{{asset('public/assets/extra-libs/multicheck/jquery.multicheck.js')}}"></script>
<script src="{{asset('public/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('public/assets/libs/toastr/toastr.js')}}"></script>
<script src="{{asset('public/assets/libs/toastr/build/toastr.min.js')}}"></script>
<script src="{{asset('public/js/sweet-alert.js')}}"></script>
<script src="{{asset('public/js/pagination.min.js')}}"></script>
<script src="{{asset('public/js/pagination.js')}}"></script>
<script src="{{asset('public/js/multiple-droplist.js')}}"></script>
{{-- <script src="{{asset('public/client/js/vendor/jquary-3.6.0.min.js')}}"></script> --}}
<script>
    // let host = "http://192.168.0.15:5221";
    let host = "{{ env('APP_URL') }}";
</script>
<script>
    function checkRole(){
      let id = +getCookie("id");
      let guid = getCookie("guid");
      $.ajax({
        url: host+`/api/user/check-role?id=${id}&guid=${guid}`
      })
      .done(res=>{
        if(res.roleId==2){
            $("#li-tournament").css("display","none");
            $("#li-category").css("display","none");
            $("#li-organizer").css("display","none");
            $("#li-user").css("display","none");
        }
      })
    }
    checkRole();

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
    
</script>