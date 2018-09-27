<!DOCTYPE html>
<html>
<head>
  <?php
  require_once '../fragments/headstyle.php';
	require_once '../../controller/report.php';
  /*if ($_SESSION['is_admin']=='f'){
    header("Location:../lead/list.php");
    die();
  }*/
  if(!isset($_GET["id"])){
      header('form.php');
      die();
  }
  $report = generate($_GET);
  ?>
  <title><?php echo $txt[0]; ?> | <?php echo $txt[80]; ?></title>
</head>
<body class="hold-transition sidebar-mini" onload="myFunction('reports')">
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
            <h1><?php echo $txt[80]; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
              <?php echo '<li class="breadcrumb-item active">'.$txt[9].'</li>'; ?>
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
                <h3 class="card-title no-print">
                	<?php
                    $title = $txt[80];
                    if($_GET['id']=='1') $title = $txt['91'];
                    if($_GET['id']=='2') $title = $txt['92'];
                		$title = $title.' ('.$txt['93'].' '.getinfo(date_format(date_create(),'Y-m-d H:i'),'date').', '.getinfo(date_format(date_create(),'Y-m-d H:i'),'time').')';
                    echo $title;
                	?>	
                </h3>
                <div class="d-none d-print-block"><br><br>
                  <h2 class="text-center"><?php echo $txt['0']; ?></h2>
                <h2 class="card-title text-center">
                  <?php
                    $title = $txt[80];
                    if($_GET['id']=='1') $title = $txt['91'];
                    if($_GET['id']=='2') $title = $txt['92'];
                    $title = $title.' ('.$txt['93'].' '.getinfo(date_format(date_create(),'Y-m-d H:i'),'date').', '.getinfo(date_format(date_create(),'Y-m-d H:i'),'time').')';
                    echo $title;
                  ?>  
                </h2><br>
                </div>
              </div>
              <!-- /.card-header -->
              <?php
              	if(!empty($_GET['id'])){
                	  echo '
                	  <div class="card-body table-responsive p-0">
                  	<table class="table table-hover">
                    	  <tbody>
                    	    <tr>';
                    if($_GET['id']=='1'){
                      echo '
                      	  <th>'.$txt[21].'</th>
                      	  <th>'.$txt[30].'</th>
                      	  <th>'.$txt[23].'</th>
                          </tr>
                      ';
                      foreach ($report as $lead) {
                        echo '
                            <tr>
                            <td>'.getinfo($lead['creation'],'date').'</td>
                            <td>'.$lead['lead'].'</td>
                            <td>'.$lead['owner'].'</td>
                        ';
                      }
                    }
                    if($_GET['id']=='2'){
                      echo '
                          <th>'.$txt[90].'</th>
                          <th>'.$txt[14].'</th>
                          <th>'.$txt[58].'</th>
                          <th>'.$txt[23].'</th>
                          </tr>
                      ';
                      foreach ($report as $deal) {
                        echo '
                            <tr>
                            <td>'.getinfo($deal['sale_date'],'date').'</td>
                            <td>'.$deal['lead'].'</td>
                            <td>'.$deal['product'].'</td>
                            <td>'.$deal['owner'].'</td>
                        ';
                      }
                    }
                	  echo '</tr></tbody></table>';
              	}
              	else echo '<div class="text-center card-body">'.$txt[31].'.';
              ?>
              </div>
              <div class="card-footer no-print">
              	<button class="btn btn-success float-right" onclick="window.print();"><?php echo $txt[94]; ?></button>
                <a href="form.php" class="btn btn-dark"><?php echo $txt[89]; ?></a>
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
</body>
</html>