<!DOCTYPE html>
<html>
<head>
  <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/product.php';
    $update = false;
    if(isset($_GET["id"])){
    	$product = find($_GET['id']);
    	if ($product != false) $update=true;
    }
  ?>
  <title><?php echo $txt[58]; ?> | <?php if($update) echo $txt[18]; else echo $txt[32]; ?></title>
</head>
<body class="hold-transition sidebar-mini" onload="myFunction('products')">
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
            <h1><?php echo $txt[58]; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $txt[8]; ?></li>
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
              <form role="form" id="productform" method="post" action="view.php<?php if($update) echo '?id='.get($product,'id'); ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName"><?php echo $txt[30]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                      </div>
                      <input name="name" required minlength="4" maxlength="50" type="text" class="form-control" id="inputName" <?php if($update) echo 'value="'.get($product,'name').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[30]); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputDescription"><?php echo $txt[54]; ?></label>
                    <textarea name="description" minlength="4" maxlength="300" class="form-control" rows="3" id="inputDescription" placeholder="<?php echo $txt[34].' '.strtolower($txt[54]); ?>"><?php if($update) echo get($product,'description'); ?></textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a class="btn btn-dark" href="<?php if($update) echo 'view.php?id='.get($product,'id'); else echo 'list.php' ?>"><?php echo $txt[36]; ?></a>
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