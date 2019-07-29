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
            .container{
            	margin:3% 1%;
            	max-width: 360px;
            }
            textarea{
                resize:none;
            }
            .login-form{
            	padding:10px;
            	border: 1px solid #777;
            }
        </style>
    </head>
    <body>
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="login-form">
                            <form action="{{ url('process-login') }}" method='post'>
                            	<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
			                    <div class="input-group">
			                        <div class="form-line">
			                            <input type="email" class="form-control" name="email" placeholder="Email" required autocomplete="new-email">
			                        </div>
			                    </div>
			                    <div class="input-group">
			                        <div class="form-line">
			                            <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
			                        </div>
			                    </div>
			                    <div class="input-group">
                                    <button type="submit" class="btn btn-success" id="button-login">
                                        <i class="fa fa-send"></i> LOGIN
                                    </button>
                                </div>
                                <br>
                                <a href="{{ url('form-register') }}">
                                	Daftar baru
                                </a>
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
</html>