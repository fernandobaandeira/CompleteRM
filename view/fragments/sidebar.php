<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="../lead/list.php" class="brand-link">
      <img src="../img/logo.png"
           alt="CompleteRM Logo"
           class="brand-image img-circle elevation-3"
           style="opacity:1">
      <span class="brand-text font-weight-light"><?php echo $txt[0]; ?></span>
    </a>
    <script>
    function myFunction(navlink) {document.getElementById(navlink+"navlink").classList.add("active");};
    function submitForm(formName) {document.getElementById(formName).submit();};
    </script>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a id="leadsnavlink" href="../lead/list.php" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                <?php echo $txt[4]; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a id="interestsnavlink" href="../interest/list.php" class="nav-link">
              <i class="nav-icon fa fa-tags"></i>
              <p>
                <?php echo $txt[7]; ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a id="productsnavlink" href="../product/list.php" class="nav-link">
              <i class="nav-icon fa fa-barcode"></i>
              <p>
                <?php echo $txt[8]; ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a id="reportsnavlink" href="../report/form.php" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>
                <?php echo $txt[9]; ?>
              </p>
            </a>
          </li>
          <li <?php if($_SESSION['is_admin']=='f') echo 'hidden'; ?> class="nav-item has-treeview">
            <a id="usersnavlink" href="../operator/list.php" class="nav-link">
              <i class="nav-icon fa fa-user-secret"></i>
              <p>
                <?php echo $txt[10]; ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a id="configsnavlink" href="../operator/view.php" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                <?php echo $txt[11]; ?>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>