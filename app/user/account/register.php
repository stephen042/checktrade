<?php
session_start();
require_once("../../conn.php");
require_once("../../config.php");
@$refer_link = '';
@$error_message = "";
$success_message = "";

@$ref_id = @$_GET['ref'];
$ref = $ref_id;
@$query = mysqli_query($conn, "select * from user_tb where uusername = '$ref'");
@$row = mysqli_fetch_array($query);
@$id2 = $row['user_id'];
@$refer_link = $row['uusername'];


if (isset($_POST['signup_btn'])) {
    $getnumber = rand(10000, 99999);
    $sasa = $getnumber + 1;
    $fgh = '0' . $sasa;
    $finalcode = 'nutr' . $fgh;
    $verify_code = sha1($finalcode);
    //$_SESSION['app_id'] = $finalcode;

    $fullname = htmlspecialchars($_POST['full_name']);
    $user_email = htmlspecialchars(trim(strtolower($_POST['email'])));
    $phone = htmlspecialchars($_POST['phone']);
    $country = htmlspecialchars(trim($_POST['country']));
    $mynetwork = htmlspecialchars(trim($_POST['mynetwork']));
    $password1 = trim(md5($_POST['password']));
    $password2 = trim($_POST['password']);
    $Cpassword = trim($_POST['cpassword']);
// /////////////////////////////////////////////
    $u_amount = 0;
    $withdrawl_bal = 0;
    $u_refer_amt = 0;
    $u_signal_amt = 0;
    $doc = Null;
    $date = date("Y-m-d H:i");
    $status = "None";

    if ($password2 != $Cpassword) {
        @$error_message = '<font class="alert alert-success text-danger mt-2 font-weight-bold" >Passwords do not match</font>';
        if (strlen($password2) < 6) {
            @$error_message = '<font class="alert alert-success text-danger mt-2 font-weight-bold" >Passwords must be at least 6 characters</font>';
        }
    } elseif (empty($fullname) && empty($user_email) || empty($phone) || empty($country) || empty($password1) || empty($Cpassword)) {
        @$error_message = '<font class="alert alert-success text-danger mt-2 font-weight-bold" >Please fill out all fields</font>';
    } else {
        $query = "SELECT * FROM user_tb WHERE uemail = '$user_email'";
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {
            @$error_message = '<font class="alert alert-success text-danger mt-2 font-weight-bold" >Email already exist</font>';
        }
    }
    // var_dump($fullname,$user_email,$phone,$country,$password1,$password2);

    if (empty($error_message)) {

        $sql = mysqli_query($conn, "INSERT INTO user_tb(fname, uemail, uusername, upassword, u_refer_code, u_invit_code,u_amount ,ucountry, u_datereg, u_status, withraw_bal, u_withraw_pending, u_ref_amt,uphone,u_document_approve ,upassword2,status_level, u_signalFund) VALUES ('$fullname', '$user_email', '$user_email', '$password1', '$refer_link', '$verify_code','$u_amount' ,'$country', '$date','Activated','$withdrawl_bal', '$withdrawl_bal', '$u_refer_amt','$phone', '$doc','$password2','$status', '$u_signal_amt')");

        $query_st = mysqli_query($conn, " SELECT * from user_tb where uemail = '$user_email' ");
        $row = mysqli_fetch_array($query_st);
        $num_row = mysqli_num_rows($query_st);

        if ($num_row > 0) {

            $id = $row['user_id'];
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

            $success_message = "<div align='center' class='alert alert-success'><font style='text-align:center' color='#009966' style='font-family:Arial, sans-serif' size='+1'><h3 class='mt-0'>Registration successful!</h3></font>
					<p align ='center'><span class='text-black pt-5'> We have sent you an email about your registration.<br>
					System will redirect you in a moment to your account and start to trade! Enjoy trading with <?=APP_NAME?> thank you.</span></p>
					 
					<p align ='center'><font style='text-align:center'><i class='fa fa-spinner' aria-hidden='true'></i></i></font></p>
					<meta http-equiv='refresh' Content='7; url=../../dashboard/' /></div>";
        }
        // insert into referral table
        @$query_referral = mysqli_query($conn, "INSERT INTO referral_tb(ref_id, ref_uid, ref_email, ref_my_username, ref_user_email, ref_status, ref_date, ref_amt) 
                                VALUES (NULL, '$id', '$user_email', '$user_email', '$mynetwork', '', NOW(), '')");

        if ($sql) {

            // Send mail to user with verification here
            $to = $user_email;
            $subject = "Registration successful";

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
                                <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Account Creation !!</h1>
                                <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"> Hello '.$fullname.' Your Account Have Been Created Successful. Click The Link Below For Activation</p>
                                <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                    <a href="https://checkedtradespro.online/app/dashboard/personal-data.php" style="color:#ee4c50;text-decoration:underline;"> 
                                        <button> 
                                            Activate Now
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
            $header = "From:Checked Trades Pro Account-Signup <noreply@checkedtradespro.online> \r\n";
            $header .= "Cc:noreply@checkedtradespro.online \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            @$retval = mail($to, $subject, $message, $header);
        } else {

            $error_message = "<font color='#FF0000' size='+1'> Registration failed, try again later</font>";
        }
    }
}

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sign up - <?=APP_NAME?></title>
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
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST">
                    <div class="login-form-head">
                        <h4>Sign Up<br>checkedtrades.online</h4>
                        <p><i class="ti-arrow-right"></i>Hello there, Sign up and Trade with the best</p>
                    </div>
                    <center>
                        <?php echo @$error_message; ?>
                        <?php echo $success_message; ?>
                    </center>


                    <div class="login-form-body">


                        <div class="form-gp">
                            <label for="exampleInputName1">Full Name</label>
                            <input type="text" name="full_name" id="exampleInputName1" value="<?php echo $_POST['full_name'] ?? ''; ?>">
                            <i class="ti-user"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" id="exampleInputEmail1" value="<?php echo $_POST['email'] ?? ''; ?>">
                            <i class="ti-email"></i>
                        </div>

                        <div class="form-gp">
                            <label for="exampleInputEmail1">Phone number</label>
                            <input type="number" name="phone" id="exampleInputEmail1" <?php echo $_POST['phone'] ?? ''; ?>>
                            <i class="ti-telephone"></i>
                        </div>
<!-- 
                        <div class="form-gp">
                            <select class="form-control" name="gender">
                                <option>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div> -->

                        <div class="form-gp">
                            <select class="form-control" name="country">
                                <option>Select Country</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antigua Barbuda">Antigua Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire">Bonaire</option>
                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Canary Islands">Canary Islands</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Channel Islands">Channel Islands</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos Island">Cocos Island</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curacao">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="East Timor">East Timor</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands">Falkland Islands</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Ter">French Southern Ter</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Great Britain">Great Britain</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea North">Korea North</option>
                                <option value="Korea South">Korea South</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macau">Macau</option>
                                <option value="Macedonia">Macedonia</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Midway Islands">Midway Islands</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Nambia">Nambia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherland Antilles">Netherland Antilles</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="Nevis">Nevis</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau Island">Palau Island</option>
                                <option value="Palestine">Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn Island">Pitcairn Island</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                <option value="Republic of Serbia">Republic of Serbia</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="St Barthelemy">St Barthelemy</option>
                                <option value="St Eustatius">St Eustatius</option>
                                <option value="St Helena">St Helena</option>
                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option value="St Lucia">St Lucia</option>
                                <option value="St Maarten">St Maarten</option>
                                <option value="St Pierre Miquelon">St Pierre Miquelon</option>
                                <option value="St Vincent Grenadines">St Vincent Grenadines</option>
                                <option value="Saipan">Saipan</option>
                                <option value="Samoa">Samoa</option>
                                <option value="Samoa American">Samoa American</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome Principe">Sao Tome Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Tahiti">Tahiti</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad Tobago">Trinidad Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks Caicos Is">Turks Caicos Is</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States of America">United States of America</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican City State">Vatican City State</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option value="Wake Island">Wake Island</option>
                                <option value="Wallis Futana Is">Wallis Futana Is</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zaire">Zaire</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </div>

                        <div class="form-gp">
                            <label for="exampleInputPassword1">Referral</label>
                            <input readonly type="text" name="mynetwork" value="<?php echo $ref; ?>" id="exampleInputPassword1">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>

                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" id="exampleInputPassword1">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Confirm Password</label>
                            <input type="password" name="cpassword" id="exampleInputPassword2">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="submit-btn-area">
                            <input class="btn btn-block" id="signup_btn" name="signup_btn" type="submit" value="Register" style="background: orange; font-size: 15px; color: #FFF;">
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="login.html">Sign in</a></p>
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
    <!-- GetButton.io widget -->



</body>


<!-- Mirrored from checkedtrades.online/user/account/register.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Feb 2023 09:28:47 GMT -->

</html>