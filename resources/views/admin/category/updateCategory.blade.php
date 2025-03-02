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
                <h4 class="card-title">Cập nhật category</h4>
                <div class="form-group row">
                  {{-- ten category --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-ten-category">Tên chính</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" type="text" class="form-control" id="input-ten-category" placeholder="Tên category" oninput="changeData('ten-category')" />
                      <div class="invalid-feedback" id="err-ten-category">
                        
                      </div>
                    </div>
                  </div>
                  {{-- ten viet tat category --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-ten-viet-tat-category">Tên viết tắt</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <input value="" type="text" class="form-control" id="input-ten-viet-tat-category" placeholder="Tên viết tắt category" oninput="changeData('ten-viet-tat-category')" />
                      <div class="invalid-feedback" id="err-ten-viet-tat-category">
                        
                      </div>
                    </div>
                  </div>
                  {{-- avartar --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-lg-4 col-md-12 text-end">
                      <span class="" id="label-avartar-category">Avartar category</span>
                    </div>
                    <div class="col-lg-8 col-md-12">
                      <img id="avartar-category" href="" style="width:100px; height:100px" />
                      <input type="file" class="form-control" id="input-avartar-category" placeholder="Avartar category" oninput="changeData('avartar-category')" />
                      <div class="invalid-feedback" id="err-avartar-category">
                        
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button id="create-category" type="button" class="btn btn-primary" onclick="update()">
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
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        let formatError = {
          "required": [
            {"ten-category": "Tên category không được để trống"},
            {"ten-viet-tat-category": "Tên viết tắt category không được để trống"},
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
        function initData(){
            $.ajax({
                url: host + `/api/category/${id}`,
            })
            .done(res=>{
                $("#input-ten-category").val(res.name);
                $("#input-ten-viet-tat-category").val(res.tenVietTat);
                $("#avartar-category").attr("src",`https://lh3.google.com/u/0/d/${res.image}`);
            })
            .fail(()=>{

            })
        }
        initData();
        //cap nhat du lieu len DB
        function update() {
          let updateBy = 0;
          let createdBy = 0;
          let datas = {
            "updatedBy": updateBy,
            "createdBy": createdBy,
            "name": $("#input-ten-category").val().trim(),
            "tenVietTat": $("#input-ten-viet-tat-category").val().trim(),
            "avartar": $("#input-avartar-category").prop('files'),
            "id": id
          }
          if(getErrorFromFe()) return;
          $("#create-category").attr("disabled",true)
          $("#create-category").html(spinner);

          let form = new FormData();

          form.append("updatedBy", datas.updatedBy);
          form.append("createdBy", datas.createdBy);
          form.append("name", datas.name);
          form.append("tenVietTat", datas.tenVietTat);
          form.append("id", datas.id);
          if($("#input-avartar-category").val()){
            form.append("avartar", $("#input-avartar-category")[0].files[0]);
          }

          setTimeout(()=>{
            $.ajax({
              processData: false,
              contentType: false,
              mimeType: "multipart/form-data",
              url: host + `/api/category/update`,
              method: "POST",
              data: form
            })
              .done(res => {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Cập nhật category thành công',
                  showConfirmButton: false,
                  timer: 1500
                })
                .then(()=>{
                  $("#create-category").attr("disabled",false)
                  $("#create-category").html("Cập nhật");
                  location.reload();
                })
              })
              .fail(err => {
                $("#create-category").attr("disabled",false)
                $("#create-category").html("Cập nhật");
                 Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Lỗi !',
                  text: `${err["responseText"]}`,
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