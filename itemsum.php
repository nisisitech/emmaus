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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emmaus Shop
        Management System | Item Summaries</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">

                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="col-md-8 col-md-offset-2">
                        <div style="margin:23px;" id="exampl">
                            <h3 style="color:violet; text-decoration:underline;">ENTER DATE TO SEARCH RESULT:</h3>

                            <!-- <form class="form-group" onsubmit="validateDates()" method="POST"> -->
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label>START DATE</label>
                                        <input placeholder='Format =YYYY-MM-DD' class="form-control" id="sdate" name="sdate" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>END DATE</label>
                                        <input placeholder='Format =YYYY-MM-DD' class="form-control" id="edate" name="edate" required>
                                    </div>
                                    <div class="col-md-8 col-md-offset-2" style="margin-top: 23px;">
                                         <button onclick="validateDates()" class='btn btn-success' name='results' id='results'>CHECK RESULTS</button>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                        <div id='showresults'>

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
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
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
            toastr["success"]("Welcome to Emmaus Shop Management System!");

        });
    </script>
    <script>
        $(function($) {

        });


        function CallPrint(strid) {
            var prtContent = document.getElementById("exampl");
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }

        //checks that the dates entered are of valid format
        function validateDates() {
            var sDateInput = document.getElementById("sdate");
            var eDateInput = document.getElementById("edate");
            var validDatesFormat = true;
            var startDateArray = sDateInput.value.split("-");
            var endDateArray = eDateInput.value.split("-");
            var startYear = startDateArray[0];
            var endYear = endDateArray[0];
            var startMonth = startDateArray[1];
            var endMonth = endDateArray[1];
            var startDay = startDateArray[2];
            var endDay = endDateArray[2];

            //the dates should be made of 3 parts separated by the - sign
            if(startDateArray.length !== 3 || endDateArray.length !== 3){
                alert("Wrong Dates Format. Use YYYY-MM-DD");
                validDatesFormat = false;
                return false;
            }

            //the year should be a string of lenght 4
            if(startYear.length !== 4 || endYear.length !== 4){
                alert("Wrong Dates Format. Use YYYY-MM-DD");
                validDatesFormat = false; 
                return false;
            } 

            //the month should be between 01 and 12 inclusive
            if(parseInt(startMonth) > 12 || parseInt(endMonth) > 12){
                alert("Wrong Dates Format. Use YYYY-MM-DD. Months should be between 01 and 12");
                validDatesFormat = false;
                return false;
            }

            //the day cannot be greater than 31
            if(parseInt(startDay) > 31 || parseInt(endDay) > 31){
                alert("Wrong Dates Format. Use YYYY-MM-DD. days should be between 01 and 31");
                validDatesFormat = false;
                return false;
            }

            if(sDateInput.value === eDateInput.value){
                alert("Dates cannot be the same");
                validDatesFormat = false;
                return false;
            }

            //if the dates pass this tests they can be handled by php
            if(validDatesFormat){
                $("#showresults").load("itemsummaries.php", {
                    sdate:sDateInput.value ,
                    edate:eDateInput.value
                });

                return false;
            }
        }
    </script>
</body>

</html>