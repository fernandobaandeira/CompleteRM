<!DOCTYPE html>
<html>
<head>
  <?php
  require_once '../fragments/headstyle.php';
	require_once '../../controller/lead.php';
  if(isset($_POST['operation']))
    if($_POST['operation'] == 'deactivatelead'){
      deactivatelead($_POST['leadid']);
      header("Location:list.php");
      die();
    }
	$leads = search($_GET);
  $statuses = searchattr(null,'status');
  $sources = searchattr(null,'source');
  ?>
  <title><?php echo $txt[12]; ?> | <?php echo $txt[28]; ?></title>
</head>
<body class="hold-transition sidebar-mini" onload="myFunction('leads')">
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
            <h1><?php echo $txt[12]; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
              <?php echo '<li class="breadcrumb-item active">'.$txt[4].'</li>'; ?>
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
                    $title = $txt[4];
                		if(isset($_GET['search'])) if(!empty($_GET['search'])) $title = $txt[29].'"'.$_GET['search'].'"';
                    echo $title;
                	?>	
                </h3>
                <form class="card-tools" action="list.php" method="GET" id="leadsearchform">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" minlength="2" maxlength="25" class="form-control float-right" placeholder="<?php echo $txt[2]; ?>" onclick="openfilter()">
                    <?php if(isset($_GET['lead'])) echo '<input type="hidden" name="lead" value="'.$_GET['lead'].'">'; ?>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>

                <div id="filterline" style="display: none">
                  <p>
                  <div class="row form-group">
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="status" form="leadsearchform" id="searchstatusselect">
                          <?php
                            echo '<option value="">'.$txt[88].' '.strtolower($txt[69]).'</option>';
                            if($statuses != false)foreach($statuses as $status){
                              echo '<option';
                              if(isset($_GET['status'])) if($_GET['status'] == $status->get('id')) echo ' selected';
                              echo ' value="'.$status->get('id').'">'.$status->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="source" form="leadsearchform" id="searchsourceselect">
                          <?php
                            echo '<option value="">'.$txt[88].' '.strtolower($txt[70]).'</option>';
                            if($sources != false)foreach($sources as $source){
                              echo '<option';
                              if(isset($_GET['source'])) if($_GET['source'] == $source->get('id')) echo ' selected';
                              echo ' value="'.$source->get('id').'">'.$source->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  </p>
                  <p>
                  <div class="row form-group">
                    <div class="col-12">
                      <div class="input-group">
                        <select class="form-control" name="situation" form="leadsearchform" id="searchsituationselect">
                          <?php
                            echo '<option value="0">'.$txt[75].' '.strtolower($txt[4]).'</option>';
                            echo '<option value="2"';
                            if(isset($_GET['situation'])) if($_GET['situation'] == 2) echo ' selected';
                            echo '>'.$txt[76].' '.strtolower($txt[6]).'</option>';
                            echo '<option value="1"';
                            if(isset($_GET['situation'])) if($_GET['situation'] == 1) echo ' selected';
                            echo '>'.$txt[77].' '.strtolower($txt[6]).'</option>';
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  </p>
                </div>

              </div>
              <!-- /.card-header -->
              <?php
              	if(!empty($leads)){
              	  echo '
              	  <div class="card-body table-responsive p-0">
                	<table class="table table-hover">
                  	  <tbody>
                  	    <tr>
                    	  <th>'.$txt[30].'</th>
                    	  <th>'.$txt[15].'</th>
                    	  <th class="text-center">'.$txt[16].'</th>
                    	  <th class="text-center">'.$txt[17].'</th>
                  		</tr>
              	  ';
              	  foreach ($leads as $lead) {
              	  	echo '
              	  	    <tr onclick=viewpage('.get($lead,'id').')>
                    	  <td>'.get($lead,'name').'</td>
                    	  <td>'.get($lead,'mail').'</td>
                    	  <td class="text-center">'.get($lead, 'phone').'</td>
                    	  <td class="text-center">'.getdep($lead,'status','name').'</td>
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
<script> 
function viewpage(id){window.location.href="view.php?id=".concat(id)}
function openfilter(){
  document.getElementById("filterline").style.display = "block";

}
</script>
</body>
</html>