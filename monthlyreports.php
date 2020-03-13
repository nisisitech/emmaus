<?php
ob_start();
ini_set('display errors', 1);
error_reporting('0');
session_start();
if (!isset($_SESSION['name'])) {
    header('Location:login.php');
} elseif (isset($_SESSION['name'])) {
    $cuser = $_SESSION['name'];
}
require 'logis.php';

if (isset($_POST["generate_pdf"])) {
    //get data into pdf
    function fetch_data()
    {
        $year = $_POST['year'];
        $month = $_POST['month'];
        $output = '';
        // $output.='<tr><td>Youuuuuuu<td></tr>';
        include 'includes/config.php';
        $sql = "SELECT DISTINCT item_name FROM SALES WHERE MONTH(date_sold)='$month' AND YEAR(date_sold)='$year'";
        $query = mysqli_query($conn, $sql);
        $sales = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach ($sales as $sale) {
            $item = $sale['item_name'];

            $sql1 = "SELECT SUM(total_price) AS totalsum,SUM(quantity_sold) AS totalsold  FROM sales WHERE item_name='$item' AND MONTH(date_sold)='$month' AND YEAR(date_sold)='$year' ";
            $result1 = mysqli_query($conn, $sql1);
            $row = mysqli_fetch_assoc($result1);
            $sumsold = $row['totalsold'];
            $sumprice = $row['totalsum'];
            $output .= '<tr><td>' . $item . '</td>
           <td>' . $sumsold . '</td>
           <td>' . $sumprice . '</td>
           </tr>';
        }
        $resultsum = mysqli_query($conn, "SELECT SUM(total_price) AS totalsum FROM sales WHERE MONTH(date_sold)='$month' AND YEAR(date_sold)='$year'");
        $rowsum = mysqli_fetch_assoc($resultsum);
        $sum = $rowsum['totalsum'];
        $output .= '<tr><td colspan="2" style="text-align:center;">Total Amount: </td>
         <td colspan="1" style="text-decoration:bold;color:blue;">' . $sum . '</td></tr>';
        echo $output;
        return $output;
    }
    require_once('includes/tcpdf/tcpdf.php');
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Generate monthly summary");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 11);
    $obj_pdf->AddPage();
    $content = '';
    $content .= '  
      <h4 align="center">MONTHLY SUMMARY </h4><br /> 
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="40%">Item Name</th>  
                <th width="30%">Amount Sold(Kgs)</th>  
                <th width="30%">Total Price(Kshs)</th>  
           </tr>  
      ';
    $content .= fetch_data();
    $content .= '</table>';
    $obj_pdf->writeHTML($content);
    ob_end_clean();
    $obj_pdf->Output('summary.pdf', 'I');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emmaus Shop
        Management System | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">

                <div class="main-page">
                    <div class="col-md-8 col-md-offset-2">
                        <div style="margin:23px;" id="exampl">
                            <h3 style="color:violet; text-decoration:underline;">SELECT MONTH AND DATE TO VIEW SUMMARY</h3>
                            <form action='reporttoexcel.php' method="POST">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label>Year</label>
                                        <select name="year" class="form-control" id='year'></select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Month</label>
                                        <select name="month" class="form-control" id='month'></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <button id="submit_filter" class="btn btn-success" style="margin: 23px; " name='getsumm'>GET SUMMARY</button>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" name="exportreport" style="margin: 23px;" class="btn btn-success" value="Export To Excel" />
                            </form>
                        </div>
                    </div><br><br>

                    <button class='btn btn-block btn btn-primary' style="margin-top: 23px;"><a href="dashboard.php">Back to Dashboard</a></button><br>
                    <div id="show">

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
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/waypoint/waypoints.min.js"></script>
    <script src="js/counterUp/jquery.counterup.min.js"></script>
    <script src="js/amcharts/amcharts.js"></script>
    <script src="js/amcharts/serial.js"></script>
    <script src="js/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="js/amcharts/themes/light.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    <script src="js/icheck/icheck.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script src="js/production-chart.js"></script>
    <script src="js/traffic-chart.js"></script>
    <script src="js/task-list.js"></script>
    <script>
        // populate with years
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#year").append(options);

        // populate with months
        var nowY = 12,
            options = "";

        for (var Y = nowY; Y >= 1; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#month").append(options);

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
            toastr["success"]("Enter year and Month to view Records!");

        });
    </script>
</body>
<script>
    var useryearInput = document.getElementById('year');
    var usermonthInput = document.getElementById('month');
    $(document).ready(
        function() {
            //when the user clicks on the submit button, we load the searchdata.php file, passing the date 
            //the user entered in the input

            $("#submit_filter").click(
                function() {
                    $("#show").load("monthreporthandler.php", {
                        year: useryearInput.value,
                        month: usermonthInput.value
                    });

                    return false;
                }
            );
        }
    );
</script>

</html>