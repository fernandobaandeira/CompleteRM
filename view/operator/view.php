  <!DOCTYPE html>
  <html>
  <head>
    <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/operator.php';
    if ($_SESSION['is_admin']=='f') $is_admin=false;
    else $is_admin=true;
    if(isset($_POST['operation'])){
      switch ($_POST['operation']) {
        case 'status':
          operation('status',$_POST);
          break;
        case 'source':
          operation('source',$_POST);
          break;
        case 'password':
          updatepassword($_POST);
          break;
      }
      header("Location:view.php");
      die();
    }
    $operator=find($_SESSION['operator']);
    $statuses = findwithleadcount('status');
    $sources = findwithleadcount('source');
    ?>
    <title><?php echo $txt[0]; ?> | <?php echo $txt[71]; ?></title>
  </head>
  <body class="hold-transition sidebar-mini" onload="myFunction('configs')">
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
                <h1><?php echo $txt[71]; ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
                  <li class="breadcrumb-item active"><?php echo $txt[11]; ?></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                <div class="card card-success card-outline">
                  <div class="card-body box-profile">
                    <h3 class="profile-username text-center"><?php echo get($operator,"name"); ?></h3>
                    <?php if ($is_admin) echo '<p class="text-muted text-center">'.$txt[65].'</p>';?>
                    <div class="list-group list-group-unbordered mb-3">
                      <span class="list-group-item text-center">
                        <?php echo get($operator,"login");?>
                      </span>
                    </div>
                    <form class="form-group" action="view.php" method="post" id="updatepassword">
                      <input type="hidden" name="operation" value="password">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input name="password" type="password" required minlength="4" maxlength="30" class="form-control" placeholder="<?php echo $txt[34].' '.strtolower($txt[68]).' '.strtolower($txt[63]); ?>">
                      </div>
                      <input type="submit" class="btn btn-success btn-block"value="<?php echo $txt[18].' '.strtolower($txt[63]); ?>">
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- Form-Box -->
                <div class="card" style="display:none" id="configupdate">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $txt[18].' '.strtolower($txt[11]); ?></h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form class="form-group" action="view.php" method="post" id="updateconfig">
                      <input id="updateconfigoperation" type="hidden" name="operation" value="status">
                      <div class="input-group mb-3">
                        <input id="configname" name="name" type="text" required minlength="4" maxlength="30" class="form-control" placeholder="<?php echo $txt[34].' '.strtolower($txt[30]); ?>">
                      </div>
                      <input type="hidden" name="function" value="update">
                      <input id="updateconfigid" type="hidden" name="id" value="0">
                      <input type="submit" class="btn btn-success btn-block"value="<?php echo $txt[18].' '.strtolower($txt[30]); ?>">
                    </form>
                    <form class="form-group" action="view.php" method="post" id="deleteconfig">
                      <input id="deleteconfigoperation" type="hidden" name="operation" value="status">
                      <input type="hidden" name="function" value="delete">
                      <input id="deleteconfigid" type="hidden" name="id" value="0">
                      <input type="submit" class="btn btn-dark btn-block"value="<?php echo $txt[48]; ?>">
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-8">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills mine">
                      <li class="nav-item"><a class="nav-link active" href="#statuses" data-toggle="tab"><?php echo $txt[69]; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="#sources" data-toggle="tab"><?php echo $txt[70]; ?></a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="statuses">
                        <?php
                          if($is_admin) echo '
                          <form role="form" method="post" id="createstatus" action="view.php">
                         <div class="row form-group">
                           <div class="col-12">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-sticky-note"></i></span>
                              </div>
                              <input type="text" name="name" required minlength="4" class="form-control" placeholder="'.$txt[34].' '.strtolower($txt[30]).'">
                            </div>
                            <input type="hidden" name="operation" value="status">
                            <input type="hidden" name="function" value="save">
                            <input type="submit" class="btn btn-success float-right" value="'.$txt[32].' '.strtolower($txt[17]).'">
                           </div>
                         </div>
                       </form>
                          ';
                          if(!empty($statuses)){
                           echo '
                            <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                            <tbody>
                            <tr>
                            <th>'.$txt[30].'</th>
                            <th class="text-center">'.$txt[4].'</th>
                            </tr>';
                            foreach ($statuses as $status){ echo '
                              <tr';
                              if ($is_admin) echo " onclick='callform(1,".$status['id'].",\x22".$status['name']."\x22,".$status['leadquantity'].")'";
                              echo '>
                              <td>'.$status['name'].'</td>
                              <td class="text-center">'.$status['leadquantity'].'</td>
                              </tr>
                              ';
                            }
                            echo '</tbody></table>';
                          }else echo '<div class="text-center card-body">'.$txt[31].'.';
                        ?>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="sources">
                        <?php
                          if($is_admin) echo '
                          <form role="form" method="post" id="createsource" action="view.php">
                         <div class="row form-group">
                           <div class="col-12">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pie-chart"></i></span>
                              </div>
                              <input type="text" name="name" required minlength="4" class="form-control" placeholder="'.$txt[34].' '.strtolower($txt[30]).'">
                            </div>
                            <input type="hidden" name="operation" value="source">
                            <input type="hidden" name="function" value="save">
                            <input type="submit" class="btn btn-success float-right" value="'.$txt[32].' '.strtolower($txt[22]).'">
                           </div>
                         </div>
                       </form>
                          ';
                          if(!empty($sources)){
                           echo '
                            <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                            <tbody>
                            <tr>
                            <th>'.$txt[30].'</th>
                            <th class="text-center">'.$txt[4].'</th>
                            </tr>';
                            foreach ($sources as $source){ echo '
                              <tr';
                              if ($is_admin) echo " onclick='callform(2,".$source['id'].",\x22".$source['name']."\x22,".$source['leadquantity'].")'";
                              echo '>
                              <td>'.$source['name'].'</td>
                              <td class="text-center">'.$source['leadquantity'].'</td>
                              </tr>
                              ';
                            }
                            echo '</tbody></table>';
                          }else echo '<div class="text-center card-body">'.$txt[31].'.';
                        ?>
                      </div>
               <!-- /.tab-content -->
             </div><!-- /.card-body -->
           </div>
           <!-- /.nav-tabs-custom -->
         </div>
         <!-- /.col -->
       </div>
       <!-- /.row -->
     </div><!-- /.container-fluid -->
   </section>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->
 <?php include_once '../fragments/footer.php'; ?> 
</div>
<!-- ./wrapper -->
<?php include_once '../fragments/scripts.php'; ?>
<script> 
  function callform(object,id,name,leadQuantity){
    document.getElementById("configupdate").style.display = "block";
    if(leadQuantity>0) document.getElementById("deleteconfig").style.display = "none";
    else document.getElementById("deleteconfig").style.display = "block";
    if(object==1){//status
      document.getElementById("updateconfigoperation").setAttribute("value","status");
      document.getElementById("deleteconfigoperation").setAttribute("value","status");
    }
    if(object==2){
      document.getElementById("updateconfigoperation").setAttribute("value","source");
      document.getElementById("deleteconfigoperation").setAttribute("value","source");
    }
    document.getElementById("configname").setAttribute("value",name);
    document.getElementById("updateconfigid").setAttribute("value",id);
    document.getElementById("deleteconfigid").setAttribute("value",id);
  }
</script>
</body>
</html>