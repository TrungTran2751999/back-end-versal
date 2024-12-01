@include('layout/header')
@include('layout/topbar')
@include('layout/leftbar')
<body>
    <div class="page-wrapper">
        <div class="col-12">
            <div class="card" style="overflow: scroll">
                <table class="table" id="table-data">
                    <thead>
                        <th style="min-width: 20px">STT</th>
                        <th style="min-width: 300px">TIÊU ĐỀ</th>
                        <th style="min-width: 200px">NGÀY TẠO</th>
                        <th style="min-width: 200px">NGÀY CẬP NHẬT</th>
                        <th style="min-width: 200px">NGƯỜI CẬP NHẬT</th>
                        <th style="min-width: 200px">TRẠNG THÁI</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layout/footer')
    <script>
        $.ajax({
            url: host + "/api/blog"
        })
        .done(res=>{
            let rows = "";
            for(let i=0; i<res.length; i++){
                let row = `
                <tr>
                    <td>${i+1}</td>
                    <td><a href="/admin/blog/update?id=${res[i].id}">${res[i].title}</a></td>
                    <td>${res[i].createdAt}</td>
                    <td>${res[i].updatedAt}</td>
                    <td>${res[i].name}</td>
                    <td>
                        ${res[i].status}
                    </td>
                </tr>
                `;
                rows+=row;
            }
            $("#table-data tbody").html(rows);
        })
    </script>
</body>