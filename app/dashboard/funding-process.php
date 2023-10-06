<?php
require_once('conn.php');
include('session.php');
include('config.php');
include('functions.php');

$amt_message = "";
$success_message = "";
$error_message = "";
$spend_amt = "";
if (!isset($_SESSION['trnc']) || (trim($_SESSION['trnc']) == '')) {
    @header("location: acct-funding.php");
    exit();
}
$trac_code = $_SESSION['trnc'];
$method = $_SESSION['method'];
$spend_amt = $_SESSION['spend_amt'];

$now_method = "Deposit using " . $method;

if ($method == "Bitcoin") {
    $flag = "<img src='../assets/btc.png'/>";
    $show = '<div class="center-button"> 
													   <div class="line">
													   <p><span>Note: Once payment is complete, receipt of payment should be sent to <a href="mailto:support@primeoptionpro.online">support@primeoptionpro.online</a> for confirmation and your trading account will be funded after confirmation is complete.
													   </div>
														<div class="line">
														<label>Official Bitcoin Wallet Address</label>
														<input type="text" name="wallet" value="bc1qs6e9t7v7zhq56aehnaz92jyayl5xytwzdme6su" readonly="" id="mywallet" />
														</div>
														<div class="line">
														<button class="ui button primal" onclick="myWallet()" id="copy_btn">copy wallet</button></div>
														<div class="line">
														<p>Or scan the QR Code below</p>
                                                        <img src="https://chart.googleapis.com/chart?chs=225x225&chld=L|2&cht=qr&chl=bc1qs6e9t7v7zhq56aehnaz92jyayl5xytwzdme6su" alt="btc bar-code" class="img-fluid">
														</div>
													</div>';
}
?>


<!DOCTYPE html>
<html style="">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?= APP_NAME ?> Tradings Account Funding </title>
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
    <SCRIPT type="text/javascript">
        var tday = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        var tmonth = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        function GetClock() {
            tzOffset = 0; //set this to the number of hours offset from UTC

            d = new Date();
            dx = d.toGMTString();
            dx = dx.substr(0, dx.length - 3);
            d.setTime(Date.parse(dx))
            d.setHours(d.getHours() + tzOffset);
            var nday = d.getDay(),
                nmonth = d.getMonth(),
                ndate = d.getDate();
            var nhour = d.getHours(),
                nmin = d.getMinutes(),
                ap, nsec = d.getSeconds();

            if (nhour <= 9) nhour = "0" + nhour;
            if (nmin <= 9) nmin = "0" + nmin;
            if (nsec <= 9) nsec = "0" + nsec;

            document.getElementById('clockbox').innerHTML = "<i class='fa fa-clock-o'></i>&nbsp;" + nhour + ":" + nmin + ":" + nsec;
            var nminutes = Number(nmin) + 01;
            if (nminutes <= 9) nminutes = "0" + nminutes;
            time = "<i class='fa fa-clock-o'></i>&nbsp;" + nhour + ":" + nminutes;

        }

        window.onload = function() {
            GetClock();
            setInterval(GetClock, 1000);
            document.getElementById('time').innerHTML = time;
        }
    </SCRIPT>
</head>

<body class="pushable  dimmable scrolling" style="">
    <?php include('sider-bar.php'); ?>

    <div class="pusher" aria-hidden="false">
        <?php
        include('navigation.php');
        ?>
        <div class="root-content">
            <div class="pusher push-trading">
                <div>
                    <div class="pusher pusher-min-400">
                        <section class="img-bg-section m-0 p-4">
                            <!-- <div class="top-info"> -->
                                <h2 class="title m-0 p-0">Account Funding Details </h2>
                            <!-- </div> -->
                        </section>
                        <div style="">
                            <section class="content-box">
                                <div class="row">
                                    <div class="account-funding">
                                        <div class="funding-method-wrap">

                                            <div aria-hidden="false" class="">
                                                <div class="pay-tabs-content">
                                                    <div class="ui bottom attached tab segment active">

                                                        <h2 class="title"><?php echo $now_method; ?></h2>
                                                        <div class="withdraw-form clearfix bitcoin-from ng-scope" ng-controller="PayBTC">
                                                            <div>
                                                                <div class="btc-amount" style="margin-bottom: 15px;">
                                                                    <div>
                                                                        <center><?php echo @$flag; ?></center>
                                                                        <span>Amount in base currency:</span>
                                                                        <b class="ui green inverted header"><?php echo $spend_amt . '.00' ?> USD</span></b>
                                                                    </div>



                                                                </div>

                                                                <?php echo $show; ?>
                                                                <div>
                                                                    <button type="button" class="btn btn-success btn-lg" onclick="alert('Your deposit Request is being processed'); window.location.href='acct-funding.php'">Done</button>
                                                                </div>
                                                                <div class="btc-info-bottom">
                                                                    <div class="bit-hd">How to buy Bitcoins using localbitcoins.com</div>
                                                                    <div class="pf"><a href="https://localbitcoins.com/guides/how-to-buy-bitcoins" target="_blank">Text tutorial</a></div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function myWallet() {
                var copyText = document.getElementById("mywallet");
                copyText.select();
                document.execCommand("copy");
                document.getElementById("copy_btn").innerHTML = "copied";
            }



            function isNumber(evt) {
                var iKeyCode = (evt.which) ? evt.which : evt.keyCode
                if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                    return false;

                return true;
            }
        </script>
        <?php
        include('footer.php');
        ?>
    </div>
    <script type="text/javascript" async="" src="https://gbtraderoptions.com/assets/js/conversion_async.js"></script>
    <script type="text/javascript" async="" src="https://gbtraderoptions.com/assets/js/watch.js"></script>
    <script async="" src="https://gbtraderoptions.com/assets/js/analytics.js"></script>
    <script src="https://gbtraderoptions.com/dashboard/assets/inner.js"></script>
    <script src="https://gbtraderoptions.com/assets/js/vendor.js"></script>
    <script src="https://gbtraderoptions.com/dashboard/assets/app.js"></script>

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


</body>

</html>