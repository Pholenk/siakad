<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="padding-top:20px;padding-bottom:20px;">
      <div class="pull-left image">
        <img src="/vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        <?php //echo '/assets/image/'.$this->session->id.'jpg'?>
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
      <li class="header">SETTINGS</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-gears"></i>
          <span>Setting</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li><a href="/pengguna"><i class="fa fa-dot-circle-o"></i> Pengguna</a></li>
          <li><a href="/mahasiswa"><i class="fa fa-dot-circle-o"></i> Mahasiswa</a></li>
          <li><a href="/orangtua"><i class="fa fa-dot-circle-o"></i> Orang Tua Mahasiswa</a></li>
          <li><a href="/jurusan"><i class="fa fa-dot-circle-o"></i> Jurusan</a></li>
          <li><a href="/dosen"><i class="fa fa-dot-circle-o"></i> Dosen</a></li>
          <li><a href="/matakuliah"><i class="fa fa-dot-circle-o"></i> Mata Kuliah</a></li>
          <li><a href="/ajar"><i class="fa fa-dot-circle-o"></i> Mengajar</a></li>
          <li><a href="/uangkuliah"><i class="fa fa-dot-circle-o"></i> Uang Kuliah</a></li>
        </ul>
      </li>
      <li class="header">Cetak</li>
    </ul>
    <!-- /.sidebar menu -->
  </section>
  <!-- /.sidebar -->
</aside>