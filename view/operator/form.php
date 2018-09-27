<!DOCTYPE html>
<html>
<head>
  <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/operator.php';
    if ($_SESSION['is_admin']=='f'){
      header("Location:../lead/list.php");
      die();
  	}
    $update = false;
    if(isset($_GET["id"])){
    	$operator = find($_GET['id']);
    	if ($operator != false) $update=true;
    }
  ?>
  <title><?php echo $txt[64]; ?> | <?php if($update) echo $txt[18]; else echo $txt[32]; ?></title>
</head>
<body class="hold-transition sidebar-mini" onload="myFunction('users')">
<div class="wrapper">
  <?php include_once '../fragments/navbar.php'; ?>
  <?php include_once '../fragments/sidebar.php'; ?>
  <!-- Content Wrapper. Page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $txt[64]; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $txt[10]; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?php if($update) echo $txt[18]; else echo $txt[32]; ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="operatorform" method="post" action="list.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName"><?php echo $txt[30]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user-secret"></i></span>
                      </div>
                      <input name="name" required minlength="4" maxlength="50" type="text" class="form-control" id="inputName" <?php if($update) echo 'value="'.get($operator,'name').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[30]); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputLogin"><?php echo $txt[62]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-ticket"></i></span>
                      </div>
                      <input name="login" required minlength="4" maxlength="30" type="text" class="form-control" id="inputLogin" <?php if($update) echo 'value="'.get($operator,'login').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[62]); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword"><?php echo $txt[63]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                      </div>
                      <input name="password" minlength="4" maxlength="30" type="password" class="form-control" id="inputLogin" <?php if(!$update) echo 'required'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[63]); ?>">
                    </div>
                  </div>
                  <div class="form-check"<?php if($update) if(get($operator,'id')==$_SESSION['operator']) echo ' hidden'; ?>>
                    <input type="checkbox" name="is_admin" class="form-check-input" id="checkboxIsAdmin"
                    <?php 
                    if($update){
                    	if(get($operator,'is_admin')=='t') echo ' checked';
                    	if(get($operator,'id')==$_SESSION['operator']) echo ' hidden';
                    }
                    ?>
                    >
                    <label class="form-check-label" for="checkboxIsAdmin"><?php echo $txt[65]; ?></label>
                    <div class="float-right">
                    	<input type="checkbox" name="is_active" class="form-check-input" id="checkboxIsActive"
                    	<?php 
                    	if($update){
                    		if(get($operator,'is_active')=='t') echo ' checked';
                    	} else echo ' checked';
                    	?>
                    	>
                    	<label class="form-check-label" for="checkboxIsActive"><?php echo $txt[66]; ?></label>
                    </div>
                  </div>
                  <div class="form-check">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="operation" id="inputOperation" value="<?php 
                  	if($update) echo 'updateoperator"><input type="hidden" name="id" id="inputOperatorId" value="'.get($operator,'id');
                  	else echo 'saveoperator';
                  ?>">
                  <a class="btn btn-dark" href="list.php"><?php echo $txt[36]; ?></a>
                  <input type="submit" class="btn btn-success float-right" value="<?php echo $txt[35]; ?>">
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include_once '../fragments/footer.php'; ?> 
</div>
<!-- ./wrapper -->
<?php include_once '../fragments/scripts.php'; ?>
</body>
</html>