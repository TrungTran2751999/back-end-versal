@include('layout/header')
@include('layout/topbar')
@include('layout/leftbar')
<body>
    <div class="page-wrapper">
        <div class="col-12">
            <div class="card">
                <table class="table" id="table-data">
                    <thead>
                        <th>STT</th>
                        <th>USERNAME</th>
                        <th>NAME</th>
                        <th>AVARTAR</th>
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
            url: host + "/api/user"
        })
        .done(res=>{
            res && res.length > 0 ? res = res.filter(x=>x.userName!="adminMaster"): ""
            let rows = "";
            for(let i=0; i<res.length; i++){
                let row = `
                <tr>
                    <td>${i+1}</td>
                    <td><a href="/admin/user/update?id=${res[i].id}&guid=${res[i].guid}">${res[i].userName}</a></td>
                    <td>${res[i].name}</td>
                    <td>
                        ${res[i].image ? 
                            `<image src="https://lh3.google.com/u/0/d/${res[i].image}" width=100px height=100px/>`
                            :`<image src="/public/assets/images/no-image.png" width=100px height=100px/>`
                        }
                    </td>
                </tr>
                `;
                rows+=row;
            }
            $("#table-data tbody").html(rows);
        })
    </script>
</body>