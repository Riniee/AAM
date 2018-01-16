<?php
	require 'App.php';
	require 'head.php';
	if (!isset($_SESSION['user_id'])) {
		header('Location:login.php');
	}
?>

<body class="swatch2">
	<div class="container homenav">
		<div class="row">
			<div class="col-sm-2 col-md-2">
				<h4 class="swatch6">AAM</h4>
			</div>
			<div class="col-sm-8 col-md-8">
				<ul class=" pull-right">
					<li class="upper-links"><a class="links" href="">Preferences</a></li>
					<li class="upper-links"><a class="links" href="">Messages</a></li>
					<li class="upper-links dropdown"><a class="links" href="">Help</a>
						<ul class="dropdown-menu">
							<li class="profile-li"><a class="profile-links" href="">Link</a></li>
						</ul>
					</li>
					<li class="upper-links"><a class="links" href="logout.php">Logout</a></li>
				</ul>
			</div>
			<div class="col-sm-2 col-md-2">
				<h5 class="m1 swatch6">welcome <?php echo ucfirst($_SESSION['username']); ?></h5>
			</div>
		</div>
	</div>
	<!--headersection-->
	<header>
	<section>
		<h5 class="swatch6">Good Morning AAM staff</h5>
		<div class="container section-margin">
			<div class="row">
				<div class="col-sm-4 col-md-4 borderright">
					<a href=""><div class="pro-img"></div>
					<h5 class="swatch6 textcenter">Start Process</h5></a>
					<h5 class="swatch6 textcenter">Select business processes to Start</h5>
					<h4 class="swatch6">Learn about</h4>
					<a href=""><p class="swatch7">Selecting process to start</p></a>
					<a href=""><p class="swatch7">Adding notes and Attachments</p></a>
					<a href=""><p class="swatch7">Setting favorites</p></a>
					<a href=""><p class="swatch7">Show more...</p></a>
				</div>
				<div class="col-sm-4 col-md-4 borderright">
					<a href="dashboard.php"><div class="todo-img"></div>
					<h5 class="swatch6 textcenter">To Do</h5></a>
					<h5 class="swatch6 textcenter">Select assingd or shared tasks to complete</h5>
					<h4 class="swatch6">Learn about</h4>
					<a href=""><p class="swatch7">Completing tasks</p></a>
					<a href=""><p class="swatch7">Working with tasks from group and shared queues</p></a>
					<a href=""><p class="swatch7">About deadlines and reminders</p></a>
					<a href=""><p class="swatch7">Show more...</p></a>
				</div>
				<div class="col-sm-4 col-md-4">
					<a href=""><div class="track-img"></div>
					<h5 class="swatch6 textcenter">Tracking</h5></a>
					<h5 class="swatch6 textcenter">Review tasks or processes that you started or participated in.</h5>
					<h4 class="swatch6">Learn about</h4>
					<a href=""><p class="swatch7">Tracking processes</p></a>
					<a href=""><p class="swatch7">Searching for processes</p></a>
					<a href=""><p class="swatch7">Viewing Attachments</p></a>
					<a href=""><p class="swatch7">Show more...</p></a>
				</div>
			</div>
		</div>
	</section></header>
	<script type="text/javascript" src="libraries/jquery.js"></script>
	<script type="text/javascript" src="libraries/bootstrap.js"></script>
	<script type="text/javascript" src="libraries/custom.js"></script>
</body>

</html>