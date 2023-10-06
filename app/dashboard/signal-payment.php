<?php
include('config.php');
include('session.php');
$msg = '';
$err = '';
if (isset($_POST['transfer'])) {
    $tf_uid = htmlspecialchars($_POST['tf_uid']);
    $amt = trim(htmlspecialchars($_POST['tf_amt']));
    $email = trim(htmlspecialchars($_POST['tf_email']));
    $acct_num = trim(htmlspecialchars($_POST['acct_number']));
    $note = htmlspecialchars($_POST['note']);

    if (empty($amt) || empty($note)) {
        echo ("<script>window.alert('All Fields are required ')</script>");
    }

    if ($amt > $signalFund) {
        $err = "Insufficient Subscription Balance <br> Fund Your <a href='acct-funding-sub.php' target='_blank'> Subscription wallet</a>";
        // echo ('<script>window.alert("insufficient fund")</script>');
    } else {
        $insert_query = mysqli_query($conn, "INSERT INTO transfer_tb (tf_uid, tf_amt, tf_email, tf_acct, tf_note) VALUE ('$tf_uid', '$amt','$email','$acct_num','$note')");

        $new_bal = $signalFund - $amt;

        $update_query = mysqli_query($conn, "UPDATE user_tb SET u_signalFund='$new_bal'");

        if ($insert_query && $update_query) {

            $msg = "Transfer Done Successfully <br> Wait a moment for your transfer to be confirmed";

            // Send mail to user with verification here
            $to = $email;
            $subject = "Debit Alert - Prime Option PRO";

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
                            <h4> Transfer Alert </h4>
                             Hello $name, Your account has be Debited with USD $amt. <br> Your Current Subscription Balance is USD $new_bal </p>
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
                                             <div style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'>You can always contact us for any support or write us an email on support@primeoptionpro.online </div>
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
                                         <p><span style='color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0'>&copy; 2020 primeoptionpro. All Rights Reserved. </span></p></td>
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
            $header = "From:Prime Option Pro <support@primeoptionpro.online> \r\n";
            $header .= "Cc:support@primeoptionpro.online \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            @$retval = mail($to, $subject, $message, $header);

            // Send mail to admin 
            $to_admin = APP_EMAIL;
            $subject_admin = "Customer Debit Alert - Prime Option PRO";

            // Create the body message
            @$message_admin .= "<br>
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
                            <h4> Transfer Alert </h4>
                             Hello Admin, Your Customer's account has be Debited with USD $amt. <br> His/Her Current Subscription Balance is USD $new_bal</p>
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
                                             <div style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'>You can always contact us for any support or write us an email on support@primeoptionpro.online </div>
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
                                         <p><span style='color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0'>&copy; 2020 primeoptionpro. All Rights Reserved. </span></p></td>
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
            $header = "From:Prime Option Pro <support@primeoptionpro.online> \r\n";
            $header .= "Cc:support@primeoptionpro.online \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            @$retval_admin = mail($to_admin, $subject_admin, $message_admin, $header);

        } else {
            $err = " Something Went Wrong Refresh Page And Try Again :)";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?= APP_NAME ?> Tradings Chart </title>
    <meta name="description" content="            
    ">

    <?php include('css.php'); ?>
    <style>
        .divider {
            border-bottom: 1px dotted;
        }

        .blinking {
            animation: blinkingText 2s infinite;
        }

        @keyframes blinkingText {
            0% {
                color: #f00;
            }

            49% {
                color: #600;
            }

            50% {
                color: #c00;
            }

            99% {
                color: #e00;
            }

            100% {
                color: #f00;
            }
        }

        .blinkgreen {
            animation: blinkgreenText 2s infinite;
        }

        @keyframes blinkgreenText {
            0% {
                color: #0f0;
            }

            49% {
                color: #060;
            }

            50% {
                color: #0c0;
            }

            99% {
                color: #0e0;
            }

            100% {
                color: #0f0;
            }
        }
    </style>

</head>

<body class="pushable  dimmable scrolling">

    <?php

    include('sider-bar.php');
    ?>

    <div class="pusher" aria-hidden="false">

        <?php
        include('navigation.php');
        ?>
        <div class="root-content">
            <div class="pusher push-trading">
                <div>
                    <div class="pusher">
                        <section class="">
                            <div class="row">

                                <div class="col col-12 " style="margin: 15px;">
                                    <h2 class="title">Signal Payment</h2>
                                </div>
                                <div class="col col-10" style="margin: 15px;">
                                    <p style="font-size: 20px;">
                                        <i class="fa fa-ban" style="color:red;font-size:30px;"></i>
                                        Warning !!! <span style="color:orange;">" Contact Account Manager or <a href="mailto:<?= APP_EMAIL ?>">Company Admin </a>Before Making Transfers "</span>
                                    </p>
                                    <hr style="border: 2px solid grey;">
                                    <?php if (!empty($msg)) { ?>
                                        <p class="btn btn-success">
                                            <?= $msg ?>
                                        </p>
                                        <hr style="border: 1px solid grey;">
                                    <?php } ?>
                                    <?php if (!empty($err)) { ?>
                                        <p class="btn btn-danger">
                                            <?= $err ?>
                                        </p>
                                        <hr style="border: 1px solid grey;">
                                    <?php } ?>

                                </div>

                            </div>
                            <!-- <span class="blue-arrow" style="border: 1px solid red;"></span> -->
                        </section>
                        <?php $user_data = mysqli_query($conn, " SELECT * FROM user_tb WHERE user_id='$session_id'");
                        if ($user_data) {
                            $data = mysqli_fetch_assoc($user_data);
                        }

                        ?>
                        <section>
                            <form method="post" class="row g-3 " style="width: 90%;padding:20px;">
                                <div class="col-10" style="margin-top: 10px;">
                                    <label for="inputEmail4" class="form-label">Subscription Wallet Balance </label>
                                    <input type="number" class="form-control text-dark" disabled value="<?php echo $signalFund ?>">
                                </div>
                                <div class="col-10" style="margin-top: 10px;">
                                    <label for="inputEmail4" class="form-label">Transfer Amount</label>
                                    <input type="number" class="form-control text-dark" name="tf_amt" id="inputEmail4" placeholder="Amount here" required>
                                </div>
                                <div class="col-10 " style="margin-top: 10px;">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" readonly class="form-control text-dark" name="tf_email" id="inputEmail4" value="<?= $data['uemail'] ?>">
                                    <input type="hidden" class="form-control text-dark" name="tf_uid" id="inputEmail4" value="<?= $data['user_id'] ?>">
                                </div>
                                <div class="col-10" style="margin-top: 10px;">
                                    <label for="inputAddress" class="form-label">Company's Account Number</label>
                                    <input type="text" id="acct_num" readonly class="form-control text-dark" name="acct_number">
                                </div>
                                <div class="col-10" style="margin-top: 10px;">
                                    <label for="inputAddress" class="form-label">Description</label>
                                    <input type="text" class="form-control text-light" name="note" id="inputAddress" placeholder="Payment purpose" required>
                                </div>

                                <div class="text-center" style="margin: 20px;">
                                    <button type="submit" name="transfer" class="btn btn-primary">Transfer</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                            <hr>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border: 1px solid grey;">
        <!-- Vertical Form -->
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">

                        <th class="column-title">#</th>
                        <th class="column-title">Date</th>
                        <th class="column-title">Amount</th>
                        <th class="column-title">Account Number</th>
                        <th class="column-title">Description</th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = mysqli_query($conn, " SELECT * FROM  transfer_tb WHERE tf_uid='$session_id' order by id DESC ");
                    $counter = 0;

                    if ($query) {

                        while ($data = mysqli_fetch_assoc($query)) {

                            $counter++;

                    ?>
                            <tr class="odd gradeX">
                                <td><?php echo $counter; ?></td>
                                <td><?php echo date("Y/M/d h:i A", strtotime($data['created_at'])) ?></td>
                                <td><?php echo $data['tf_amt'] ?></td>
                                <td><?php echo $data['tf_acct'] ?></td>
                                <td><?php echo $data['tf_note'] ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr class="odd gradeX">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr style="border:3px solid lightgrey;">
        </div>
        <?php
        include('footer.php');
        ?>
    </div>
    <!--sidebar-->

    <!---->

    <script type="text/javascript" async="" src="https://gbtraderoptions.com/assets/js/conversion_async.js"></script>
    <script type="text/javascript" async="" src="https://gbtraderoptions.com/assets/js/watch.js"></script>
    <script async="" src="https://gbtraderoptions.com/assets/js/analytics.js"></script>
    <script src="https://gbtraderoptions.com/dashboard/assets/inner.js"></script>
    <script src="https://gbtraderoptions.com/assets/js/vendor.js"></script>
    <script src="https://gbtraderoptions.com/dashboard/assets/app.js"></script>

    <script>
        $(document).ready(function() {
            var digits = Math.floor(Math.random() * 9000000000) + 1000000000;

            document.getElementById("acct_num").value = digits;
        });
    </script>


    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-76636433-1', 'auto');
        ga('send', 'pageview');
    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        if (bowser.safari || bowser.mac) {
            // disable for this
        } else {
            (function(d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter38379630 = new Ya.Metrika({
                            id: 38379630,
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true,
                            webvisor: true
                        });
                    } catch (e) {}

                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function() {
                        n.parentNode.insertBefore(s, n);
                    };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks");
        }
    </script>
    <noscript aria-hidden="false">
        <div><img src="https://mc.yandex.ru/watch/38379630" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 1057644682;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="https://gbtraderoptions.com/assets/js/conversion.js">
    </script>
    <noscript aria-hidden="false">
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1057644682/?guid=ON&amp;script=0" />
        </div>
    </noscript>

    <!-- Global site tag (gtag.js) - Google AdWords: 824992907 -->
    <script async="" src="https://gbtraderoptions.com/assets/js/js.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'AW-824992907');
    </script>

    <?php include('livechat-script.php'); ?>
</body>

</html>