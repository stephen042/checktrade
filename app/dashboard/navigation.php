<?php
include('session.php');
include('functions.php');
$user = mysqli_query($conn, "SELECT * FROM user_tb WHERE uemail = '$email'");
$userdetails = mysqli_fetch_array($user);
?>
<nav class="top-nav inner inner-new" style="margin-bottom: 50px;">

	<div class="top-bar" style="height:50px">
		<div class="head-row clearfix">
			<div class="float-left ">

				<div class="logosm">
					<a href="dashboard.php"><img src="assets/img/logo.png" alt="primeOption"></a>
				</div>
				<!--<a href="" class="top-bar-nav dinb"><i class="help-open"></i> <span>Support</span></a>-->

				<!-- <div class="ui item dropdown dropdown-call dinb" tabindex="0">
					<div class="top-bar-nav">
						<div class="phone-open"></div>
						<span>Call back</span>
					</div>
					<div class="menu transition hidden" tabindex="-1">
						<div class="item">
							<div class="phone-notice">Please input your phone number with<br>country code and we will immediately contact you.</div>
							<div>+<input class="call-input" placeholder="phone" type="text" maxlength="20" force-integer="" id="callback" style="width:200px"><button class="button ui green-bm" id="call_btn" onClick="callBack()">Call back</button></div>
						</div>
					</div>
				</div> -->

				<!-- <a href="tel:  " ng-show="geo != 'US'" class="top-phone dinb" aria-hidden="false"><i class="fa fa-phone"></i></a>
				<a href="tel:" ng-show="geo == 'US'" class="top-phone dinb ng-hide" aria-hidden="true"><i class="fa fa-phone"></i></a>
				<a target='blank' href='#' style="color:#fff" class="top-phone dinb"><i class="fa fa-whatsapp"></i></a> -->
				<div class="item">
					<!-- <span style="color:#0f0" class="blinkgreen">
						<i class="fa fa-check-circle" style="color: #0f0;"></i> online
					</span> -->
					<a class="ui button op link a-green-hover" href="logout.php">
						<i class="fa fa-power-off text-danger"></i> Exit
					</a>
					<span style="color:#0f0" class="blinkgreen">
						<!--<i class="fa fa-money" style="color: #0f0;"></i> -->
						Net Bal:<?php echo '$'.$withdral_pending. '.00'; ?>
					</span>
						
				</div>
			</div>

			<!-- <span class="menu-toggle float-right "><i></i></span> -->

			<div class="float-right nav smcapy-nav">

				<div class="ui item lang pointing dropdown" tabindex="0">
					<!-- <input type="hidden" name="lang">
					<div class="default text">
						<div id="google_translate_element" class="google-trans"></div>
						<script type="text/javascript">
							function googleTranslateElementInit() {
								new google.translate.TranslateElement({
									pageLanguage: 'en',
									layout: google.translate.TranslateElement.InlineLayout.SIMPLE
								}, 'google_translate_element');
							}
						</script>
						<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					</div>
					<i class="dropdown icon"></i> -->

				</div>


				<!-- <div class="item"><a class="ui button op link a-green-hover" href="logout.php"><i class="fa fa-power-off"></i> Exit</a></div> -->
				<div class="item"><a class="ui button op nobold" style="background:#2597C7" href="acct-funding.php"><i class="fa fa-money"></i> Account Funding</a></div>
				<div class="item"><a class="ui button op nobold" style="background:#33CC33" href="acct-funding.php"><i class="fa fa-money"></i> Live Account <?php echo $acct_amt2. '.00 USD'; ?></a></div>
			</div>

		</div>
	</div>

	<!--  -->
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2A3040;">
		<button style="background-color: #192E65;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">


			<ul class="navbar-nav mx-3" style="font-size: larger;">
				<li class="nav-item active mx-1 py-2">
					<a href="dashboard.php" style="color: white;"><i class="fa fa-dashboard"></i> Dashboard</a>
				</li>
				<!-- <li class="nav-item active mx-1 py-2">
					<a style="color: white;" href="../contact.html" target="_blank"><i class="fa fa-support"></i> Support</a>
				</li> -->
				<!-- <li class="nav-item active mx-1 py-2">
			<a style="color: white;" href="acct-funding-sub.php" target="_blank"><i class="fa fa-money"></i> Subscriptions Funding</a>
		</li> -->

				<li class="nav-item dropright">
					<a style="color: white;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-book"></i> Features
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" target="_blank" href="chart.php"><i class="fa fa-money"></i> chart tools </a>
						<a class="dropdown-item" target="_blank" href="technical-analysis.php"><i class="fa fa-money"></i> Technical Analysis</a>
						<a class="dropdown-item" target="_blank" href="fundamental-analysis.php"><i class="fa fa-money"></i> Fundamental Analysis</a>
						<!-- <div class="dropdown-divider"></div> -->
						<a class="dropdown-item" target="_blank" href="calendar.php"><i class="fa fa-money"></i> Calendar</a>
						<!-- <a class="dropdown-item" href="#">Something else here</a> -->
					</div>
				</li>

				<li class="nav-item dropright">
					<a style="color: white;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-money"></i> Account
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="acct-funding.php"><i class="fa fa-money"></i> Funding Account </a>
						<a class="dropdown-item" href="user-withdrawal.php"><i class="fa fa-money"></i> Withdrawals</a>
						<!-- <div class="dropdown-divider"></div>
			<a class="dropdown-item" href="acct-funding-sub.php"><i class="fa fa-money"></i> Subscription Funding</a> -->
						<!-- <a class="dropdown-item" href="#">Something else here</a> -->
						<!-- </div> -->
				</li>
				<li class="nav-item dropright">
					<a style="color: white;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-list"></i> Statements
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="history.php"><i class="fa fa-history"></i> Transactions History</a>
						<a class="dropdown-item" href="trade-history.php"><i class="fa fa-area-chart"></i> Trading History</a>
						<a class="dropdown-item" href="earning.php"><i class="fa fa-area-chart"></i> Earning History</a>
						<a class="dropdown-item" href="referral.php"><i class="fa fa-area-chart"></i> Referral History</a>
					</div>
				</li>
				<li class="nav-item dropright">
					<a style="color: white;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user"></i> Subscriptions
					</a>
					<div class="dropdown-menu">
						<!-- <a class="dropdown-item" href="ai-trade-plans.php"><i class="fa fa-money"></i> Plans</a> -->
						<a class="dropdown-item" href="status-plans.php"><i class="fa fa-money"></i> Trading Plans</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="signal-payment"><i class="fa fa-money"></i> Funds Transfer</a>
					</div>
				</li>
				<li class="nav-item dropright">
					<a style="color: white;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-cogs"></i> Settings
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="personal-data.php"><i class="fa fa-user"></i> Personal Data</a>
						<a class="dropdown-item" href="security.php"><i class="fa fa-lock"></i> Security Settings</a>
					</div>
				</li>

			</ul>

		</div>
	</nav>
	<!--  -->

	<div class="top-line clearfix" style="display: none;">
		<div class="row-30">
			<ul class="icon-nav">
				<li class="active"><a target="_blank" title="Charting tools" class="technic" href="chart.php" style="color:#FFFFFF"><i class="fa fa-bar-chart"></i></a></li>
				<li class="active"><a title="Fundamental analysis" class="fundament" href="fundamental-analysis.php" target="_blank" style="color:#FFFFFF"><i class="fa fa-pie-chart"></i></a></li>

				<li class="active"><a title="News" class="expert" href="news.php" target="_blank" style="color:#FFFFFF"><i class="fa fa-tv"></i></a></li>
				<li class="active"><a title="Technical Analysis" class="ideas" href="technical-analysis.php" target="_blank" style="color:#FFFFFF"><i class="fa fa-signal"></i></a></li>
				<li class="active"><a title="Economic calendar" class="calendar" href="calendar.php" target="_blank" style="color:#FFFFFF"><i class="fa fa-calendar"></i></a></li>


			</ul>
		</div>

		<!-- <div class="row-30 ">
			<div class="navsm text-xs-right">
				<div class="ui item top-drop-in-css">
					<a href="dashboard.php"><i class="fa fa-dashboard"></i> Trading</a>
				</div>
				<div class="ui item top-drop-in-css">
					<a href="javascript:;"><i class="fa fa-money"></i> Account</a>
					<div class="menu">
						<div class="item"><a href="acct-funding.php"><i class="fa fa-money"></i> Funding Account </a></div>
						<div class="item"><a href="user-withdrawal.php"><i class="fa fa-money"></i> Withdrawals</a></div>

					</div>
				</div>
				<div class="ui item top-drop-in-css">
					<a href="javascript:;"><i class="fa fa-list"></i> Statements</a>
					<div class="menu">
						<div class="item"><a href="history.php"><i class="fa fa-history"></i> Transactions History</a></div>
						<div class="item"><a href="trade-history.php"><i class="fa fa-area-chart"></i> Trading History</a></div>
						<div class="item"><a href="earning.php"><i class="fa fa-area-chart"></i> Earning History</a></div>
						<div class="item"><a href="referral.php"><i class="fa fa-area-chart"></i> Referral History</a></div>
					</div>
				</div>
				<div class="ui item top-drop-in-css">
					<a href="javascript:;"><i class="fa fa-cogs"></i> Settings</a>
					<div class="menu">
						<div class="item"><a href="personal-data.php"><i class="fa fa-user"></i> Personal Data</a></div>
						<div class="item"><a href="security.php"><i class="fa fa-lock"></i> Security Settings</a></div>
					</div>
				</div>
				<div class="ui item top-drop-in-css">
					<a href="../contact.php" target="_blank"><i class="fa fa-support"></i> Support</a>
				</div>
			</div>
		</div> -->

		<div class="time row-30 top-line-last-row-max">
			<div class="right">
				<a href="javascript:void(Tawk_API.toggle())" style="color:#FFFFFF">
					<i class="fa fa-comment"></i>
				</a>
			</div>
		</div>
	</div>
</nav>