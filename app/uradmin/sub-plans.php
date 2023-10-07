<?php

include("dbcon.php");
include('session.php'); 

    if (isset($_POST['create_ai'])) {
        // echo ("<script>window.alert('is working')</script>");
        $plan = htmlspecialchars($_POST['plan']);
        $amount = htmlspecialchars($_POST['price']);
        $duration = htmlspecialchars($_POST['duration']);
        $win_rate = htmlspecialchars($_POST['win_rate']);

        if (empty($plan) || empty($amount) || empty($duration) || empty($win_rate)) {
            echo '<script>window.alert("All fields are required")</script>';   
        }

        $result = mysqli_query($conn, " INSERT INTO ai_plan (plan, price, duration, win_rate) VALUES ('$plan','$amount','$duration','$win_rate')");

        if ($result) {
            echo '<script>window.alert("Ai Plan Created Successfully")</script>';
        }else{
            echo '<script>window.alert("An error occurred")</script>';
        }

    }elseif (isset($_POST['create_status'])) {
        $plan = htmlspecialchars($_POST['plan']);
        $amount = htmlspecialchars($_POST['price']);
        $duration = htmlspecialchars($_POST['duration']);

        if (empty($plan) || empty($amount) || empty($duration)) {
            echo '<script>window.alert("All fields are required")</script>';   
        }

        $result = mysqli_query($conn, " INSERT INTO status_plan (plan, price, duration) VALUES ('$plan','$amount','$duration')");

        if ($result) {
            echo '<script>window.alert("Plan Created Successfully")</script>';
        }else{
            echo '<script>window.alert("An error occurred")</script>';
        }

    }

    if (isset($_POST['delete_ai'])) {
        // echo ("<script>window.alert('is working')</script>");
        $id = $_POST['id'];
        $sql = "DELETE FROM ai_plan WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<script>window.alert("Deleted Successfully")</script>';
        }else{
            echo '<script>window.alert("An error occurred")</script>';
        }
    }elseif (isset($_POST['delete_status'])) {

        $id = $_POST['id'];
        $sql = "DELETE FROM status_plan WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<script>window.alert("Deleted Successfully")</script>';
        }else{
            echo '<script>window.alert("An error occurred")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Subscription Plans</title>

    <!-- Bootstrap -->
     <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index" class="site_title"><img src="images/new_logo.png" width="150px" height="40px"></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!--<div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
          -->
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
                 <li><a href="index"><i class="fa fa-home"></i> Home</a>
                 </li>
                  <li><a href="users"><i class="fa fa-users"></i> Registered User</a>
                  </li>
                  <li><a href="referral"><i class="fa fa-book"></i> Referal</a>
                  <li class=""><a href="user-investement"><i class="fa fa-file"></i> Investment</a>
                  </li>
                  </li>
                  <li class=""><a href="user-trade"><i class="fa fa-credit-card"></i> Trade Result</a>
                  </li>
                  <li class=""><a href="users-earning"><i class="fa fa-user"></i> User Earning</a>
                  </li>
                  <li class=""><a href="users-deposit"><i class="fa fa-magnet"></i> User Deposit</a>
                  </li>
                  <li><a href="users-withdrawal"><i class="fa fa-magnet"></i> Withdrawal</a>
                  </li>
                  <li class="active" ><a href="sub-plans"><i class="fa fa-magnet"></i> Subscription Plans</a>
                  </li>
                  <li><a href="yearly-forcast"><i class="fa fa-magnet"></i> Yearly Forecast Report</a>
                  </li>
                  <li><a href="stats"><i class="fa fa-magnet"></i> Statistics (Charts)</a>
                  </li>
                  <li><a href="users-log"><i class="fa fa-magnet"></i> Logs</a>
                  </li>
                  <li><a href="system-log"><i class="fa fa-magnet"></i> System Activities</a>
                  </li>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php include('bottom_menu.php')?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php include("top_nav.php")?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
           <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><i class="fa fa-credit-card"></i> User Subscription Plan Tables </h3>
              </div>
              
  </div>


<!--- For status Plans ------------------------------------------------------------------------------ -->

            <br><br>    
            <?php 
            $query = mysqli_query($conn, "SELECT * FROM status_plan order by id DESC ");
            $row = mysqli_fetch_array($query);
            $num_row = mysqli_num_rows($query);
                  
            ?>
           <div class="col-md-12 col-sm-12 col-xs-12">
           <hr style="border: 2px solid lightgrey;">
            <h2 class="text-primary"> Status Plans</h2>
            <hr>
            
            <!-- Vertical Form -->
            <!-- <center> -->
            <form method="post" class="row g-3" style="width: 90%;padding:20px;">
                <div class="col-4">
                  <label for="inputNanme4" class="form-label">Plan Name <span class="text-danger">*eg = V VIP</span></label>
                  <input type="text" class="form-control" name="plan" id="inputNanme4" placeholder="plan name here" required>
                </div>
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputEmail4" class="form-label">Price <span class="text-danger">*eg = 300 No $ sign</span></label>
                  <input type="text" class="form-control" name="price" id="inputEmail4" placeholder="Amount here" required>
                </div>
                 <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Duration <span class="text-danger">*eg = 3 days or 1 day</span></label>
                  <input type="text" class="form-control" name="duration" id="inputAddress" placeholder="1 day or 3 days" required>
                </div>
                <div class="text-center" style="margin-top: 20px;">
                  <button type="submit" name="create_status" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
            <hr>
            <!-- </center> -->
            <!-- Vertical Form -->
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                          
                            <th class="column-title">#</th>
                            <th class="column-title">Plan Name</th>
                            <th class="column-title">Price</th>
                            <!-- <th class="column-title">Win_rate</th> -->
                            <th class="column-title">Duration</th>
                            <th class="column-title">Action</th>
                            <th></th>

                            </tr>
                        </thead>

                        <tbody>

                          <?php
                    if ($num_row > 0) 
                    {
                  $query_st = mysqli_query($conn," SELECT * FROM  status_plan order by id DESC");
                  $counter = 0;
                  while($data = mysqli_fetch_array($query_st)){
                    
                    $counter++;
                    
                      ?>
                        <tr class="odd gradeX">
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $data['plan']?></td>
                        <td><?php echo $data['price']?></td>
                        <td ><?php echo $data['duration'] ?></td>
                      
                      <td style="display: flex;">
                      <form method="post">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <button class="btn btn-round btn-xs btn-danger" name="delete_status" type="submit">
                            <i class="fa fa-times"> delete</i>
                        </button>
                      </form>
                      </tr>
                      <?php 
                        }
                          }
                    else
                        { 
                      ?>    
                        <tr class="odd gradeX">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td ></td>
                            <td ></td>
                        </tr>
                      <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
         
        </div>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php include('footNote.php')?>
        <!-- /footer content -->
      </div>
    </div>
    <style type="text/css">
            .p2 {
             position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -120px;
            }

            #bottom { 
                position:absolute;                  
                bottom:10px;                          
                margin-left : auto;
                margin-right : auto;   
                width: 100%;
                height: auto;                      
            } 
        </style>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
  </body>
</html>