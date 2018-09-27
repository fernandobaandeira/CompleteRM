<!DOCTYPE html>
<html>
<head>
  <?php
  require_once '../fragments/headstyle.php';
  require_once '../../controller/product.php';
  if(!empty($_POST["name"])){
    if(isset($_GET["id"])) $product = update($_GET["id"],$_POST);
    else $product = save($_POST);
    header("Location:view.php?id=".get($product,'id'));
    die();
  }
  if(isset($_GET["id"])){
    if(isset($_POST["operation"])){
      switch ($_POST["operation"]) {
        case 'savenote':
        addnote($_GET['id'],$_POST['notetext']);
        break;
        case 'deletenote':
        deletenote($_POST['noteid']);
        break;
        case 'savedeal':
        adddeal($_POST['leadid'], $_GET['id']);
        break;
        case 'deletedeal':
        deletedeal($_POST['dealid']);
        break;
      }
      header("Location:view.php?id=".$_GET['id']);
      die();  
    }
    $product = find($_GET['id']);
  }
  if ($product==false) {
    header("Location:list.php");
    die();
  }
  $notes = findnotesbyproduct(get($product,'id'));
  $deals = finddealsbyproduct(get($product,'id'));
  $allleads = searchattr(null,'lead');
  ?>
    <title><?php echo $txt[58]; ?> | <?php echo $txt[27]; ?></title>
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
              <div class="col-md-4">
                <div class="card card-success card-outline">
                  <div class="card-body box-profile">
                    <h3 class="profile-username text-center"><?php echo get($product,"name"); ?></h3>
                    <p class="text-muted text-center"><?php echo getsoldquantity($product).' '.strtolower($txt[59]); ?></p>
                    <ul class="list-group list-group-unbordered mb-3">

                      <?php
                      if(get($product,"description")!=false) echo '
                      <li class="list-group-item">'.get($product,"description").'
                      </li>
                      ';
                      ?>
                    </ul>
                    <form class="form-group" action="list.php" method="post" id="deactivateproduct">
                      <input type="hidden" name="productid" value="<?php echo get($product,'id')?>">
                      <input type="hidden" name="operation" value="deactivateproduct">
                      <a href="form.php?id=<?php echo get($product,'id')?>" class="btn btn-secondary btn-block"><?php echo $txt[18]; ?></a>
                      <input type="submit" class="btn btn-dark btn-block"value="<?php echo $txt[57]; ?>">
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-8">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills mine">
                      <li class="nav-item"><a class="nav-link active" href="#notes" data-toggle="tab"><?php echo $txt[26]; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="#deals" data-toggle="tab"><?php echo $txt[40]; ?></a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="notes">
                        <div class="form-group">
                          <textarea required form="noteform" name="notetext" class="form-control" rows="2" id="inputObservation" placeholder="<?php echo $txt[41].' '.strtolower($txt[42]); ?>"></textarea>
                        </div>
                        <form role="form" method="post" id="noteform" action="view.php?id=<?php echo get($product,'id') ?>">
                         <div class="row form-group">
                           <div class="col-12">
                            <input type="hidden" name="operation" value="savenote">
                            <input type="submit" class="btn btn-success float-right" value="<?php echo $txt[38]; ?>">
                          </div>
                        </div>
                      </form>
                      <!-- The timeline -->
                      <ul class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <?php
                        $activedate = 0;
                        if (!empty($notes)){
                          foreach ($notes as $note) {
                            if ($activedate != getinfo($note['creation'],'date')){
                              $activedate = getinfo($note['creation'],'date');
                              echo '
                              <li class="time-label">
                              <span class="bg-secondary">'.$activedate.'</span>
                              </li>
                              ';
                            }
                            echo '
                            <li>
                            <i class="fa fa-sticky-note bg-dark"></i>
                            <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> '.getinfo($note['creation'],'time').'</span>
                            <h3 class="timeline-header">'.$note['owner'].' '.$txt[39].'</h3>
                            <div class="timeline-body">'.$note['description'].'</div>';
                            if($_SESSION['is_admin']=='t') echo '
                            <div class="timeline-footer">
                            <form role="form" method="post" id="deletenote" action="view.php?id='.get($product,'id').'">
                            <input type="hidden" name="operation" value="deletenote">
                            <input type="hidden" name="noteid" value="'.$note['id'].'">
                            <input type="submit" class="btn btn-dark btn-sm" value="'.$txt[48].'">
                            </form>
                            </div>';
                            echo '</div>
                            </li>
                            ';
                          }
                        }
                        ?>
                        <!-- timeline time label -->
                        <?php if (getinfo(get($product, 'creation'),'date') != $activedate) echo '
                        <li class="time-label">
                        <span class="bg-secondary">'.getinfo(get($product, 'creation'),'date').'</span>
                        </li>
                        ';
                        ?>
                        <!-- /.timeline-label -->
                        <?php
                        if (empty($notes)){
                          echo '
                          <li>
                          <div class="timeline-item">
                          <div class="timeline-body">'.$txt[43].'.</div>
                          </div>
                          </li>
                          ';
                        }
                        ?>
                        <li>
                          <i class="fa fa-user-plus bg-success"></i>
                        </li>
                      </ul>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="deals">
                     <!-- The timeline -->
                     <?php
                     if(!empty($allleads)){
                      echo '
                      <form id="sell" method="post" role="form" action="view.php?id='.get($product,'id').'">
                      <div class="row form-group">
                      <div class="col-12">
                      <div class="input-group">
                      <select id="selectlead" name="leadid" class="form-control">
                      ';
                      foreach ($allleads as $lead) {
                        echo '<option value="'.getlead($lead,'id').'" >'.getlead($lead,'name').'</option>';
                      }
                      echo '
                      </select>
                      </div>
                      </div>
                      </div>
                      <div class="row form-group">
                      <div class="col-12">
                      <input type="hidden" name="operation" value="savedeal">
                      <input type="submit" class="btn btn-success float-right" value="'.$txt[47].'">
                      </div>
                      </div>
                      </form>
                      ';
                    }
                    ?>
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <?php
                      $activedate = 0;
                      if (!empty($deals)){
                        foreach ($deals as $deal) {
                          if ($activedate != getinfo($deal['sale_date'],'date')){
                            $activedate = getinfo($deal['sale_date'],'date');
                            echo '
                            <li class="time-label">
                            <span class="bg-secondary">'.$activedate.'</span>
                            </li>
                            ';
                          }
                          echo '
                          <li>
                          <i class="fa fa-shopping-cart bg-dark"></i>
                          <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> '.getinfo($deal['sale_date'],'time').'</span>
                          <h3 class="timeline-header">'.$deal['owner'].' '.$txt[45].' '.
                          $txt[46].' <a href="../lead/view.php?id='.$deal['lead_id'].'">'.$deal['lead_name'].'</a>.</h3>';
                          if($_SESSION['is_admin']=='t') echo '
                          <div class="timeline-footer">
                          <form method="post" action="view.php?id='.get($product,'id').'">
                          <input type="hidden" name="operation" value="deletedeal">
                          <input type="hidden" name="dealid" value="'.$deal['id'].'">
                          <input type="submit" class="btn btn-dark btn-sm" value="'.$txt[48].'">
                          </form>
                          </div>';
                          echo '</div>
                          </li>
                          ';
                        }
                      }
                      if (getinfo(get($product, 'creation'),'date') != $activedate) echo '
                      <li class="time-label">
                      <span class="bg-secondary">'.getinfo(get($product, 'creation'),'date').'</span>
                      </li>
                      ';
                      if (empty($deals)){
                        echo '
                        <li>
                        <div class="timeline-item">
                        <div class="timeline-body">'.$txt[44].' '.strtolower($txt[58]).'.</div>
                        </div>
                        </li>
                        ';
                      }
                      ?>
                      <li>
                        <i class="fa fa-user-plus bg-success"></i>
                      </li>
                    </ul>
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
</body>
</html>