<?php

include("dbcon.php");
include('session.php'); 

    $msg = '';
    if (isset($_POST['trade_ai'])) {
        // echo ("<script>window.alert('$user_id')</script>");

        $user_id = $_POST['user_id'];
        $email = $_POST['uemail'];
        $trade_amt = trim($_POST['td_amt']);
        $note = trim($_POST['note']);
        $earning_state = trim($_POST['earning_state']);
        $td_type = trim($_POST['td_type']);
        $trade_price = trim($_POST['td_price']);
        $trade_profit = trim($_POST['profit']);
        $getnumber = rand(10000,99999);
        $sasa = $getnumber + 1;
        $fgh='0'.$sasa;                     
        $finalcode = 'CT'.$fgh;
        $verify_code = sha1($finalcode);
														

        if (empty($trade_amt) || empty($earning_state) || empty($td_type) || empty($trade_price) || empty($trade_profit) || empty($note)) {
            echo '<script>window.alert("All fields are required")</script>';   
        }

        $result = mysqli_query($conn, " SELECT * FROM user_tb WHERE user_id = '$user_id'");
        $data = mysqli_fetch_assoc($result);
         $name = $data['fname'];
         $email = $data['uemail'];
        if ($data) {
           if ($data['u_amount'] < $trade_amt) {
               echo '<script>window.alert("Low Balance")</script>';
           }
        }


        // insert into trading table
        $query_help = mysqli_query($conn, "INSERT INTO trading_tb(td_uid, td_email, td_amt, td_status, td_date, td_type, td_by ,td_price, td_profit, td_trac_code) VALUES ('$user_id', '$email', '$trade_amt', '$earning_state', NOW(), '$td_type', '1','$trade_price', '$trade_profit','$finalcode')");
        
        // insert into earning table
        $query_act1 = mysqli_query($conn,"INSERT INTO earning_tb(ea_id, ea_uid, ea_email, ea_amt, ea_status, ea_date, ea_type) 
        VALUES (NULL, '$user_id', '$email', '$trade_amt', '$earning_state', NOW(), '$note')");

        // keep record of action
        $query_act = mysqli_query($conn,"INSERT INTO activities_log (act_id, act_username, act_action, act_date, act_system_id) 
                 
        VALUES (NULL, '$user_username', 'Added Trading Profit', NOW(), '$session_id')");

        if ($earning_state == 'Lost') {
            $current_amt = $data['u_amount'];
            $lost_amt = $current_amt - $trade_profit;
            $query_lost = mysqli_query($conn, "UPDATE user_tb SET u_amount ='$lost_amt' WHERE user_id = '$user_id'");
            $msg = "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <h4>Successful</h4>
            LOST Added successfully, User trading is completed.</div>
            <p align ='center'><font style='text-align:center'></font></p>
            "; 
        }elseif ($earning_state ==  'Successful') {

            $profit_amt = $data['u_withraw_pending'] + $trade_profit;
            $trade_fee = $data['u_amount'] - $trade_amt;
            $query_profit = mysqli_query($conn, "UPDATE user_tb SET u_withraw_pending='$profit_amt', u_amount='$trade_fee' WHERE user_id = '$user_id'");

            if ($query_profit) {
                $msg = "<div class='alert alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <h4>Successful</h4>
                Profit Added successfully, User trading is completed.</div>
                <p align ='center'><font style='text-align:center'></font></p>
                ";

                 // Send mail to user with verification here
                    $to = $email;
                    $subject = "Trade Credit Transaction Alert";
                    
                    // Create the body message
                    @$message .= "<br>
                    <div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee'>
                <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
                <tbody>
                    <tr>
                    <td bgcolor='#FFFFFF'>
                            <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee' style='width:750px!important'>
                            <tbody>
                            <tr>
                                <td>
                                <table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
                                        <tbody>
                                            <tr>
                                                <td align='center'>
                                                    <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                                    <tbody>
                                                    <tr>
                                                        <td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                            <td align='center'>
                                                            <h6 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:25px;color:#404040;line-height:48px;font-weight:bold;margin:0;padding:0'>Deposit Transaction</h6>
                                                            </td>
                                                            <td width='25'></td>
                                                        </tr>
                                                        <tr>
                                                        <td colspan='3' height='40'></td></tr><tr>
                                                            <td colspan='5' align='center'>
                                                                <p style='color:#404040;font-size:16px;line-height:24px;font-weight:lighter;padding:0;margin:0'>
                                    Hello $name, Your account has be credited with USD$trade_profit. This will reflect in your account in the next few minutes.</p>
                                                                <br>
                                                                <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        <td colspan='4'>
                                                            <div style='width:100%;text-align:center;margin:30px 0'>
                                                                <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                                <tbody>
                                                                <tr>
                                                                        <td align='center' style='margin:0;text-align:center'><a href='<?php echo APP_URL ; ?>' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Click here to login</a></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                            </tbody>
                                                </table>
                                        </td>
                                    </tr>
                                        
                                        <tr bgcolor='#ffffff'>
                                            <td bgcolor='#FFFFFF'>
                                            
                                            <table width='570' align='center' border='0' cellspacing='0' cellpadding='0'>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                    <h2 style='color:#404040;font-size:22px;font-weight:bold;line-height:26px;padding:0;margin:0'>&nbsp;</h2>
                                                    <div style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'>You can always contact us for any support or write us an email on support@checkedtradespro.online </div>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;</td>
                                            </tr></tbody></table></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee' style='width:750px!important'>
                                        <tbody>
                                        <tr>
                                            <td align='center'>
                                                    <table width='630' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
                                                    <tbody>
                                                    <tr><td colspan='2' height='30'></td></tr>
                                                        <tr>
                                                        <td width='360' valign='top'>&nbsp;</td>
                                                            <td align='right' valign='top'>
                                                            <span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/BggPYqAh.png' alt='fb'></a>&nbsp;</span>
                                                                <span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/j3NsGLak.png' alt='twit'></a>&nbsp;</span>
                                                                <span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/wFyxXQyf.png' alt='g'></a>&nbsp;</span>
                                                            </td>
                                                        </tr>
                                                        <tr><td colspan='2' height='5'></td></tr>
                                                    </tbody>
                                                    </table>
                                                <p><span style='color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0'>&copy; 2020 Checked Trades PRO. All Rights Reserved. </span></p></td>
                                    </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                            </table>
                        </td>
                </tr>
                </tbody>
                </table>
                </div>";
                    $header = "From:Checked Trades PRO <noreply@checkedtradespro.online> \r\n";
                    $header .= "Cc:noreply@checkedtradespro.online \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    
                    @$retval = mail ($to,$subject,$message,$header);
                                

            }
            
        }

        


    }

    // if (isset($_POST['delete_ai'])) {
    //     // echo ("<script>window.alert('is working')</script>");
    //     $id = $_POST['id'];
    //     $sql = "DELETE FROM ai_plan WHERE id = '$id'";
    //     $result = mysqli_query($conn, $sql);
    //     if ($result) {
    //         echo '<script>window.alert("Deleted Successfully")</script>';
    //     }else{
    //         echo '<script>window.alert("An error occurred")</script>';
    //     }
    // }
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Ai Trading </title>

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
                  <li  class="active" ><a href="users"><i class="fa fa-users"></i> Registered User</a>
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
                  <li><a href="users-sub-deposit"><i class="fa fa-magnet"></i> User Sub Deposit</a>
                  </li>
                  <li><a href="users-withdrawal"><i class="fa fa-magnet"></i> Withdrawal</a>
                  </li>
                  <li><a href="sub-plans"><i class="fa fa-magnet"></i> Subscription Plans</a>
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
                <h3><i class="fa fa-credit-card"></i> User Subscription Plan Tables <button type="button" class="btn btn-round btn-primary" onclick="window.history.back()"><i class="fa fa-arrow-left"></i> Back</button></a></h3>
              </div>
              
            </div>
           

            
            <br><br>
            <?php 
            $user_id = $_GET['id'];
            $query = mysqli_query($conn, "SELECT * FROM user_tb WHERE user_id = '$user_id'");
            $row = mysqli_fetch_array($query);
                  
            ?>
             
           <div class="col-md-12 col-sm-12 col-xs-12">
           <hr style="border: 2px solid lightgrey;">
            <h2 class="text-primary">Place AI Trade</h2>
            <p class="text-danger">If you choose 'lost' the profit entered will minus from client current Deposit balance</p>
            <p class="text-info">If you choose 'failed' the profit entered will not minus or add to client current Net or Deposit balance</p>
            <p class="text-success">If you choose 'successful' the profit entered will added To client current Net balance and Trade amount will be minus from Deposit Bal</p>
            <hr>
                <?php echo $msg;?>
            <hr>
            
            <!-- Vertical Form -->
            <!-- <center> -->
            <form method="post" class="row g-3" style="width: 90%;padding:20px;">
                <div class="col-4">
                  <label for="inputNanme4" class="form-label">User Email</label>
                  <input type="text" readonly class="form-control" value="<?=$row['uemail']?>" name="uemail" id="inputNanme4" >
                  <input type="hidden" class="form-control" value="<?=$row['user_id']?>" name="user_id" id="inputNanme4" >
                </div>
                <div class="col-4" style="margin-top: 10px;">
                  <label for="inputNanme4" class="form-label">Customer bals</label>
                  <input type="text" disabled class="form-control" value="Net Bal : <?=$row['u_withraw_pending']?> USD" name="u_email" id="inputNanme4" >
                  <input type="text" disabled class="form-control" value="Deposit Bal : <?=$row['u_amount']?> USD" name="user_id" id="inputNanme4" >
                </div>
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputEmail4" class="form-label">Trade Amount </label>
                  <input type="text" class="form-control" name="td_amt" id="inputEmail4" placeholder="Amount here" required>
                </div>
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Trade status </label>
                  <select class="form-control" name="earning_state" required>
                    <option selected disabled>select trade win or loss</option>
                    <option value="Failed" title="Failed">Trade Failed</option>
                    <option value="Lost" title="Trade Lost">Trade Lost</option>
                    <option value="Successful" title="Successful">Successful</option>
                    <!-- <option value="Profit" title="Earning Pending">Profit</option> -->
                    
                    </select>
                </div>
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Trade Type </label>
                    <select class="form-control" name="td_type" required>
                        <option disabled selected> Select option</option>
                        <option value="Turbo">Turbo</option>
                        <option value="Intraday">Intraday</option>
                        <option value="Long term">Long term</option>
                    </select>
                </div>
                
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Market Price </label>
                    <select class="form-control" name="td_price" required>
                        <option disabled selected> Select market price</option>
                        <option value="87% +0.87">87% +0.87</option>
                        <option value="88.3% +0.9">88.3% +0.9</option>
                        <option value="92.6% +0.9">92.6% +0.9</option>
                    </select>
                </div>

                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Profit Earning </label>
                  <input type="text" class="form-control" name="profit" id="inputAddress" placeholder="client trade profit" required>
                </div>
                <div class="col-6" style="margin-top: 10px;">
                  <label for="inputAddress" class="form-label">Description</label>
                  <input type="text" class="form-control" name="note" id="inputAddress" placeholder="successful trade or EURJPY" required>
                </div>

                <div class="text-center" style="margin-top: 20px;">
                  <button type="submit" name="trade_ai" class="btn btn-primary">Trade</button>
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
                            <th class="column-title">Date</th>
                            <th class="column-title">Type</th>
                            <th class="column-title">Price</th>
                            <th class="column-title">Volume</th>
                            <th class="column-title">Cost</th>
                            <th class="column-title">Status</th>
                            <th></th>

                            </tr>
                        </thead>

                        <tbody>

                          <?php
                    
                  $query = mysqli_query($conn," SELECT * FROM  trading_tb WHERE td_uid='$user_id' and td_by>'0' ");
                  $counter = 0;

                  if ($query) {

                  while($data = mysqli_fetch_assoc($query)){
                    
                    $counter++;
                    
                      ?>
                        <tr class="odd gradeX">
                            <td><?php echo $counter; ?></td>
                            <td><?php echo date("Y/M/d h:i A",strtotime($data['td_date']))?></td>
                            <td><?php echo $data['td_type']?></td>
                            <td><?php echo $data['td_price']?></td>
                            <td><?php echo '1'?></td>
                            <td ><?php echo $data['td_amt'] ?></td>
                            <td ><?php echo $data['td_status'] ?></td>
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
                      <hr style="border:3px solid lightgrey;">
                    </div>
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