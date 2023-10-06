<?php
session_start();
require_once("../../conn.php");
require_once("../../config.php");

// echo ("<script>document.getElementById('login_btn').disabled = true;</script>");
// echo ("<script>window.alert('Login Success!')</script>");
$display_message = "";
if (isset($_POST['login_btn'])) {
    echo ("<script>document.getElementById('login_btn').disabled = true;</script>");
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // selecting user
    $query = mysqli_query($conn, "SELECT * FROM user_tb WHERE uemail ='$email' AND upassword = md5('$password') AND u_status = 'Activated'");
    $row = mysqli_fetch_array($query);
    $num_row = mysqli_num_rows($query);

    if ($num_row > 0) {
        $email = $row['uemail'];
        $fname = $row['fname'];
        //$_SESSION['user_id']=$row['user_id'];
        $_SESSION['fullname'] = $row['fname'];
        @$_SESSION['email'] = $row['uemail'];
        @$_SESSION['username'] = $row['uusername'];
        @$_SESSION['mynetwork'] = $row['u_refer_code'];
        @$_SESSION['reg_code'] = $row['u_invit_code'];
        @$_SESSION['acct_amt'] = $row['u_amount'];
        @$_SESSION['country'] = $row['ucountry'];
        @$_SESSION['reg_date'] = $row['u_datereg'];
        @$_SESSION['acct_status'] = $row['u_status'];
        $_SESSION['userid'] = $row['user_id'];

        $display_message = "<font  class='alert alert-success' style='text-align:center' color='#009966' style='font-family:Arial, sans-serif' size='+1'><h3 class='mt-0'>Access granted!</h3></font>
        <p align ='center'><span class='text-black pt-5'>Please wait, system will redirect you in a moment</span></p>
            
        <p align ='center'><font style='text-align:center'><i class='fa fa-spinner' aria-hidden='true'></i></font></p>
        <meta http-equiv='refresh' Content='4; url=../../dashboard' />";


        //Insert into log activities
        $query = mysqli_query($conn, "INSERT INTO user_log(username, login_date, online_status, logout_date, user_id) 
					VALUES ('$email', NOW(),'1','', '" . $row['user_id'] . "') ");

        $query_up2 = mysqli_query($conn, "INSERT INTO activities_log(act_username, act_action, act_date, act_system_id) 
					VALUES ('$email', 'Login Successful', NOW(), '" . $row['user_id'] . "') ");


        // Send mail to user with verification here
        $to = $email;
        $subject = "Login Security Alert";

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
                                    <td height='80' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF' style='padding:0;margin:0;font-size:0;line-height:0'><img src='../../CoinSmart-logo-Light.png'>
                                    
                                    </td>
                   			  </tr>
                                <tr>
                                    <td align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                        	<tr>
                                            	<td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                  <h6 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:25px;color:#404040;line-height:48px;font-weight:bold;margin:0;padding:0'>Account Login</h6>
                                                </td>
                                                <td width='25'></td>
                                            </tr>
                                            <tr>
                                            	<td colspan='3' height='40'></td></tr><tr>
                                            	  <td colspan='5' align='center'>
                                                    <p style='color:#404040;font-size:16px;line-height:24px;font-weight:lighter;padding:0;margin:0'>
													Hello $fname, We notice a successful login into your checkedtrades pro account! If you do not recognize this transaction, kindly contact our support now.</p>
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
                                                            <td align='center' style='margin:0;text-align:center'><a href='https://checkedtradespro.online/contact-us/index.html' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Click here to contact support</a></td>
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
                                          <div style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'>You can always contact us for any support or write us an email on <a href='mailto:support@checkedtradespro.online' target='_blank'> support@checkedtradespro.online </a> </div>
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
        $header = "From:Account-Security <noreply@checkedtradespro.online> \r\n";
        $header .= "Cc: noreply@checkedtradespro.online \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        @$retval = mail($to, $subject, $message, $header);
    } else

        $display_message = "<font style='text-align:center' color='#FF0000' style='font-family:Arial, sans-serif' size='+1'><h4 class='mt-0'>Access denied!</h4></font>
					<p align ='center'><span class='text-black pt-10'>Invalide Login Details</span></p>";
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - <?= APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.html">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="../../../www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="login.php">
                    <input type="hidden" name="_token" value="SCXFfW89j9JcNFtOTK1yDd5YDQfsII8wuP4b9we9">

                    <div class="login-form-head">
                        <h4>Login<br>checkedtrades.online</h4>
                        <p><i class="ti-arrow-right"></i>Hello there, Login and Trade with the best</p>
                    </div>
                    <!-- <div class="login-form-head"> -->
                    <?php echo $display_message?>
                    <!-- </div> -->
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" type="email" id="exampleInputEmail1" required>
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input name="password" type="password" id="exampleInputPassword1" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <!--<a href="#">Forgot Password?</a>-->
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <input class="btn btn-block" id="login_btn" name="login_btn" type="submit" value="Login" style="background: orange; font-size: 15px; color: #FFF;">
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>



</body>

</html>