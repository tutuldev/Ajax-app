<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- jquery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>ajax-app</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">All Teacher</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <th scope="row">1</th>
                                    <td>Tutul</td>
                                    <td>Title</td>
                                    <td>Cwl</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary mr-2">Edit</button>
                                        <button class="btn btn-sm btn-danger mr-2">Edit</button>
                                    </td>
                                </tr> --}}


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        <div class="col-md-3 ">
            <div class="card">
                <div class="card-header">
                    <span id="addT">Add New Teacher</span>
                    <span id="updateT">Update Teacher</span>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                                placeholder="your name">
                                <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" aria-describedby="emailHelp"
                                placeholder="your title">
                                <span class="text-danger" id="titleError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="institute" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="institute" aria-describedby="emailHelp"
                                placeholder="your institute">
                                <span class="text-danger" id="instituteError"></span>
                        </div>

                        <button>test</button>
                        <p type="submit" id="addBtn" onclick="addData()" class="btn btn-primary">Add</p>
                        {{-- <button type="submit" id="addBtn" onclick="addData()" class="btn btn-primary">Add</button> --}}
                        <button type="submit" id="updateBtn" class="btn btn-primary">Update</button>
                    </form>
                </div>

            </div>
        </div>
        </div>
    </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $('#addt').show();
        $('#updateT').hide();
        $('#addBtn').show();
        $('#updateBtn').hide();

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })

        function allData(){
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/teacher/all",
                success: function(response){
                    var data = ""
                    $.each(response,function(key,value){
                        data = data + "<tr>"
                        data = data + "<td>"+ value.id+"</td>"
                        data = data + "<td>"+ value.name+"</td>"
                        data = data + "<td>"+ value.title+"</td>"
                        data = data + "<td>"+ value.institute+"</td>"
                        data = data + "<td>"
                        data = data + "<button class='btn btn-sm btn-primary ms-2'>Edit</button>"
                        data = data + "<button class='btn btn-sm btn-danger ms-2'>Delete</button>"
                        data = data + "</td>"
                        data = data + "</tr>"

                    })
                    $('tbody').html(data);
                }
            })
        }
        allData();
        function clearData(){
          $('#name').val('');
            $('#title').val('');
             $('#institute').val('');
             $('#nameError').text('');
                $('#titleError').text('');
                $('#instituteError').text('');
        }
        function addData(){
           var name = $('#name').val();
           var title = $('#title').val();
           var institute = $('#institute').val();

           $.ajax({
            type:"post",
            dataType:"json",
            data:{name:name,title:title,institute:institute},
            url:"/teacher/store/",
            success: function(data){
                clearData();
                allData();

                console.log('success fully data added');
            },
            error: function (error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
                // console.log(error.responseJSON.errors.name);
                // console.log(error.responseJSON.errors.title);
                // console.log(error.responseJSON.errors.institute);
            }
           })

        }
    </script>

</body>

</html>
