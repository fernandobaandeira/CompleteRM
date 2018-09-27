<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="lte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <?php include_once 'view/fragments/language.php'; $txt=language(); ?>
  <title><?php echo $txt[0].' | '.$txt[62]; ?></title>
</head>
<body class="hold-transition login-page bg-secondary">
<div class="login-box">
  <div class="login-logo text-center">
    <img src="view/img/logo.png" class="img-circle" style="width:110px">
    <p><strong><?php echo $txt[0]; ?></strong></p>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo $txt[60]; ?></p>
    <form action="view/operator/login.php" method="post">
      <div class="form-group has-feedback">
        <input required minlength="4" maxlength="30" type="text" name="login" class="form-control" placeholder="<?php echo $txt[62]; ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input required minlength="4" maxlength="30" type="password" name="password" class="form-control" placeholder="<?php echo $txt[63]; ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="login-box">
          <button type="submit" class="btn btn-success btn-block btn-flat"><?php echo $txt[61]; ?></button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>