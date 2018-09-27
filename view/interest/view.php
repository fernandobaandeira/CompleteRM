  <!DOCTYPE html>
  <html>
  <head>
    <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/interest.php';
    if(!empty($_POST["name"])){
      if(isset($_GET["id"])) $interest = update($_GET["id"],$_POST);
      else {
        $interest = save($_POST);
        header("Location:view.php?id=".get($interest,'id'));
        die();
      }
    }
    if(isset($_GET["id"])) $interest = find($_GET['id']);
    if ($interest==false) {
      header("Location:list.php");
      die();
    }
    $interested=getinterested($interest);
    ?>
    <title><?php echo $txt[53]; ?> | <?php echo $txt[27]; ?></title>
  </head>
  <body class="hold-transition sidebar-mini" onload="myFunction('interests')">
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
                <h1><?php echo $txt[53]; ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="../../view/lead/list.php"><?php echo $txt[1]; ?></a></li>
                  <li class="breadcrumb-item active"><?php echo $txt[7]; ?></li>
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
                    <h3 class="profile-username text-center"><?php echo get($interest,"name"); ?></h3>
                    <p class="text-muted text-center"><?php echo getinterestedcount($interest).' '.strtolower($txt[55]); ?></p>
                    <ul class="list-group list-group-unbordered mb-3">

                      <?php
                      if(get($interest,"description")!=false) echo '
                      <li class="list-group-item">'.get($interest,"description").'
                      </li>
                      ';
                      ?>
                    </ul>
                    <form class="form-group" action="list.php" method="post" id="deleteinterest">
                      <input type="hidden" name="interestid" value="<?php echo get($interest,'id')?>">
                      <input type="hidden" name="operation" value="deleteinterest">
                      <a href="form.php?id=<?php echo get($interest,'id')?>" class="btn btn-secondary btn-block"><?php echo $txt[18]; ?></a>
                      <input type="submit" class="btn btn-dark btn-block"value="<?php echo $txt[48]; ?>">
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-8">
                <div class="card">
                  <div class="card-header">
                    <span class="card-title"><?php echo $txt[55]; ?></span>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                       <!-- The timeline -->
                       <ul class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <?php
                          $activedate = 0;
                          if (!empty($interested)){
                            foreach ($interested as $lead) {
                              if ($activedate != getinfo($lead['creation'],'date')){
                                $activedate = getinfo($lead['creation'],'date');
                                echo '
                                <li class="time-label">
                                  <span class="bg-secondary">'.$activedate.'</span>
                                </li>
                                ';
                              }
                              echo '
                              <li>
                                <i class="fa fa-tag bg-dark"></i>
                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> '.getinfo($lead['creation'],'time').'</span>
                                  <h3 class="timeline-header"><a href="../lead/view.php?id='.$lead['id'].'">'.$lead['name'].'</a> '.$txt[49].'.</h3>
                                </div>
                                </li>
                              ';
                            }
                          }
                          if (empty($interested)){
                            echo '
                              <li class="time-label">
                                  <span class="bg-secondary">'.date('d M. Y').'</span>
                              </li>
                              <li>
                                <div class="timeline-item">
                                  <div class="timeline-body">'.$txt[56].'.</div>
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