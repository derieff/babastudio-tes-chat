<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link href="{{ url('public/bootstrap/css/bootstrap.min.css') }}" type="text/scs" /> -->
        <link rel = "stylesheet" href= "{{ url('public/css/bootstrap.min.css')}}">

        <link href="{{ url('public/font-awesome/css/font-awesome.min.css') }}" type="text/scs" /> 

        <link href="{{ url('public/css/sweetalert.css') }}" type="text/scs" />       

        <style type="text/css">
            .content{
                min-height:600px;
                max-height:600px;
            }
            textarea{
                resize:none;
            }
            .user-list{
                min-height: 600px;
                max-height: 600px;
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
            .chat-show .list{
                padding:5px 10px;
                border-bottom: 1px dashed #aaa;
            }
            .chat-form{
                min-height: 100px;
                max-height: 100px;
                border:1px solid #777;
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
                                    <br>
                                    <input type="file" name="file">
                                </div>
                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-success btn-lg" id="button-kirim">
                                        <i class="fa fa-send"></i> KIRIM
                                    </button>
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
                        chat_list_html = chat_list_html+"\
                            <div class='list' onclick='delete_chat(\""+result[i].id+"\")'>\
                                <b>"+result[i].name+"</b><br>\
                                <p>"+result[i].text+"</p>\
                            </div>\
                        ";
                    });
                    $('.chat-show').html(chat_list_html);
                },
                error: function (error) {
                  console.log(error);
                }
            });
        }

        chat_show("{{ Session::get('user_id') }}");

        function load_users(){
            var link = "{{ url('api/get-all-users') }}";

            var user_list_html = "<a href='{{ url('logout') }}'>Logout</a><hr>";

            $.ajax({
                url: link,
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $.each(result, function(i){
                        user_list_html = user_list_html+"\
                            <div class='list' onclick='chat_show(\""+result[i].id+"\")'>\
                                <b>"+result[i].name+"</b><br>\
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