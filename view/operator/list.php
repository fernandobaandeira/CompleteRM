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
  if(isset($_POST['operation'])){
    if ($_POST['operation'] == 'updateoperator') update($_POST);
    if ($_POST['operation'] == 'saveoperator') save($_POST);
    header("Location:list.php");
    die();
  }
	$operators = search($_GET);
  ?>
  <title><?php echo $txt[64]; ?> | <?php echo $txt[28]; ?></title>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                	<?php
                		$table_title=$txt[10];
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
              	if(!empty($operators)){
              	  echo '
              	  <div class="card-body table-responsive p-0">
                	<table class="table table-hover">
                  	  <tbody>
                  	    <tr>
                    	  <th>'.$txt[30].'</th>
                    	  <th class="text-center">'.$txt[62].'</th>
                    	  <th class="text-center">'.$txt[17].'</th>
                  		</tr>
              	  ';
              	  foreach ($operators as $operator) {
              	  	echo '
              	  	    <tr onclick=viewpage('.get($operator,'id').')>
                    	  <td>'.get($operator,'name');
                        if(get($operator,'is_admin')=='t') echo ' ('.$txt[65].')';
                        echo '</td>
                    	  <td class="text-center">'.get($operator,'login').'</td>
                        <td class="text-center">';
                        if(get($operator,'is_active')=='t') echo $txt[66];
                        else echo $txt[67];
                        echo '</td>
                  	  	</tr>
              	  	';
              	  }
              	  echo '</tbody></table>';
              	}
              	else echo '<div class="text-center card-body">'.$txt[31].'.</span>';
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
<script> function viewpage(id){window.location.href="form.php?id=".concat(id)}</script>
</body>
</html>