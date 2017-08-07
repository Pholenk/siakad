<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="padding-top:20px;padding-bottom:20px;">
      <div class="pull-left image">
        <img src="/assets/image/logo-pnc.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p style='padding-bottom:2px;'>
          <?php echo $this->session->name ?>
        </p>
        <i class="fa fa-circle text-success"></i>
        <?php echo $this->session->job ?>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">Main Sidebar</li>
      <li class="treeview">
        <a href="/"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
      </li>
      <li class="header">Kartu Hasil Studi</li>
      <li class="treeview">
        <a href="/KHS">
          <i class="fa fa-money"></i>
          <span>Lihat Kartu Hasil Studi</span>
        </a>
      </li>
    </ul>
    <!-- /.sidebar menu -->
  </section>
  <!-- /.sidebar -->
</aside>