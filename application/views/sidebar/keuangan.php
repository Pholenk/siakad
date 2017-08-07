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
      <li class="header">Pembayaran</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Uang Kuliah</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="treview"><a href="/bayar/uangkuliah"><i class="fa fa-dot-circle-o"></i> Show Pembayaran</a></li>
          <li class="treview"><a href="" data-toggle='modal' data-target='#modal' id="bayar_add_uangkuliah"><i class="fa fa-dot-circle-o"></i> Add Pembayaran</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>SPI</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="treview"><a href="/bayar/SPI"><i class="fa fa-dot-circle-o"></i> Show Pembayaran</a></li>
          <li class="treview"><a href="" data-toggle='modal' data-target='#modal' id="bayar_add_SPI"><i class="fa fa-dot-circle-o"></i> Add Pembayaran</a></li>
        </ul>
      </li>
      <li class="header">Cetak</li>
    </ul>
    <!-- /.sidebar menu -->
  </section>
  <!-- /.sidebar -->
</aside>