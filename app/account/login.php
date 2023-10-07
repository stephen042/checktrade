<?php
session_start();
require_once("../conn.php");
require_once("../config.php");

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
        @$message .= '<!DOCTYPE html>
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
                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Login Alert !!</h1>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">													Hello '.$fname.', We notice a successful login into your checkedtrades pro account! If you do not recognize this transaction, kindly contact our support now or reply to this email.
                            </p>
                            <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                <a href="https://checkedtradespro.online/contact-us/index.html" style="color:#ee4c50;text-decoration:underline;"> 
                                    <button> 
                                        Support 
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
    <link rel="shortcut icon" type="image/png" href="../dashboard/assets/img/favicon.png">
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
        <!-- GetButton.io widget -->
        <script type="text/javascript">
        (function () {
            var options = {
                whatsapp: "+1 (623) 352-5942", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "left", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /GetButton.io widget -



</body>

</html>