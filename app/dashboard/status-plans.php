<?php 
    include('config.php'); 
    include('session.php');
    if ($doc_aprrove != "Yes") {
        echo "<script>alert(' Please verify your account first')</script>";
        echo "<script>window.open('personal-data.php','_self')</script>";
    }
    // var_dump($signalFund); 

    if (isset($_POST['btn_verify'])) {

        $plan = $_POST['plan'];
        $amount = $_POST['price'];
        $duration = $_POST['duration'];
        $package = 'status upgrade';
        $u_id = $session_id;
        $u_email = $email;
        $package_type = '1';
        $date = date("M,d,Y h:i A");

        if ($acct_amt < $amount) {
            $err = 'Insufficient Balance Please deposit <br> <a href="acct-funding.php">Click here </a> To fund account';
        }else{
            $sql = "INSERT INTO sub_transactions (u_id, u_email,plan, duration, amount, package,package_type, date) VALUES ('$u_id','$u_email','$plan','$duration','$amount','$package','$package_type','$date')";
            $result = mysqli_query($conn, $sql);

            if ($result) {

                $msg = 'Your request has been submitted <br> Thanks For Choosing Us';
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
    <title> <?=APP_NAME?> | Plans  </title>
<meta name="description" content="            
    ">
<?php include('css.php');?>
<style>
.divider{
border-bottom: 1px dotted;
}
.blinking{
	animation:blinkingText 2s infinite;
}
@keyframes blinkingText{
	0%{		color: #f00;	}
	49%{	color: #600;	}
	50%{	color: #c00;	}
	99%{	color:#e00;	}
	100%{	color: #f00;	}
}
.blinkgreen{
	animation:blinkgreenText 2s infinite;
}
@keyframes blinkgreenText{
	0%{		color: #0f0;	}
	49%{	color: #060;	}
	50%{	color: #0c0;	}
	99%{	color:#0e0;	}
	100%{	color: #0f0;	}
}
</style>
<SCRIPT type="text/javascript">
				var tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
				var tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

				function GetClock(){
				 tzOffset = 0;//set this to the number of hours offset from UTC

				 d=new Date();
				 dx=d.toGMTString();
				dx=dx.substr(0,dx.length -3);
				d.setTime(Date.parse(dx))
				d.setHours(d.getHours()+tzOffset);
				var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate();
				var nhour=d.getHours(),nmin=d.getMinutes(),ap,nsec=d.getSeconds();
				
				if(nhour<=9) nhour="0"+nhour;
				if(nmin<=9) nmin="0"+nmin;
				if(nsec<=9) nsec="0"+nsec;

				document.getElementById('clockbox').innerHTML="<i class='fa fa-clock-o'></i>&nbsp;"+nhour+":"+nmin+":"+nsec;
				var nminutes = Number(nmin) + 01;
				if(nminutes<=9) nminutes="0"+nminutes;
				time = "<i class='fa fa-clock-o'></i>&nbsp;"+nhour+":"+nminutes;
				
				}

				window.onload=function(){
				GetClock();
				setInterval(GetClock,1000);
				document.getElementById('time').innerHTML=time;
				}
				</SCRIPT>
</head>
<body class="pushable  dimmable scrolling">
<?php include('sider-bar.php');?>

    <div class="pusher" aria-hidden="false">
<?php 
include('navigation.php');
?>

<div class="container">
<br>
    <div>
        <h2>
            Trading Plans | 
        </h2>
    </div>
    <hr style="border: 3px solid grey;">
    <?php if (!empty($msg)) { ?>
        <div class="alert alert-success alert-dismissible fade show" style="width: 60%;" role="alert">
            <?=$msg?>
        </div>
    <?php };  ?>
    <?php if (!empty($err)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" style="width: 60%;" role="alert">
            <?=$err?>
        </div>
    <?php };  ?>
    <div class="row"> 
<?php 
    $status = mysqli_query($conn," SELECT * FROM status_plan ORDER BY id DESC ");
    if (!empty($status)) {
    while ($data = mysqli_fetch_assoc($status)) {
?>
    
        <div class="col-md-4 col-sm-6">
            <hr style="border: 1px solid green;">
            <div class="card">
                <form method="post"> 
                <div class="card-header">
                   <h5><?=ucwords($data['plan'])?></h5>
                   <input type="hidden" name="plan" value="<?=$data['plan']?>"> 
                </div>
                <div class="card-body" style="font-size: large;">
                    <p class="card-title">Price : <?=$data['price']?> USD</p>
                    <input type="hidden" name="price" value="<?=$data['price']?>"> 

                    <p class="card-title">Duration : <?=$data['duration']?></p>
                    <input type="hidden" name="duration" value="<?=$data['duration']?>"> 

                    <input type="hidden" name="plan_id" value="<?=$data['id']?>"> 

                    <button name="btn_verify" class="btn btn-primary"> Purchase </button>
                </div>
                </form>
            </div>
        </div>
    
<?php  }  
}else {
    echo "<h1>No Plan Yet Available</h1>";
}
?>
    </div>
</div>
<hr style="border: 2px solid grey;">
<section class="content-box history-min">
    <div class="row">
        <div class="table" style="overflow-y:auto;">
         										
            <table class="" style=" min-width:80%;">
                <tbody>
                <tr>
                    <td>S/N</td>
                    <td>Date</td>
                    <td>Plan</td>
					<td>Amount</td>
					<td>Duration</td>                    
                </tr>
                <?php 
                $data = mysqli_query($conn," SELECT * FROM sub_transactions WHERE u_id='$session_id' ORDER BY id DESC ");
                $counter = 0;
                if (!empty($data)) {
                   while ($status_data = mysqli_fetch_assoc($data)) {
                    $counter++;
                ?>
				<tr class="del12">
                    <td><?php echo $counter?></td>								
                    <td><?php echo $status_data['date'] ?></td>									   
                    <td><?php echo $status_data['plan']?></td>
                    <td><?php echo $status_data['amount']?></td>
                    <td><?php echo $status_data['duration']?> </td>
                </tr>  
                <?php 
                  } 
                }else {
                ?> 
                <tr class="del12">
                    <td></td>								
                    <td></td>									   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> 
                <?php 
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</section>
<br>
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
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-76636433-1', 'auto');
    ga('send', 'pageview');

</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">

    if(bowser.safari || bowser.mac){
        // disable for this
    }else{
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter38379630 = new Ya.Metrika({
                        id:38379630,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }

            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    }
</script>
<noscript aria-hidden="false"><div><img src="https://mc.yandex.ru/watch/38379630" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
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
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1057644682/?guid=ON&amp;script=0"/>
    </div>
</noscript>

<!-- Global site tag (gtag.js) - Google AdWords: 824992907 -->
<script async="" src="https://gbtraderoptions.com/assets/js/js.js"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-824992907');
</script>
<?php include('livechat-script.php');?>
	</body>
    </html>