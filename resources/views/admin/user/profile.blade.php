@include('layout/header')

<body>
  @include('layout/topbar')
  @include('layout/leftbar')
  <div class="page-wrapper" style="overflow: scroll;">
    <style>
        .feild-icon{
            float: right;
            margin-right: 20px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
        .feild-icon:hover{
          cursor: pointer;
        }
        .feedback-invalid{
          color: red;
          font-size: small;
        }
    </style>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <form class="form-horizontal">
                <div class="card-body">
                  <h4 class="card-title">Mật khẩu</h4>
                  <div class="form-group row">
  
                    {{-- <div class="row mb-3 align-items-center">
                      <div class="col-lg-4 col-md-12 text-end">
                        <span class="" id="label-mat-khau-cu">Mật khẩu cũ</span>
                      </div>
                      <div class="col-lg-8 col-md-12">
                        <input type="password" class="form-control" id="input-mat-khau-cu" placeholder="Mât khẩu cũ" oninput="onChangeInput(this)"/>
                        <i class="fa fa-eye feild-icon" onclick="anHienPass(this, '#input-mat-khau-cu')"></i>
                        <div class="feedback-invalid" id="err-mat-khau-cu">
                          
                        </div>
                      </div>
                    </div> --}}
  
                    <div class="row mb-3 align-items-center">
                      <div class="col-lg-4 col-md-12 text-end">
                        <span class="" id="label-ten-nha-cung-ung">Mật khẩu mới</span>
                      </div>
                      <div class="col-lg-8 col-md-12">
                          <input type="password" class="form-control" id="input-mat-khau-moi" placeholder="Mật khẩu mới" oninput="onChangeInput(this)"/>
                          <i class="fa fa-eye feild-icon" onclick="anHienPass(this, '#input-mat-khau-moi')"></i>
                          <div class="feedback-invalid" id="err-mat-khau-moi">
                              
                          </div>
                      </div>
                    </div>
  
                    <div class="row mb-3 align-items-center">
                      <div class="col-lg-4 col-md-12 text-end">
                        <span class="" id="label-nhap-lai-mat-khau-moi">Nhập lại mật khẩu mới</span>
                      </div>
                      <div class="col-lg-8 col-md-12">
                        <input type="password" class="form-control" oninput="nhapLaiMatKhauMoi()" id="input-nhap-lai-mat-khau-moi" placeholder="Nhập lại mật khẩu mới"/>
                        <i class="fa fa-eye feild-icon" onclick="anHienPass(this, '#input-nhap-lai-mat-khau-moi')"></i>
                        <div class="feedback-invalid" id="err-nhap-lai-mat-khau-moi">
                          
                        </div>
                      </div>
                    </div>
  
                    <div class="border-top">
                      <div class="card-body">
                        <button onclick="doiMatKhau()" id="doi-mat-khau" type="button" class="btn btn-primary">
                          Đổi mật khẩu
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
    @include('layout/footer')
    <script>
        function doiMatKhau(){
          if(!validate()){
              callApiDoiMatKhau();
          }
        }
        
        function onChangeInput(param){
          let id = $(param).attr("id").split("input-")[1];
          $(`#err-${id}`).text("");
        }
        
        function callApiDoiMatKhau(){
          $("#doi-mat-khau").attr("disabled",true);
            let data = {
              "id": getCookie("id"),
              "guid": getCookie("guid"),
              "password": $("#input-mat-khau-moi").val().trim(),
            }
            $.ajax({
              url: host + "/api/user/change-pass",
              "headers": {
                "Content-Type": "application/json"
              },
              method: "POST",
              data: JSON.stringify(data)
            })
            .done(res=>{
               Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "Đổi mật khẩu thành công!",
                  showConfirmButton: false,
                  timer: 1500
                });
                $("#doi-mat-khau").attr("disabled",false);
            })
            .fail(err=>{
                Swal.fire({
                  position: "center",
                  icon: "error",
                  title: `${err.responseText ? err.responseText.split(":")[1] : "Đổi mật khẩu thất bại!"}`,
                  showConfirmButton: false,
                  timer: 1500
                });
                $("#doi-mat-khau").attr("disabled",false);
            })
        }
        
        function nhapLaiMatKhauMoi(){
          let nhapLaiMatKhau = $("#input-nhap-lai-mat-khau-moi").val().trim();
          let matKhauMoi = $("#input-mat-khau-moi").val().trim();
          if(matKhauMoi != nhapLaiMatKhau && matKhauMoi && nhapLaiMatKhau){
             $("#err-nhap-lai-mat-khau-moi").text("Nhập lại mật khẩu không đúng !");
          }else{
            $("#err-nhap-lai-mat-khau-moi").text("");
          }
        }
        
        function validate(){
          let validate = {
            "mat-khau-moi": $("#input-mat-khau-moi").val().trim(),
            "nhap-lai-mat-khau-moi": $("#input-nhap-lai-mat-khau-moi").val().trim()
          }
          let isFall = false;
          for(let key of Object.keys(validate)){
            if(!validate[key]){
              $(`#err-${key}`).text("Không được để trống !");
              isFall = true
            }else if(validate[key].length<=8 && key!="mat-khau-cu"){
              $(`#err-${key}`).text(" Mật khẩu phải lớn hơn 8 kí tự!");
              isFall = true;
            }
          }
          return isFall;
          
        }

        function anHienPass(param, element){
          if($(element).attr("type")=="password"){
              $(param).attr("class","fa fa-eye-slash feild-icon");
              $(element).attr("type","text");
          }else{
              $(param).attr("class","fa fa-eye feild-icon");
              $(element).attr("type","password");
          }
        }
    </script>
</body>