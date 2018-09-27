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
    $statuses = searchattr(null,'status');
    $sources = searchattr(null,'source');
    $operators = searchattr(null,'operator');    
    $products = searchattr(null,'product');
  ?>
  <title><?php echo $txt[0]; ?> | <?php echo $txt[9]; ?></title>
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
            <h1><?php echo $txt[9]; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $txt[9]; ?></li>
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
                <h3 class="card-title"><?php echo $txt[79]; ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="reportform" method="get" action="list.php">
                <div class="card-body">
                  <div class="row form-group">
                    <div class="col-12">
                      <label for="selectReport"><?php echo $txt[80]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-pie-chart"></i></span>
                        </div>
                        <select name="id" id="selectReport" class="form-control" form="reportform" onchange="reportfilters()">
                          <option value="1"><?php echo $txt[81].' '.strtolower($txt[4]); ?></option>
                          <option value="2"><?php echo $txt[40]; ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-6">
                      <label for="inputPeriodStart"><?php echo $txt[82]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input name="periodstart" type="date" class="form-control" id="inputPeriodStart" min="1918-01-01">
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="inputPeriodEnd"><?php echo $txt[83]; ?></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input name="periodend" type="date" class="form-control" id="inputPeriodEnd" min="1918-01-01">
                      </div>
                    </div>
                  </div>
                  <div id="leadsfilterline">
                  <label><?php echo $txt[85]; ?></label>                    
                  <div class="row form-group">
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="status" form="reportform" id="statusselect">
                          <?php
                            echo '<option value="">'.$txt[88].' '.strtolower($txt[69]).'</option>';
                            if($statuses != false)foreach($statuses as $status){
                              echo '<option value="'.$status->get('id').'">'.$status->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="source" form="reportform" id="sourceselect">
                          <?php
                            echo '<option value="">'.$txt[88].' '.strtolower($txt[70]).'</option>';
                            if($sources != false)foreach($sources as $source){
                              echo '<option value="'.$source->get('id').'">'.$source->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-12">
                      <div class="input-group">
                        <select class="form-control" name="situation" form="reportform" id="situationselect">
                          <?php
                            echo '<option value="0">'.$txt[75].' '.strtolower($txt[4]).'</option>';
                            echo '<option value="2">'.$txt[76].' '.strtolower($txt[6]).'</option>';
                            echo '<option value="1">'.$txt[77].' '.strtolower($txt[6]).'</option>';
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="dealsfilterline" style="display:none">
                  <label><?php echo $txt[85]; ?></label>                    
                  <div class="row form-group">
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="operator" form="reportform" id="operatorselect" disabled>
                          <?php
                            echo '<option value="">'.$txt[87].' '.strtolower($txt[86]).'</option>';
                            if($operators != false)foreach($operators as $operator){
                              echo '<option value="'.$operator->get('id').'">'.$operator->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="input-group">
                        <select class="form-control" name="product" form="reportform" id="productselect" disabled>
                          <?php
                            echo '<option value="">'.$txt[87].' '.strtolower($txt[8]).'</option>';
                            if($products != false)foreach($products as $product){
                              echo '<option value="'.$product->get('id').'">'.$product->get('name').'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" class="btn btn-success float-right" value="<?php echo $txt[79]; ?>">
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
function reportfilters(){
  var value = document.getElementById("selectReport").value;
  if (value == '1'){
    document.getElementById("operatorselect").setAttribute("disabled","true");
    document.getElementById("productselect").setAttribute("disabled","true");
    document.getElementById("dealsfilterline").style.display = "none";
    document.getElementById("statusselect").removeAttribute("disabled");
    document.getElementById("sourceselect").removeAttribute("disabled");
    document.getElementById("situationselect").removeAttribute("disabled");
    document.getElementById("leadsfilterline").style.display = "block";
  }
  if (value == '2'){
    document.getElementById("statusselect").setAttribute("disabled","true");
    document.getElementById("sourceselect").setAttribute("disabled","true");
    document.getElementById("situationselect").setAttribute("disabled","true");
    document.getElementById("leadsfilterline").style.display = "none";
    document.getElementById("operatorselect").removeAttribute("disabled");
    document.getElementById("productselect").removeAttribute("disabled");
    document.getElementById("dealsfilterline").style.display = "block";
  }
}
</script>
</body>
</html>