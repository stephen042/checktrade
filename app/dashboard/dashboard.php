													<?php require_once('conn.php');
													include('session.php');
													include('config.php');
													// include('about.php');
													include('functions.php');
													if ($doc_aprrove != "Yes") {
														echo "<script>alert(' Please verify your account first')</script>";
														echo "<script>window.open('personal-data.php','_self')</script>";
													}
													$newm = '';
													$user = mysqli_query($conn, "SELECT * FROM user_tb WHERE uemail = '$email'");
													$userdetails = mysqli_fetch_array($user);
													?>


													<!DOCTYPE html>
													<html style="">

													<head>
														<meta http-equiv="content-type" content="text/html; charset=UTF-8">
														<meta charset="utf-8">
														<meta http-equiv="X-UA-Compatible" content="IE=edge">
														<title><?= APP_NAME ?> Main </title>
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
															<script>
																var balance = <?php echo $trade_amt2 ?>
																var newm2 = document.getElementById("profit").value = "+" + pip.toFixed(2);
															</script>

															<!-- <div class="root-content"> -->
															<div class="push-trading" style="padding:10px;">



																<section class="row" style="display: block;margin:6px;">

																	<div class="col col-xm-12 col-md-12 m-1 alert alert-secondary  text-light" style="height: 5rem;background-color:black;border-left: solid 3px #6175C4;border-top: 6px solid white;border-right: solid 1px white;border-bottom: 6px solid white">
																		<p style="font-size:12px;margin:0; color:#F4A733;">AVAILABLE BALANCE</p>
																		<span>$ <?php  $acct_amt = $acct_amt != 0 ? $acct_amt : 0;  echo $acct_amt ?></span>
																	</div>

																	<div class="col col-xm-12 col-md-12 m-1 alert alert-secondary  text-light" style="height: 5rem;background-color:black;border-left: solid 3px #EBBA59;border-top: 6px solid white;border-right: solid 1px white;border-bottom: 6px solid white">
																		<p style="font-size:12px;margin:0;color:#F4A733;">BTC EQUIVALENT</p>
																		<span><?php $acct_amt = $acct_amt != 0 ? $acct_amt : 0; echo file_get_contents("https://blockchain.info/tobtc?currency=USD&value=$acct_amt") ?></span>
																	</div>

																	<div class="col col-xm-12 col-md-12 m-1 alert alert-secondary  text-light" style="height: 5rem;background-color:black;border-left: solid 3px #4DB990;border-top: 6px solid white;border-right: solid 1px white;border-bottom: 6px solid white">
																		<p style="font-size:12px;margin:0;color:#4DB990;">INVESTED</p>
																		<span>$
																			<?php $total_invested = $total_invested != 0 ? $total_invested : 0;
																				echo $total_invested ?>
																		</span>
																	</div>

																	<div class="col col-xm-12 col-md-12 m-1 alert alert-secondary  text-light" style="height: 5rem;background-color:black;border-left: solid 3px #419CB8;border-top: 6px solid white;border-right: solid 1px white;border-bottom: 6px solid white">
																		<p style="font-size:12px;margin:0;color:#419CB8;">ACCOUNT TYPE</p>
																		<span>
																			Active
																		</span>

																	</div>

																	<div class="col col-xm-12 col-md-12 m-1 alert alert-secondary text-light border-warning" style="height: 8rem;background-color:#2F333E;">
																		<p>
																			Trade In Progress
																		</p>
																		<p class="text-warning">
																			<?=$pro_bar?>% completed
																		</p>
																		<div class="progress mt-1">
																			<div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width:<?=$pro_bar?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
																			</div>
																		</div>
																	</div>

																</section>
																<hr>
																<section class="row">
																	<div class="col col-md-12" style="height: 30rem;">
																		<!-- TradingView Widget BEGIN -->
																		<div class="tradingview-widget-container">
																			<div class="tradingview-widget-container__widget"></div>
																			<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
																				{
																					"width": "100%",
																					"height": "100%",
																					"defaultColumn": "overview",
																					"defaultScreen": "general",
																					"market": "forex",
																					"showToolbar": true,
																					"colorTheme": "dark",
																					"locale": "en"
																				}
																			</script>
																		</div>
																		<!-- TradingView Widget END -->
																	</div>
																</section>


															</div>

															<!-- </div> -->
															<hr>
														</div>
														<?php include('footer.php') ?>
														<script type="text/javascript" src="validation.min.js"></script>
														<script type="text/javascript" src="trade_script.js"></script>
														<script type="text/javascript" src="trade_script2.js"></script>
														<script src="js/sweet-alert.js"></script>
													</body>

													</html>