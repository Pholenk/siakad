<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIAKAD | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/css/font-awesome-4.7.0/css/font-awesome.css">
  <!-- Ionicons >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->
  <!-- Theme style -->
  <link rel="stylesheet" href="/vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css">
  <!-- Custom stylesheet -->
  <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body style="max-height:480px;">
  <div class="login-box">
    <div class="login-logo">
      <a><b>SIAKAD</b>PNC</a>
    </div>
    <div id='error'></div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <form method="post" id="login">
        <div class="input-group">
          <span class="input-group-addon input-icon"><i class="fa fa-user"></i></span>
          <input type="text" name="username" id="username" class="form-control input-text" placeholder="Username">
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon input-icon"><i class="fa fa-unlock"></i></span>
          <input type="password" name="password" id="password" class="form-control input-text" placeholder="Password">
        </div>
        <br />
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
      </form>
    </div>
    <!-- /.login-box-body -->
    <div class="box-footer">
      <div class="col-xs-5">
        
      </div>
    </div>
  </div>
  <script src="/vendor/almasaeed2010/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="/vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js"></script>
  <!-- Custom js -->
  <script src="/assets/js/custom.js"></script>
</body>

</html>