<!DOCTYPE html>
<html dir="ltr" lang="en">
@include('layout/header')
<body>
  @include('layout/topbar')
  @include('layout/leftbar')
  <style>
    #table-data tr th {
      background-color: #34b7eb;
      color: black;
      font-size: 16px;
    }

    #table-data tr td {
      color: black
    }
  </style>
  <div class="page-wrapper" style="overflow: scroll;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <form class="form-horizontal">
              <div class="card-body">
                <h4 class="card-title">Thêm mới user</h4>
                <div class="form-group row">
                  {{-- ten user --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-ten-dang-nhap">Tên đăng nhập</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input disabled value="" type="text" class="form-control" id="input-ten-dang-nhap" placeholder="Tên đăng nhập" oninput="changeData('ten-dang-nhap')" />
                      <div class="invalid-feedback" id="err-ten-dang-nhap">
                        
                      </div>
                    </div>
                  </div>
                  {{-- ten viet tat user --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-ten-nguoi-dung">Tên người dùng</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" type="text" class="form-control" id="input-ten-nguoi-dung" placeholder="Tên người dùng" oninput="changeData('ten-nguoi-dung')" />
                      <div class="invalid-feedback" id="err-ten-nguoi-dung">
                        
                      </div>
                    </div>
                  </div>
                  {{-- pasword --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-password">Password</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" type="password" class="form-control" id="input-password" placeholder="Password" oninput="changeData('pasword')" />
                      <div class="invalid-feedback" id="err-password">
                        
                      </div>
                    </div>
                  </div>
                  {{-- position --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-vi-tri">Vị trí</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" class="form-control" id="input-vi-tri" placeholder="Vị trí" oninput="changeData('vi-tri')" />
                      <div class="invalid-feedback" id="err-vi-tri">
                        
                      </div>
                    </div>
                  </div>
                  {{-- coporation --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-don-vi">Đơn vị</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" class="form-control" id="input-don-vi" placeholder="Đơn vị" oninput="changeData('don-vi')" />
                      <div class="invalid-feedback" id="err-don-vi">
                        
                      </div>
                    </div>
                  </div>
                  {{-- role --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-role">Loại</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <select class="form-select" id="input-role" onchange="changeData('role')">
                        <option value="" selected disabled>---SELECT ROLE---</option>
                        <option value="1">ADMIN</option>
                        <option value="2">PARTNER</option>
                        <option value="3">PLAYER</option>
                      </select>
                      <div class="invalid-feedback" id="err-role">
                        
                      </div>
                    </div>
                  </div>
                  {{-- email --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-email">Email</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input type="text" class="form-control" id="input-email" placeholder="Email" oninput="changeData('email')" />
                      <div class="invalid-feedback" id="err-email">
                        
                      </div>
                    </div>
                  </div>
                  {{-- avartar --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-avartar">Avartar</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <img id="image-avartar" src="" style="width:100px; height:100px" />
                      <input type="file" class="form-control" id="input-avartar" placeholder="Avartar" oninput="changeData('avartar')" />
                      <div class="invalid-feedback" id="err-avartar">
                        
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button id="update-user" type="button" class="btn btn-primary" onclick="update()">
                        Cập nhật
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
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('layout/footer')
    <script>
        const spinner = `<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>`
        let formatError = {
          "required": [
            {"ten-dang-nhap": "Tên đăng nhập không được để trống"},
            {"ten-nguoi-dung": "Tên người dùng không được để trống"},
            {"role": "Loaị người dùng không được bỏ trống"},
            {"vi-tri": "Vị trí không được để trống"},
            {"don-vi": "Đơn vị không được để trống"}
          ],
          "email":[
            {"email": "Tên email phải bao gồm 8 kí tự và có đuôi là gmail.com"},
          ],
          "phone":[
            
          ],
          "mobile":[
            
          ],
          "viettat":[
            
          ]
        }
        let listError = {
          "ten-category": "tenCategory",
        }
        // init data
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const guid = urlParams.get('guid');
        function initData(){
            $.ajax({
                url: host + `/api/user/detail/${id}/${guid}`
            })
            .done(res=>{
                $("#input-ten-dang-nhap").val(res["userName"])
                $("#input-ten-nguoi-dung").val(res["name"])
                $("#input-password").val(res["password"])
                $("#input-email").val(res["email"])
                $("#input-role").val(res["roleId"])
                $("#input-vi-tri").val(res["position"])
                $("#input-don-vi").val(res["coporation"])
                $("#image-avartar").attr("src", `${res["image"]?`https://lh3.google.com/u/0/d/${res["image"]}`:"/public/assets/images/no-image.png"}`)
            })
            .fail(()=>{
               
            })
        }
        initData()
        //cap nhat du lieu len DB
        function update() {
          let updateBy = +getCookie("id");
          let createdBy = +getCookie("id");
          let datas = {
            "id": id,
            "guid": guid,
            "updatedBy": updateBy,
            "userName": $("#input-ten-dang-nhap").val().trim(),
            "name": $("#input-ten-nguoi-dung").val().trim(),
            "email": $("#input-email").val().trim()||" ",
            "password": $("#input-password").val().trim(),
            "roleId": $("#input-role").val(),
            "avartar": $("#input-avartar").prop('files'),
            "position": $("#input-vi-tri").val().trim(),
            "coporation": $("#input-don-vi").val().trim(),
          }
          
          if(getErrorFromFe()) return;
          $("#update-user").attr("disabled",true)
          $("#update-user").html(spinner);

          let form = new FormData();

          form.append("updatedBy", datas.updatedBy);
          form.append("createdBy", datas.createdBy);
          form.append("userName", datas.userName);
          form.append("name", datas.name);
          form.append("password", datas.password);
          form.append("roleId", datas.roleId);
          form.append("avartar", $("#input-avartar")[0].files[0]);
          form.append("guid", datas.guid);
          form.append("id", datas.id);
          form.append("email", datas.email);
          form.append("position", datas.position);
          form.append("coporation", datas.coporation);
          
          setTimeout(()=>{
            $.ajax({
              processData: false,
              contentType: false,
              mimeType: "multipart/form-data",
              url: host + `/api/user/update`,
              method: "POST",
              data: form
            })
            .done(res => {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Cập nhật user thành công',
                  showConfirmButton: false,
                  timer: 1500
                })
                $("#update-user").attr("disabled",false)
                $("#update-user").html("Cập nhật");
                location.reload();
              })
            .fail(err => {
                $("#update-user").attr("disabled",false)
                $("#update-user").html("Cập nhật");
                 Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Lỗi !',
                  text: `${err.status==500 ?"Lỗi server": err["responseText"]}`,
                  showConfirmButton: false,
                  timer: 1500
                })
            })
          })
        }
        //hien thi loi tai front-end
        function getErrorFromFe(){
          let isErr = false;
          for(let key of Object.keys(formatError)){
            if(key=="required"){
              for(let i=0; i<formatError[key].length; i++){
                  let val = $(`#input-${Object.keys(formatError[key][i])[0]}`).val()?.trim();
                  if(val==""||val==null){
                    $(`#input-${Object.keys(formatError[key][i])[0]}`).addClass("is-invalid");
                    $(`#label-${Object.keys(formatError[key][i])[0]}`).addClass("text-danger");
                    $(`#err-${Object.keys(formatError[key][i])[0]}`).text(`${Object.values(formatError[key][i])[0]}`);
                    isErr = true;
                  }
              }
            }
            if(key=='email'){
              for(let i=0; i<formatError[key].length; i++){
                  let val = $(`#input-${Object.keys(formatError[key][i])[0]}`).val()?.trim();
                  if(!/^[a-zA-Z0-9]{8,}@(gmail.com)$/.test(val) && val!=""){
                    $(`#input-${Object.keys(formatError[key][i])[0]}`).addClass("is-invalid");
                    $(`#label-${Object.keys(formatError[key][i])[0]}`).addClass("text-danger");
                    $(`#err-${Object.keys(formatError[key][i])[0]}`).text(`${Object.values(formatError[key][i])[0]}`);
                    isErr = true;
                  }
              }
            }
            if(key=='phone'){
              for(let i=0; i<formatError[key].length; i++){
                  let val = $(`#input-${Object.keys(formatError[key][i])[0]}`).val()?.trim();
                  if(!(/^0[0-9]{3}\.[0-9]{7}$/.test(val)||/^0[0-9]{3}[0-9]{7}$/.test(val)) && val!=""){
                    $(`#input-${Object.keys(formatError[key][i])[0]}`).addClass("is-invalid");
                    $(`#label-${Object.keys(formatError[key][i])[0]}`).addClass("text-danger");
                    $(`#err-${Object.keys(formatError[key][i])[0]}`).text(`${Object.values(formatError[key][i])[0]}`);
                    isErr = true;
                  }
              }
            }
            if(key=='mobile'){
              for(let i=0; i<formatError[key].length; i++){
                  let val = $(`#input-${Object.keys(formatError[key][i])[0]}`).val()?.trim();
                  if(!/^0[0-9]{9}$/.test(val) && val!=""){
                    $(`#input-${Object.keys(formatError[key][i])[0]}`).addClass("is-invalid");
                    $(`#label-${Object.keys(formatError[key][i])[0]}`).addClass("text-danger");
                    $(`#err-${Object.keys(formatError[key][i])[0]}`).text(`${Object.values(formatError[key][i])[0]}`);
                    isErr = true;
                  }
              }
            }
            if(key=='viettat'){
              for(let i=0; i<formatError[key].length; i++){
                  let val = $(`#input-${Object.keys(formatError[key][i])[0]}`).val()?.trim();
                  if(!/^[a-z0-9A-Z]\S*$/.test(val) && val!=""){
                    $(`#input-${Object.keys(formatError[key][i])[0]}`).addClass("is-invalid");
                    $(`#label-${Object.keys(formatError[key][i])[0]}`).addClass("text-danger");
                    $(`#err-${Object.keys(formatError[key][i])[0]}`).text(`${Object.values(formatError[key][i])[0]}`);
                    isErr = true;
                  }
              }
            }
          }
          return isErr;
        }
        //hien thi loi duoc tra tu back-end
        function getErrorFromDB(err, listError){
          let contentErr = err["mesage"];
          $(`#err-${key}`).text(contentErr);
          $(`#input-${key}`).addClass("is-invalid");
          $(`#label-${key}`).addClass("text-danger");
        }
        //remove hien thi loi khi cap nhat lai du lieu
        function changeData(param){
          $(`#err-${param}`).text("");
          $(`#input-${param}`).removeClass("is-invalid");
          $(`#label-${param}`).removeClass("text-danger");
        }
    </script>
</body>
<html>