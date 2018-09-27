<!DOCTYPE html>
<html>
<head>
  <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/lead.php';
    $update = false;
    $dependent = false;
    if(isset($_GET["id"])){
    	$lead = find($_GET['id']);
    	if ($lead != false) $update=true;
    }
    if(isset($_GET["parent"])){
      $parent = find($_GET['parent']);
      if ($parent != false) $dependent=true;
    }
    $clients = search(array('situation'=>1));
    $statuses = searchattr(null,'status');
    $sources = searchattr(null,'source');
  ?>
  <title><?php echo $txt[12]; ?> | <?php if($update) echo $txt[18]; else echo $txt[32]; ?></title>
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
              <li class="breadcrumb-item active"><?php echo $txt[4]; ?></li>
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
              <form role="form" id="leadform" method="post" action="view.php<?php if($update) echo '?id='.get($lead,'id'); ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName"><?php echo $txt[30]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                      </div>
                      <input name="name" required minlength="4" maxlength="75" type="text" class="form-control" id="inputName" <?php if($update) echo 'value="'.get($lead,'name').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[30]); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail"><?php echo $txt[15]; ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                      </div>
                      <input name="mail" type="email" class="form-control" id="inputEmail" <?php if($update) echo 'value="'.get($lead,'mail').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[15]); ?>">
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-6">
                      <label for="inputPhone"><?php echo $txt[16]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        </div>
                        <input name="phone" minlength="8" type="tel" class="form-control" id="inputPhone" <?php if($update) echo 'value="'.get($lead,'phone').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[16]); ?>">
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="inputBirthDate"><?php echo $txt[20]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input name="birth" type="date" class="form-control" id="inputBirthDate" min="1918-01-01" <?php if($update) echo 'value="'.get($lead,'birth').'"'; ?>>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress"><?php echo $txt[19]; ?></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                      </div>
                      <input name="address" minlength="10" maxlength="125" type="text" class="form-control" id="inputAddress" <?php if($update) echo 'value="'.get($lead,'address').'"'; if($dependent) echo 'value="'.get($parent,'address').'"'; ?> placeholder="<?php echo $txt[34].' '.strtolower($txt[19]); ?>">
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-6">
                      <label for="selectSource"><?php echo $txt[22]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-pie-chart"></i></span>
                        </div>
                        <select name="source" id="selectSource" class="form-control" form="leadform">
                          <?php
                          	foreach($sources as $source){
                          		echo '<option';
                          		if($update) if(getdep($lead,'source','id') == $source->get('id')) echo ' selected';
                              if($dependent) if(getdep($parent,'source','id') == $source->get('id')) echo ' selected';
                          		echo ' value="'.$source->get('id').'">'.$source->get('name').'</option>';
                          	}
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="selectStatus"><?php echo $txt[17]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-sticky-note"></i></span>
                        </div>
                        <select name="status" id="selectStatus" class="form-control" form="leadform">
                          <?php
                          	foreach($statuses as $status){
                          		echo '<option';
                          		if($update) if(getdep($lead,'status','id') == $status->get('id')) echo ' selected';
                          		echo ' value="'.$status->get('id').'">'.$status->get('name').'</option>';
                          	}
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="selectParent"><?php echo $txt[33]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-sitemap"></i></span>
                        </div>
                        <select name="parent" id="selectParent" class="form-control" form="leadform" onchange="checkparentselect()">
                          <?php
                          	echo '<option value="">'.$txt[37].'</option>';
                          	foreach($clients as $client){
                          		echo '<option';
                          		if($update) if(!empty(get($lead,'parent'))) if(getdep($lead,'parent','id') == $client->get('id')) echo ' selected';
                              if($dependent) if(get($parent, 'id') == $client->get('id')) echo ' selected';
                              echo ' value="'.$client->get('id').'">'.$client->get('name').'</option>';
                          	}
                            echo '<option value="0" >'.$txt[32].' '.strtolower($txt[78]).' '.strtolower($txt[33]).'</option>';
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" id="parentNameDiv" style="display:none">
                    <label for="inputParentName"><?php echo $txt[78].' '.strtolower($txt[33]); ?></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user-plus"></i></span>
                      </div>
                      <input name="parentname" required minlength="4" maxlength="75" type="text" class="form-control" id="inputParentName" placeholder="<?php echo $txt[34].' '.strtolower($txt[30]); ?>" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputObservation"><?php echo $txt[24]; ?></label>
                    <textarea name="observation" maxlength="300" class="form-control" rows="3" id="inputObservation" placeholder="<?php echo $txt[34].' '.strtolower($txt[24]); ?>"><?php if($update) echo get($lead,'observation'); ?></textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a class="btn btn-dark" href="<?php if($update) echo 'view.php?id='.get($lead,'id'); elseif($dependent) echo 'view.php?id='.get($parent,'id'); else echo 'list.php' ?>"><?php echo $txt[36]; ?></a>
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
<script>
function checkparentselect(){
  var value = document.getElementById("selectParent").value;
  if (value == '0'){
    document.getElementById("inputParentName").removeAttribute("disabled");
    document.getElementById("parentNameDiv").style.display = "block";
  } else{
    document.getElementById("inputParentName").setAttribute("disabled","true");
    document.getElementById("parentNameDiv").style.display = "none";
  }
}
</script>
</body>
</html>