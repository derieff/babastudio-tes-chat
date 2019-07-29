<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ url('public/bootstrap/css/bootstrap.css') }}" type="text/scs" />
        <link rel = "stylesheet" href= "{{ url('public/css/bootstrap.min.css')}}">

        <link href="{{ url('public/font-awesome/css/font-awesome.min.css') }}" type="text/scs" /> 

        <link href="{{ url('public/css/sweetalert.css') }}" type="text/scs" />       

        <style type="text/css">
            .content{
                min-height:630px;
                max-height:630px;
            }
            textarea{
                resize:none;
            }
            .user-list{
                min-height: 630px;
                max-height: 630px;
                border:1px solid #777;
                overflow-y: scroll;
            }
            .user-list .list{
                padding:10px 5px;
                border-bottom:1px dashed #aaa;
            }

            .chat-show{
                min-height: 500px;
                max-height: 500px;
                border:1px solid #777;
                overflow-y: scroll;
            }
            .box-file{
                margin:5px;
                padding:5px;
                border:1px solid #bbb;
                border-radius:10px;
                font-size:11px;
            }
            .chat-show .list{
                padding:5px 10px;
                border-bottom: 1px dashed #aaa;
            }
            .chat-show .list .textright{
                text-align: right;
            }
            .chat-show .list .textleft{
                text-align: left;
            }
            .chat-form{
                min-height: 130px;
                max-height: 130px;
                border:1px solid #777;
            }
            .col-file{
                margin-top:10px;
                margin-left:15px;
                border-top:1px dashed #777;
                padding-top:10px;
            }
        </style>
    </head>
    <body>
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="user-list">

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chat-show">
                        </div>
                        <div class="chat-form">
                            <form action="{{ url('api/send-message') }}" method="post" enctype="multipart/form-data"> 
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                                <input name="user_id" value="{{ Session::get('user_id') }}" type="hidden" />
                                <div class="col-md-10">
                                    <textarea class="form-control" name="text" id="message" resize="none" required maxlength="200"></textarea>
                                </div>
                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-success btn-lg" id="button-kirim">
                                        <i class="fa fa-paper-plane"></i> KIRIM
                                    </button>
                                </div>
                                <div class="col-md-10 col-file">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="title_file" placeholder="Title File">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="file" accept="image/*">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script src="{{ url('public/js/jquery.min.js') }}"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('public/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('public/js/sweetalert.min.js') }}"></script>
    @include('sweet::alert')

    <script>
        $(document).ready(function(){
            $('#button-kirim').click(function(){
                var message = $('#message').html();
                var collection_data = {
                    'user_id' : "{{ Session::get('user_id') }}",
                    'text' : message,
                };
                $.ajax({
                    url : "{{ url('api/send-message') }}",
                    type : "POST",
                    data : collection_data,
                    success: function(result){
                        chat_show("{{ Session::get('user_id') }}");
                    },
                    error: function (error){
                        swal({
                            title: "Gagal.",
                            text: "Terjadi kesalahan silahkan periksa kembali",
                            showConfirmButton: false,
                            timer: 2500,
                            type: "error",
                        });
                    }
                });
            });
        });

        function chat_show(user_id){
            var link = "{{ url('api/get-all-messages') }}";

            var chat_list_html = "";

            $.ajax({
                url: link,
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $.each(result, function(i){
                        var file_attached = "";
                        if(result[i].file_id != null){
                            file_attached = "<div class='box-file'>\
                                <b>File tersedia</b> : <br>\
                                "+result[i].title+"<br>"+result[i].file+"<br>\
                                <a href='{{ url('public/files/stored') }}/"+result[i].file+"' download>\
                                    Unduh <i class='fa fa-download'></i>\
                                </a>\
                            </div>";
                        }

                        var text_align = "";
                        if(result[i].user_id == user_id){
                            text_align = "text-right";
                        }

                        chat_list_html = chat_list_html+"\
                            <div class='list "+text_align+"' onclick='delete_chat(\""+result[i].id+"\")'>\
                                <b>"+result[i].name+"</b><br>\
                                <p>"+result[i].text+"</p>\
                                "+file_attached+"\
                            </div>\
                        ";
                    });
                    $('.chat-show').html(chat_list_html);

                    // var objDiv = $('.chat-show');
                    // objDiv.scrollTop = objDiv.scrollHeight;

                    $('.chat-show').animate({
                        scrollTop: $('.chat-show').get(0).scrollHeight}, 2000
                    );
                },
                error: function (error) {
                  console.log(error);
                }
            });
        }

        chat_show("{{ Session::get('user_id') }}");

        function load_users(){
            var link = "{{ url('api/get-all-users') }}";

            var user_list_html = "<a href='{{ url('logout') }}'>Logout</a><hr>\
            <div class='text-center'>\
                <b>Member List</b>\
            </div>";

            $.ajax({
                url: link,
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $.each(result, function(i){
                        var anda = "";
                        if(result[i].id == "{{ Session::get('user_id') }}"){
                            anda = "<small>(Anda)</small>";
                        }
                        user_list_html = user_list_html+"\
                            <div class='list' onclick='chat_show(\""+result[i].id+"\")'>\
                                <b>"+result[i].name+" "+anda+"</b><br>\
                                <small>"+result[i].email+"</small>\
                            </div>\
                        ";
                    });
                    $('.user-list').html(user_list_html);
                },
                error: function (error) {
                  console.log(error);
                }
            });
        }
        load_users();
    </script>
</html>