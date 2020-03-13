<?php
ini_set('display errors', 1);
error_reporting('0');
session_start();
if (!isset($_SESSION['name'])) {
  header('Location:login.php');
} elseif (isset($_SESSION['name'])) {
  $cuser = $_SESSION['name'];
}
require 'logis.php';
include('includes/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Emmaus| Dashboard</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
  <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
  <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">s
  <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
  <link rel="stylesheet" href="css/main.css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
  <div class="main-wrapper">
    <?php include('includes/topbar.php'); ?>
    <div class="content-wrapper">
      <div class="content-container">

        <?php include('includes/leftbar.php'); ?>

        <div class="main-page">
          <div class="pagecontente">
            <div class="col-md-8 col-md-offset-2">
              <div>
              
              <form method="post" action="toexcel.php">
              <p>Export All items in store to Excel:</p>
              <input type="submit" name="export" class="btn btn-success" value="Export" />  
              </form>
              </div>
              <br><br>
              <div class="panel">
                <div class="panel-heading">
                  <div class="panel-title">
                    <h3>All Items in Store as at <?php echo date('d-m-Y'); ?></h3>
                  </div>
                </div>  
                <div class="panel-body p-20">
                  <?php
                  echo '<div class="panel-body p-20">';

                  echo '<table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">';
                  echo '<thead>';
                  echo '<tr>';
                  echo '<th>#</th>';
                  echo '<th>ITEM NAME</th>';
                  echo '<th>IN_STORE</th>';
                  echo '<th>SELLING PRICE(per kg)</th>';
                  echo '<th>Date First Stocked</th>';
                  echo '<th>Category</th>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                  

                  $sql = "SELECT * FROM items ORDER BY item_name ASC";
                  $res_data = mysqli_query($conn, $sql);
                  $all_items = mysqli_fetch_all($res_data, MYSQLI_ASSOC);
                  $count = 1;
                  foreach ($all_items as $item) {
                    $item_name = $item['item_name'];
                    $sb = $item['stock_bought'];
                    $sp = $item['selling_price'];
                    echo '<tr>';
                    echo '<td>' . $count . '</td>';
                    echo '<td>' . $item_name . '</td>';
                    echo '<td>' . $sb . '</td>';
                    echo '<td>' . $sp . '</td>';
                    echo '<td>' . $item['date_stocked'] . '</td>';
                    echo '<td>' . $item['category'] . '</td>';
                    echo '<tr>';
                    $count++;
                  }
                  echo '</tbody>';
                  echo '</table>';
                  mysqli_close($conn);
                  ?>
                
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.main-page -->


      </div>
      <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /.main-wrapper -->

  <!-- ========== COMMON JS FILES ========== -->
  <!-- <script src="js/jquery/jquery-2.2.4.min.js"></script> -->
  <!-- <script src="js/jquery-ui/jquery-ui.min.js"></script> -->
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>

  <!-- ========== PAGE JS FILES ========== -->

  <script src="js/counterUp/jquery.counterup.min.js"></script>
  <script src="js/toastr/toastr.min.js"></script>


  <!-- ========== THEME JS ========== -->
  <script src="js/main.js"></script>
  <script>
    $(function() {

      // Counter for dashboard stats
      $('.counter').counterUp({
        delay: 10,
        time: 1000
      });

      // Welcome notification
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr["success"]("All items in stock are displayed here!");

    });
  </script>
  <script>
    $(function($) {
      $('#example').DataTable();

      $('#example2').DataTable({
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false
      });

      $('#example3').DataTable();
    });
  </script>
</body>

</html>