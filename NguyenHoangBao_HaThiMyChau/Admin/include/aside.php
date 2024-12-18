  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/Admin/image_product/ava-admin.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php if(isset($_SESSION['Username'])) echo $_SESSION['Username']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          <a href="logout.php" class="btn btn-danger btn-flat"><span>Sign out<span></a>
       <!--    <div class="pull-right info">
                 
     </div> -->
   </div>
 </div>
 <!-- search form -->
 <form action="index.php" method="get" class="sidebar-form">

</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li class="treeview">
    <a href="cat_product.php">
      <i class="ion ion-ios-gear-outline"></i>
      <span>Sản phẩm</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">2</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="list_product.php"><i class="fa fa-circle-o"></i>Danh sách sản phẩm</a></li>
      <li><a href="product_new.php"><i class="fa fa-circle-o"></i>Thêm sản phẩm</a></li>

    </ul>
  </li>
  <li class="treeview">
    <a href="list_order.php">
      <i class="ion ion-ios-cart-outline"></i>
      <span>Đơn hàng</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">1</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="list_order.php"><i class="fa fa-circle-o"></i>Danh sách đơn hàng</a></li>
    </ul>

  </li>
  <li>
   <li class="treeview">
    <a href="cat_product.php">
      <i class="fa fa-fw fa-user"></i>
      <span>Admin</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">3</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="list_user.php"><i class="fa fa-circle-o"></i>Quản lý Admin</a></li>
      <li><a href="user_history.php"><i class="fa fa-circle-o"></i>Lịch sử hoạt động</a></li>

    </ul>
  </li>
  <li>
   <li class="treeview">
    <a href="cat_product.php">
      <i class="class="fa fa-fw fa-users"></i>
      <span>Khách hàng</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">2</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="list_customer.php"><i class="fa fa-circle-o"></i>Quản lý khách hàng</a></li>
    </ul>
  </li>      

</ul>
</section>
<!-- /.sidebar -->
</aside>