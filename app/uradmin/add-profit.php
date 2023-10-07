<?php 
include("dbcon.php");
include('session.php');
include('config.php');
                          $success_message = '';
                          $inv_amt = '';
                          $trac_code = '';
                          $deposit_email = '';
                    //if update button is click, do this
                    if(isset($_POST['btn_profit']))
                    {
                    $a = $_POST['receiver_id'];
                    $trac_code = $_POST['trac_code'];
                    $amt_add = $_POST['amt_add'];
                    $due_date = $_POST['due_date'];
                    
                    $query_st1 = mysqli_query($conn," SELECT * FROM  user_tb where user_id = '$a'");
                    $counter = 0;
                    while(@$row = mysqli_fetch_array($query_st1))
                    {
                    $id = $row['user_id'];
                    $deposit_email = $row['uemail'];
                    $user_fname = $row['fname'];
                    $user_amt = $row['u_amount'];
                    @$user_pending_balance = $row['u_withraw_pending'];
                    }
                  $new_pending = ($amt_add + $user_pending_balance);
                  if($due_date =='Approved')
                  {
                  $clear_balance = ($new_pending + $user_amt);
              // update user record
                  $query_inv = mysqli_query($conn, "UPDATE user_tb SET u_withraw_pending ='$new_pending' WHERE user_id ='$a'");
                 // insert into earning table
                  $query_act1 = mysqli_query($conn,"INSERT INTO earning_tb(ea_id, ea_uid, ea_email, ea_amt, ea_status, ea_date, ea_type) 
                  VALUES (NULL, '$a', '$deposit_email', '$amt_add', 'Confirm', NOW(), 'Investment Profit')");
                 // keep record of action
                   $query_act = mysqli_query($conn,"INSERT INTO activities_log (act_id, act_username, act_action, act_date, act_system_id) 
                 
                 VALUES (NULL, '$user_username', 'Added Investment Profit', NOW(), '$session_id')");
                  
                    if($query_inv)
                    {
                    $success_message = "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <h4>Successful</h4>
                    Profit Added successfully, User investment is completed.</div>
                    <p align ='center'><font style='text-align:center'></font></p>
                    <meta http-equiv='refresh' Content='4; url=user-investement' />
                    ";
                    }
                  
                    else
                    {
                  $success_message = "<div class='alert alert-warning'>
                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  <h4>Error occured!</h4>
                  The operation was not successful, try again.</div>";
                  }
                }
                  // admin choose no
                  
                  if($due_date =='No' || $due_date =='')
                  {
                  $new_pending = ($amt_add + $user_pending_balance);
              // update user record
                  $query_inv2 = mysqli_query($conn, "UPDATE user_tb SET u_withraw_pending ='$new_pending' WHERE user_id ='$a'");
                 // insert into earning table
                  $query_act2 = mysqli_query($conn,"INSERT INTO earning_tb(ea_id, ea_uid, ea_email, ea_amt, ea_status, ea_date, ea_type) 
                  VALUES (NULL, '$a', '$deposit_email', '$amt_add', 'Confirm', NOW(), 'Investment Profit')");
                 // keep record of action
                   $query_act3 = mysqli_query($conn,"INSERT INTO activities_log (act_id, act_username, act_action, act_date, act_system_id) 
                 
                 VALUES (NULL, '$user_username', 'Added Investment Profit', NOW(), '$session_id')");
                  
                    if($query_inv2)
                    {
                    $success_message = "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <h4>Successful</h4>
                    Profit Added successfully.</div>
                    <p align ='center'><font style='text-align:center'></font></p>
                    <meta http-equiv='refresh' Content='4; url=user-investement' />
                    ";
                    }
                    else
                    {
                  $success_message = "<div class='alert alert-warning'>
                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  <h4>Error occured!</h4>
                  The operation was not successful, try again.</div>";
                  }
                }
                    
      // Send mail to user with verification here
      $to = $deposit_email;
          $subject = "Credit Transaction Alert";
         
         // Create the body message
         @$message .= '
         <!DOCTYPE html>
         <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
         <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width,initial-scale=1">
           <meta name="x-apple-disable-message-reformatting">
           <title></title>
           <!--[if mso]>
           <noscript>
             <xml>
               <o:OfficeDocumentSettings>
                 <o:PixelsPerInch>96</o:PixelsPerInch>
               </o:OfficeDocumentSettings>
             </xml>
           </noscript>
           <![endif]-->
           <style>
             table, td, div, h1, p {font-family: Arial, sans-serif;}
             button{
                 font: inherit;
                 background-color: #FF7A59;
                 border: none;
                 padding: 10px;
                 text-transform: uppercase;
                 letter-spacing: 2px;
                 font-weight: 700; 
                 color: white;
                 border-radius: 5px; 
                 box-shadow: 1px 2px #d94c53;
               }
           </style>
         </head>
         <body style="margin:0;padding:0;">
           <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
             <tr>
               <td align="center" style="padding:0;">
                 <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                   <tr>
                     <td align="center" style="padding:30px 0 30px 0;background:#70bbd9;">
                       <img src="https://checkedtradespro.online/app/CoinSmart-Logo-Light.png" alt="" width="150" style="height:auto;display:block;" />
                     </td>
                   </tr>
                   <tr style="background-color: #eeeeee;">
                     <td style="padding:36px 30px 42px 30px;">
                       <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                         <tr>
                           <td style="padding:0 0 36px 0;color:#153643;">
                             <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Credit Transaction Alert</h1>
                             <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">													Hello '.$user_fname.', Your account has be credited with '.$amt_add.'. This will reflect in your account in the next few minutes. </p>
                             <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                 <a href="https://checkedtradespro.online/app/account/login.php" style="color:#ee4c50;text-decoration:underline;"> 
                                     <button> 
                                         Click here to login
                                     </button>  
                                 </a>
                             </p>
                           </td>
                         </tr>
                       </table>
                     </td>
                   </tr>
                   <tr>
                     <td style="padding:30px;background:#ee4c50;">
                       <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                         <tr>
                           <td style="padding:0;width:50%;" align="left">
                             <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                               &reg; 2020 copyright checkedtradespro<br/><a href="http://www.example.com" style="color:#ffffff;text-decoration:underline;">visit site</a>
                             </p>
                           </td>
                           <td style="padding:0;width:50%;" align="right">
                             <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                               <tr>
                                 <td style="padding:0 0 0 10px;width:38px;">
                                   <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                 </td>
                                 <td style="padding:0 0 0 10px;width:38px;">
                                   <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                 </td>
                               </tr>
                             </table>
                           </td>
                         </tr>
                       </table>
                     </td>
                   </tr>
                 </table>
               </td>
             </tr>
           </table>
         </body>
         </html>';
         $header = "From:Checked Trades PRO <noreply@checkedtradespro.online> \r\n";
         $header .= "Cc:noreply@checkedtradespro.online\r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         @$retval = mail ($to,$subject,$message,$header);
    
              }
  
              
                          if(isset($_GET['id']))
          
                            {
                          $id = $_GET['id'];
                            }
            
                          
                    // Send the bonus action      
                    
                    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Add Profit</title>

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

                  <li><a href="users"><i class="fa fa-users"></i> Registered User</a>
                  </li>
                  <li><a href="referral"><i class="fa fa-book"></i> Referal</a>
                  <li class="active"><a href="user-investement"><i class="fa fa-file"></i> Investment</a>
                  </li>
                  </li>
                  <li class=""><a href="user-trade"><i class="fa fa-credit-card"></i> Trade Result</a>
                  </li>
                  <li><a href="users-earning"><i class="fa fa-user"></i> User Earning</a>
                  </li>
                  <li><a href="users-deposit"><i class="fa fa-magnet"></i> User Deposit</a>
                  </li>
                  <li class=""><a href="users-sub-deposit"><i class="fa fa-magnet"></i> User Sub Deposit</a>
                  </li>
                  <li><a href="users-withdrawal"><i class="fa fa-magnet"></i> Withdrawal</a>
                  </li>
                  <li><a href="yearly-forcast"><i class="fa fa-magnet"></i> Yearly Forecast Report</a>
                  </li>
                  <li><a href="stats"><i class="fa fa-magnet"></i> Statistics (Charts)</a>
                  </li>
                  <li><a href="users-log"><i class="fa fa-magnet"></i> Logs</a>
                  </li>
                  <li><a href="system-log"><i class="fa fa-magnet"></i> System Activities</a>
                  </li>
                </ul>
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
                <h3><i class="fa fa-user"></i>  Add Profit <a href="user-investement"><button type="button" class="btn btn-round btn-primary"><i class="fa fa-arrow-left"></i> Back</button></a></h3>
              </div>

              
            </div>


            <?php //include("user_graphReport.php")?>
            
            <br><br>
            <?php 
            $query = mysqli_query($conn, "SELECT * from investment_tb where '$id' = sha1(inv_id) AND inv_status = 'Confirm'");
            $row = mysqli_fetch_array($query);
            $num_row = mysqli_num_rows($query);
                  
            if ($num_row > 0) 
              {
          ?>
          <?php echo $success_message;?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Enter details to add profit to user account</small></h2>
                    <?php
            $query_st = mysqli_query($conn," SELECT * from investment_tb where '$id' = sha1(inv_id) AND inv_status = 'Confirm'");
                  $counter = 0;
                  while(@$row = mysqli_fetch_array($query_st))
                  {
                    
                    $id = $row['inv_id'];
                    
                  ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                     
                    </p>
          
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">

              
               <form method="post" enctype="multipart/form-data">
                 <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Amount Invested
                    <input class="form-control" id="focusedInput" type="text" name="withdrawa_year" disabled value="<?php echo @$row['inv_amt']; ?>">
                  </div>

                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    User Email ID
                    <input class="form-control" id="focusedInput" type="text" name="deposit_year" disabled value="<?php echo @$row['inv_email']; ?>">
                  </div>

                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Transaction ID
                    <input class="form-control" id="focusedInput" type="text" name="" disabled value="<?php echo @$row['inv_run_code']; ?>">
                    <input class="input-xlarge focused" id="focusedInput" type="hidden" name="trac_code" value="<?php echo @$row['inv_run_code']; ?>">
                  </div>

                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Percentage Earning
                    <input class="form-control" id="focusedInput" type="text" name="amt_add" value="<?php echo @$row['inv_profit_amt']; ?>" placeholder ="Enter Profit Sharing" required>%
                  </div>


                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Start Date
                    <input class="form-control" id="focusedInput" type="text" name="start_date" value="<?php echo @$row['inv_start_day']; ?>" placeholder ="Enter Start Date">
                  </div>


                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Duration
                    <input class="form-control" id="focusedInput" type="text" name="duration" value="<?php echo @$row['inv_days']; ?>" placeholder ="Enter Duration">
                  </div>

                  <input class="form-control" id="focusedInput" type="hidden" name="receiver_id" value="<?php echo @$row['inv_uid']; ?>">

                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    Period Due
                    <select class="form-control" name="due_date" id="ucountry" data-placeholder="Approved if period is due" required>
                  <option></option>
                  <option value="No" title="No">No</option>
                  <option value="Approved" title="Yes">Approved Due Date</option>
                  
                  </select>
                  </div>


                 
                  <br>
                  <div class="">
                    <br>
                  </div>
            
                </div>
             
              <br><br><div align="Center">
                <button type="submit" id="btn_profit" name="btn_profit" class="btn btn-round btn-primary align-center"><i class="fa fa-paper-plane"></i> Post Earning</button>
                </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php 
                      }
                ?>  
         
          <?php 
          
          }else
      echo $message = '<h4 class="text-center p2"><div class="alert alert-dismissible alert-warning">
  
      <strong>Sorry!</strong> You currently do not have any record at the moment.</div></div></h4>';;
  ?>

            <br>

            
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