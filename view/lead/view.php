  <!DOCTYPE html>
  <html>
  <head>
    <?php
    require_once '../fragments/headstyle.php';
    require_once '../../controller/lead.php';
    if(!empty($_POST["name"])){
      if(isset($_GET["id"])) $lead = update($_GET["id"],$_POST);
      else $lead = save($_POST);
      header("Location:view.php?id=".get($lead,'id'));
      die();
    }
    if(isset($_GET["id"])){
      if(isset($_POST["operation"])){
        switch ($_POST["operation"]){
          case 'savenote':
            addnote($_GET['id'],$_POST['notetext']);
            break;
          case 'deletenote':
            deletenote($_POST['noteid']);
            break;
          case 'savedeal':
            adddeal($_GET['id'],$_POST['productid']);
            break;
          case 'deletedeal':
            deletedeal($_POST['dealid']);
            break;
          case 'addinterest':
            addinterest($_GET['id'],$_POST);
            break;
          case 'deleteinterested':
            deleteinterested($_GET['id'],$_POST);
            break;
        }
        header("Location:view.php?id=".$_GET['id']);
        die();
      }
      $lead = find($_GET['id']);
    }
    if ($lead==false) {
      header("Location:list.php");
      die();
    }
    $notes = findnotesbylead(get($lead,'id'));
    $deals = finddealsbylead(get($lead,'id'));
    $allproducts = searchattr(null,'product');
    $interests = searchattr(null,'interest');
    $leadinterests = findinterestsbylead(get($lead,'id'));
    ?>
    <title><?php echo $txt[12]; ?> | <?php echo $txt[27]; ?></title>
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
              <div class="col-md-4">
                <div class="card card-success card-outline">
                  <div class="card-body box-profile">
                    <h3 class="profile-username text-center"><?php echo get($lead,"name"); ?></h3>
                    <p class="text-muted text-center">
                      <?php 
                      $about_dependents = about_dependents($lead);
                      if ($about_dependents['situation']=='dependent') echo $txt[13].' <a href="view.php?id='.$about_dependents['parent_id'].'">'.$about_dependents['parent_name'].'</a>';
                      if ($about_dependents['situation']=='parent'){
                        echo $txt[72].':<br>';
                      foreach ($about_dependents['dependents'] as $dependent)
                         echo '<a href="view.php?id='.$dependent['dependent_id'].'">'.$dependent['dependent_name'].'</a><br>';
                      }
                      ?></p>
                    <ul class="list-group list-group-unbordered mb-3">

                      <?php
                      if(get($lead,"mail")!=false) echo '
                      <li class="list-group-item">
                      <strong>'.$txt[15].'</strong> <a class="float-right">'.get($lead,"mail").'</a>
                      </li>
                      ';
                      if(get($lead,"phone")!=false) echo '
                      <li class="list-group-item">
                      <strong>'.$txt[16].'</strong> <a class="float-right">'.get($lead,"phone").'</a>
                      </li>
                      ';
                      if(getdep($lead,"status","name")!=false) echo '
                      <li class="list-group-item">
                      <strong>'.$txt[17].'</strong> <a class="float-right">'.getdep($lead,"status","name").'</a>
                      </li>
                      ';
                      ?>
                    </ul>
                    <?php
                      if($_SESSION['is_admin']=='t') echo '
                      <form class="form-group" action="list.php" method="post" id="deactivatelead">
                      <input type="hidden" name="leadid" value="'.get($lead,'id').'">
                      <input type="hidden" name="operation" value="deactivatelead">';
                      if($about_dependents['situation']!='dependent') echo '<a href="form.php?parent='.get($lead,'id').'" class="btn btn-default btn-block">'.$txt[32].' '.strtolower($txt[73]).'</a>';
                      echo '<a href="form.php?id='.get($lead,'id').'" class="btn btn-secondary btn-block">'.$txt[18].'</a>';
                      if($_SESSION['is_admin']=='t') echo '<input type="submit" class="btn btn-dark btn-block"value="'.$txt[57].'">
                    </form>';
                    ?>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- About Me Box -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $txt[25]; ?></h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?php
                    if(get($lead,"address")!=false) echo '
                    <strong>'.$txt[19].'</strong>
                    <p class="text-muted">'.get($lead,"address").'</p>
                    <hr>
                    ';
                    if(get($lead,"birth")!=false) echo '
                    <strong>'.$txt[20].'</strong>
                    <p class="text-muted">'.date('d/m/Y',strtotime(get($lead,"birth"))).'</p>
                    <hr>
                    ';
                    ?>
                    <strong><?php echo $txt[21]; ?></strong>
                    <p class="text-muted"><?php echo date('d/m/Y',strtotime(get($lead,"creation")) - timezone_difference());?></p>
                    <hr>
                    <strong><?php echo $txt[22]; ?></strong>
                    <p class="text-muted"><?php echo getdep($lead,"source","name"); ?></p>
                    <hr>
                    <strong><?php echo $txt[23]; ?></strong>
                    <p class="text-muted"><?php echo getdep($lead,"owner","name"); ?></p>
                    <?php
                    if(get($lead,"observation")!=false) echo '
                    <hr>
                    <strong>'.$txt[24].'</strong>
                    <p class="text-muted">'.get($lead,"observation").'</p>
                    ';
                    ?>
                  <!--<hr>
                    <a href="#" class="btn btn-dark btn-block"><b>Deactivate</b></a>-->
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
                      <!-- <li class="nav-item"><a class="nav-link" href="#dependents" data-toggle="tab">Dependents</a></li> -->
                      <li class="nav-item"><a class="nav-link active" href="#notes" data-toggle="tab"><?php echo $txt[26]; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="#deals" data-toggle="tab"><?php echo $txt[40]; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="#interests" data-toggle="tab"><?php echo $txt[7]; ?></a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="notes">
                        <div class="form-group">
                          <textarea required form="noteform" name="notetext" class="form-control" rows="2" id="inputObservation" placeholder="<?php echo $txt[41].' '.strtolower($txt[42]); ?>"></textarea>
                        </div>
                        <form role="form" method="post" id="noteform" action="view.php?id=<?php echo get($lead,'id') ?>">
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
                                  <form role="form" method="post" id="deletenote" action="view.php?id='.get($lead,'id').'">
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
                        <?php if (getinfo(get($lead, 'creation'), 'date') != $activedate) echo '
                        <li class="time-label">
                          <span class="bg-secondary">'.getinfo(get($lead, 'creation'), 'date').'</span>
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
                        if(!empty($allproducts)){
                            echo '
                            <form id="addproduct" method="post" role="form" action="view.php?id='.get($lead,'id').'">
                            <div class="row form-group">
                              <div class="col-12">
                                <div class="input-group">
                                  <select id="selectproduct" name="productid" class="form-control">
                                  ';
                                  foreach ($allproducts as $product) {
                                    echo '<option value="'.getproduct($product,'id').'" >'.getproduct($product,'name').'</option>';
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
                                  <h3 class="timeline-header">'.$deal['owner'].' '.$txt[45].' "<a href="../product/view.php?id='.$deal['product_id'].'">'.$deal['product'].'</a>" '.
                                  $txt[46].' ';

                                  if ($deal['lead_id']!=get($lead,'id')) echo '<a href="view.php?id='.$deal['lead_id'].'">'.$deal['lead_name'].'</a>';
                                  else echo $deal['lead_name'];
                                  echo '.</h3>';
                                if($_SESSION['is_admin']=='t') echo '
                                <div class="timeline-footer">
                                <form method="post" action="view.php?id='.get($lead,'id').'">
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
                          if (getinfo(get($lead, 'creation'), 'date') != $activedate) echo '
                          <li class="time-label">
                          <span class="bg-secondary">'.getinfo(get($lead, 'creation'), 'date').'</span>
                          </li>
                        ';
                          if (empty($deals)){
                            echo '
                              <li>
                                <div class="timeline-item">
                                  <div class="timeline-body">'.$txt[44].' '.strtolower($txt[12]).'.</div>
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
                    <div class="tab-pane" id="interests">
                      <?php
                        if(!empty($interests)){
                            echo '
                            <form id="addinterest" method="post" role="form" action="view.php?id='.get($lead,'id').'">
                            <div class="row form-group">
                              <div class="col-12">
                                <div class="input-group">
                                  <select id="selectinterest" name="interestid" class="form-control" onchange="checkinterestselect()">
                                  ';
                                  foreach ($interests as $interest) {
                                    echo '<option value="'.getinterest($interest,'id').'" >'.getinterest($interest,'name').'</option>';
                                  }
                                  echo '
                                  <option value="0" >'.$txt[32].' '.strtolower($txt[78]).' '.strtolower($txt[53]).'</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row form-group">
                            <div class="col-6">
                                <input name="interestname" required minlength="4" maxlength="50" type="text" class="form-control" id="inputInterestName" placeholder="'.$txt[34].' '.strtolower($txt[30]).'" style="display:none" disabled>
                            </div>
                              <div class="col-6">
                                <input type="hidden" name="operation" value="addinterest">
                                <input type="submit" class="btn btn-success float-right" value="'.$txt[51].'">
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
                          if (!empty($leadinterests)){
                            foreach ($leadinterests as $leadinterest) {
                              if ($activedate != getinfo($leadinterest['creation'],'date')){
                                $activedate = getinfo($leadinterest['creation'],'date');
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
                                  <span class="time"><i class="fa fa-clock-o"></i> '.getinfo($leadinterest['creation'],'time').'</span>
                                  <h3 class="timeline-header">
                                  '.get($lead,'name').' '.$txt[49].' '.$txt[74].' "<a href="../interest/view.php?id='.$leadinterest['id'].'">'.$leadinterest['name'].'</a>".
                                  </h3>
                                <div class="timeline-footer">
                                <form method="post" action="view.php?id='.get($lead,'id').'">
                                <input type="hidden" name="operation" value="deleteinterested">
                                <input type="hidden" name="interestid" value="'.$leadinterest['id'].'">
                                  <input type="submit" class="btn btn-dark btn-sm" value="'.$txt[52].'">
                                  </form>
                                </div>
                                </div>
                                </li>
                              ';
                            }
                          }
                          if (getinfo(get($lead, 'creation'), 'date') != $activedate) echo '
                            <li class="time-label">
                            <span class="bg-secondary">'.getinfo(get($lead, 'creation'), 'date').'</span>
                            </li>
                            ';
                          if (empty($leadinterests)){
                            echo '
                              <li>
                                <div class="timeline-item">
                                  <div class="timeline-body">'.$txt[50].'.</div>
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
function checkinterestselect(){
	var value = document.getElementById("selectinterest").value;
	if (value == '0'){
		document.getElementById("inputInterestName").removeAttribute("disabled");
		document.getElementById("inputInterestName").style.display = "block";
	} else{
		document.getElementById("inputInterestName").setAttribute("disabled","true");
		document.getElementById("inputInterestName").style.display = "none";
	}
}
</script>
</body>
</html>