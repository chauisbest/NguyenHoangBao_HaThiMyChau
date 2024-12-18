<?php
include 'connect.php';
include 'include/check_login.php';

if ($_SESSION['Role'] < 3) {
  header('location: role_error.php');
  exit;
}
?>
<!-- Left side column. contains the logo and sidebar -->
<?php
include 'include/header.php';
include 'include/aside.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      LỊCH SỬ HOẠT ĐỘNG
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li><a href="#">Lịch sử hoạt động</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Lịch sử hoạt động</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form method="POST" action="user_history_delete.php">
              <table id="exampler" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Stt</th>
                    <th>User name</th>
                    <th>Hoạt động</th>
                    <th>Thời gian</th>
                    <th>
                      <input type="checkbox" class="check" id="checkAll"> Check All |
                      <input type="submit" name="del" value="Xóa" class="btn btn-danger">
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $stt = 1;
                  try {
                    // Using PDO to fetch data
                    $stmt = $pdo->prepare("SELECT * FROM history");
                    $stmt->execute();

                    // Loop through the results and display them
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      ?>
                      <tr>
                        <td><?php echo $stt++; ?> |</td>
                        <td><?php echo htmlspecialchars($row['Username']); ?></td>
                        <td><?php echo htmlspecialchars($row['Action']); ?></td>
                        <td>
                          <?php
                          // Format the time (handling timezone offset)
                          $date = gmdate("d/m/Y H:i A", $row['Timee'] + 7 * 3600);
                          echo $date;
                          ?>
                        </td>
                        <td>
                          <input type="checkbox" class="check" name="chkid[]" value="<?php echo $row['History_Id']; ?>" />
                        </td>
                      </tr>
                      <?php
                    }
                  } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                  ?>
                </tbody>
              </table>
            </form>

            <div class="row">
              <div class="col-sm-5">
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div>
              </div>
              <div class="col-sm-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                  <ul class="pagination">
                    <li class="paginate_button previous disabled" id="example2_previous">
                      <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a>
                    </li>
                    <li class="paginate_button active">
                      <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a>
                    </li>
                    <li class="paginate_button next disabled" id="example2_next">
                      <a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">Next</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include 'include/footer.php';
?>

<script type="text/javascript">
  // Select/Deselect all checkboxes
  $("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
  });
</script>
