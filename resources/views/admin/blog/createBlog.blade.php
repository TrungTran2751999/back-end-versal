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
        <div class="col-md-6" style="width: 100%">
          <div class="card">
            <form class="form-horizontal">
              <div class="card-body">
                <h4 class="card-title">Tạo mới blog</h4>
                <div class="form-group row">
                  {{-- title --}}
                  <div class="row mb-3 align-items-center">
                    <div class="">
                      <span class="" id="label-title">Tên tiêu đề</span>
                    </div>
                    <div class="">
                      <input value="" type="text" class="form-control" id="input-title" placeholder="Tên tiêu đề" oninput="changeData('title')" />
                      <div class="invalid-feedback" id="err-title">
                        
                      </div>
                    </div>
                  </div>
                  {{-- brief --}}
                  <div class="row mb-3 align-items-center">
                    <div class="">
                      <span class="" id="label-tom-tat">Tóm tắt</span>
                    </div>
                    <div class="">
                      <input  class="form-control" id="input-tom-tat" placeholder="Tóm tắt" oninput="changeData('tom-tat')"/>
                      <div class="invalid-feedback" id="err-tom-tat">
                        
                      </div>
                    </div>
                  </div>
                  {{-- content --}}
                  <div class="row mb-3 align-items-center">
                    <div class="">
                      <span class="" id="label-noi-dung">Nội dung</span>
                    </div>
                    <div class="">
                      <div style="width: 100%" id="input-content" ></div>
                      <input id="input-contents" style="display: none" onchange="changeData('contents')"/>
                      <div class="invalid-feedback" id="err-contents">
                        
                      </div>
                    </div>
                  </div>
                  
                  <div class="border-top">
                    <div class="card-body">
                      <button id="create-blog" type="button" class="btn btn-primary" onclick="create()">
                        Tạo mới
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
    <script src="{{asset('/public/lib/quill/quill.js')}}">></script>
    <link href="{{asset('/public/lib/quill/quill.css')}}" rel="stylesheet">
    <script>
      const spinner = `<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>`
      let formatError = {
          "required": [
            {"title": "Tên tiêu đề không được để trống"},
            {"contents": "Nội dung blog không được để trống"},
            {"tom-tat": "Nội dung tóm tắt không được để trống"},
          ],
          "phone":[
            
          ],
          "mobile":[
            
          ],
          "viettat":[
            
          ]
        }
      //Config Quilljs
      let toolbarOption = [
        [{header:[1,2,3,4,5,6,false]}],
        ["bold","italic","underline","strike"],
        [{list:"ordered"},{list:"bullet"}],
        [{script:"super"},{script:"sub"}],
        [{indent:"+1"},{indent:"-1"}],
        [{align:[]}],
        [{size:["small","large","huge",false]}],
        ["image","link","video","formula"],
        [{color:[]},{background:[]}],
        [{font:[]}],
        ["code-block"]
      ]
      let quill = new Quill('#input-content', {
          theme: 'snow',
          modules: {
            toolbar: toolbarOption
          }
      });
      //cap nhat du lieu len DB
      function create() {
        let text = quill.getText().trim();
        $("#input-contents").val(text)
        let obj = {
          title: $("#input-title").val(),
          content: quill.root.innerHTML,
          brief: $("#input-tom-tat").val(),
          text: text,
          createdBy: +getCookie("id"),
          updatedBy: +getCookie("id")
        }
        
        if(getErrorFromFe()) return;
        $("#create-blog").attr("disabled",true);
        $("#create-blog").html(spinner);
        $.ajax({
          url: host + "/api/blog",
          "headers": {
            "Content-Type": "application/json"
          },
          method: "POST",
          data: JSON.stringify(obj)
        })
        .done(res=>{
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Thông báo",
            html: "Tạo blog thành công",
            showConfirmButton: false,
            timer: 1500
          });
          $("#create-blog").attr("disabled",false);
          $("#create-blog").html("Tạo mới");
          location.reload();
        })
        .fail(err=>{
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Thông báo",
            html: "Tạo blog thất bại",
            showConfirmButton: false,
            timer: 1500
          });
          $("#create-blog").attr("disabled",false);
          $("#create-blog").html("Tạo mới");
        })
      }
      
      //remove hien thi loi khi cap nhat lai du lieu
      function changeData(param){
        $(`#err-${param}`).text("");
        $(`#input-${param}`).removeClass("is-invalid");
        $(`#label-${param}`).removeClass("text-danger");
      }

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
      
    </script>
</body>
<html>