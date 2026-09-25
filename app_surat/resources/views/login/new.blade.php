<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Surat</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
</head>

<body style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
    <div class="container login-container">
        <div class="row">
            <div class="col-md-12 header-form">
                <h2>E-Surat PTA Bandung</h2>
            </div>

            <div class="col-md-6 login-form-1">
                <h3>Login E-Surat PTA Bandung</h3>
                <form action="{{ url('/auth')}}" method="post" class="form" id="b-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP *" value="" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password *" value="" />
                    </div>
                    
                    @if ($errors->get('email'))
                        <div class="alert alert-danger" id="error-login">
                            @foreach ($errors->get('email') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <input type="submit" class="btnSubmit" value="Masuk" />
                    </div>
                </form>
            </div>
            <div class="col-md-6 login-form-2">
                <h3>Lacak Surat Masuk</h3>
                <form action="{{ url('/lacak_public')}}" method="post" class="form" id="a-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nomor Surat *" id="no_surat" name="no_surat" value="{{old('no_surat')}}" required />
                    </div>
                    <div class="form-group">
                        <div class="captcha">
                            <span>{!! captcha_img() !!}</span> &nbsp;
                            <button type="button" class="btn btn-danger" class="refresh-captcha" id="refresh-captcha">
                                &#x21bb;
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Kode Captcha *" id="captcha" name="captcha" required />
                    </div>

                    @if ($errors->get('captcha'))
                        <div class="alert alert-danger" id="error-captcha">
                            @foreach ($errors->get('captcha') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <input type="submit" class="btnSubmit" value="Lacak Surat" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    $('#refresh-captcha').click(function () {
        $.ajax({
            type: 'GET',
            url: "{{ route('reload_captcha') }}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>

<style>
    .body {
        background-image: url('file:///C:/Users/ardip/Documents/surat/resources/views/new_login/bg.jpg') !important;
    }

    .login-container {
        margin-top: 2%;
        margin-bottom: 5%;
    }

    .header-form {
        border-radius: 3px;
        margin-bottom: 20px;
        padding: 5%;
        background: #ffffffbd;
        box-shadow: 0 5px 8px 0 rgb(0 0 0), 0 9px 26px 0 rgb(255 255 255 / 42%);
    }

    .header-form h2 {
        text-align: center;
        color: #ab26aa;
    }

    .login-form-1 {
        padding: 5%;
        background: #ffffffe6;
        box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
    }

    .login-form-1 h3 {
        text-align: center;
        color: #ab26aa;
    }

    .login-form-2 {
        padding: 5%;
        background: #ab26aae6;
        box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
    }

    .login-form-2 h3 {
        text-align: center;
        color: #fff;
    }

    .login-container form {
        padding: 10%;
    }

    .btnSubmit {
        width: 50%;
        border-radius: 1rem;
        padding: 1.5%;
        border: none;
        cursor: pointer;
    }

    .login-form-1 .btnSubmit {
        font-weight: 600;
        color: #fff;
        background-color: #ab26aa;
    }

    .login-form-2 .btnSubmit {
        font-weight: 600;
        color: #ab26aa;
        background-color: #fff;
    }

    .login-form-2 .ForgetPwd {
        color: #fff;
        font-weight: 600;
        text-decoration: none;
    }

    .login-form-1 .ForgetPwd {
        color: #0062cc;
        font-weight: 600;
        text-decoration: none;
    }
</style>

</html>