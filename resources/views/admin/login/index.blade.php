<!DOCTYPE html>
<html dir="ltr" lang="en">
@include('layout/headerLogin')

<body>
    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<span class="login100-form-title p-b-26">
					Welcome
				</span>
				
				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="userName" id="userName" data-validate="Nhập tên đăng nhập">
					<div class="focus-input100" data-placeholder="Tên đăng nhập"></div>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Nhập mật khẩu">
					<span class="btn-show-pass">
						<i class="zmdi zmdi-eye"></i>
					</span>
					<input class="input100" type="password" name="Password" id="password">
					<span class="focus-input100" data-placeholder="Mật khẩu"></span>
				</div>

				<div style="color:red; font-size: 8pt" id="validate-input"></div>
				<div class="container-login100-form-btn">
					<div class="wrap-login100-form-btn">
						<div class="login100-form-bgbtn"></div>
						<button id="btn-login" class="login100-form-btn" onclick="login()">
							Login
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>
</body>
@include('layout/footer')
@include('layout/footerLogin')
<script>
	function login(){
		let data = {
			userName: $("#userName").val().trim(),
			password: $("#password").val().trim()
		}
		$.ajax({
			"headers": {
    			"Content-Type": "application/json"
			},
			url: host + "/api/user/login",
			method: "POST",
			data: JSON.stringify(data)
		})
		.done(()=>{
			window.location.href = "/admin"
		})
		.fail(err=>{
			$("#validate-input").text(err.responseText);
		})
	}
	$(document).keypress(function(event) {
		if (event.keyCode === 13) {
			login();
		}
	});
	
</script>
<html>