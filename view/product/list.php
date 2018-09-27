<!DOCTYPE html>
<html>
<head>
  <?php
  require_once '../fragments/headstyle.php';
	require_once '../../controller/product.php';
  if(isset($_POST['operation'])){
    if ($_POST['operation']=='deactivateproduct') deactivateproduct($_POST['productid']);
    header("Location:list.php");
    die();
  }
	$products = search($_GET);
  ?>
  <title><?php echo $txt[58]; ?> | <?php echo $txt[28]; ?></title>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                	<?php
                		$table_title=$txt[8];
                		if(isset($_GET['search'])) $table_title = $txt[29].'"'.$_GET['search'].'"';
                		echo $table_title;
                	?>	
                </h3>
                <form class="card-tools" action="list.php" method="get">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" required minlength="2" maxlength="25" class="form-control float-right" placeholder=<?php echo $txt[2]; ?>>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-header -->
              <?php
              	if(!empty($products)){
              	  echo '
              	  <div class="card-body table-responsive p-0">
                	<table class="table table-hover">
                  	  <tbody>
                  	    <tr>
                    	  <th>'.$txt[30].'</th>
                    	  <th class="text-center">'.$txt[21].'</th>
                    	  <th class="text-center">'.$txt[59].'</th>
                  		</tr>
              	  ';
              	  foreach ($products as $product) {
              	  	echo '
              	  	    <tr onclick=viewpage('.get($product,'id').')>
                    	  <td>'.get($product,'name').'</td>
                    	  <td class="text-center">'.date('d/m/Y',strtotime(get($product,'creation'))- timezone_difference()).'</td>
                    	  <td class="text-center">'.getsoldquantity($product).'</td>
                  	  	</tr>
              	  	';
              	  }
              	  echo '</tbody></table>';
              	}
              	else echo '<div class="text-center card-body">'.$txt[31].'.';
              ?>
              </div>
              <div class="card-footer">
              	<a href="form.php"><button type="button" class="btn btn-success float-right"><?php echo $txt[32]; ?></button></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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
<script> function viewpage(id){window.location.href="view.php?id=".concat(id)}</script>
</body>
</html>