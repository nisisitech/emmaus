<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        #panel{
            background-color:aqua;
            border-radius:23%;
            background-blend-mode:lighten;
            margin-top: 0px;
            margin-bottom:10px;
            margin-right:10px;
            margin-left:10px;
        }
        .formfeature{
            margin:10px 0 10px 0;
                   }
        body{
            background-color:peachpuff;
            background-blend-mode: luminosity;
            border-radius: 67%;
        }
        @media screen and (max-width: 1260px) {
  .formfeature  { margin: 30px 0px 40px 0px; }
}
    </style>
</head>

<body >
    <div class="main-wrapper">

        <div class="">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <section class="section">
                        <div class="row mt-40">
                            <div class="col-md-10 col-md-offset-1 pt-50">
                                <h1 style="text-align:center">Emmaus Investments</h1>
                                <?php

                                $url = "http//:$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                if (strpos($url, "login.php?wrongdetails") == true) {
                                    echo '<div class="alert alert-danger alert-dismissible" style="text-align:center;">
                            <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Wrong details! Try Again!</strong>
                            </div>';
                                }
                                ?>
                                <div class="row mt-30 ">
                                    <div class="col-md-11">
                                        <!-- //card  -->

                                        <div class="card">
                                            <img class="card-img-top" src="images/cereals.jpg" width="60%" height="200px" alt="Card image cap">
                                            <h3 class="card-title" style="text-align: center;">Log in using your credentials</h3>
                                            <div class="card-text" id="panel">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                    <form action="logis.php" method="POST" class="formfeature">
                                                        <div class=" form-group col-md-8 col-md-offset-2">
                                                            <label>Username:</label>
                                                            <input type="text" name="username" class="form-control" placeholder="UserName">
                                                        </div>
                                                        <div class="form-group col-md-8 col-md-offset-2">
                                                            <label>Password:</label>
                                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                                        </div>
                                                        <div class="form-group col-md-8 col-md-offset-2">
                                                            <button type="submit" name="login" class="btn btn-success btn-labeled pull-center">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <p class="text-muted text-center" style="font-size:24px;"><small>&copy;&nbsp;<?php echo date('Y') ?> All rights reserved</small></p>
                                    </div>
                                    <!-- /.col-md-11 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->
                    </section>

                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /. -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- ========== PAGE JS FILES ========== -->

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
        $(function() {

        });
    </script>

    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>