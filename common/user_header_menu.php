<header class="main-header">
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Logo -->
		<a href="index.php" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><b>A</b>LT</span>
			<!-- logo for regular state and mobile devices --><span class="logo-lg"><img src="assets/images/AAM.PNG" alt="logo">Alliance for Audited Media</span> </a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Messages: style can be found in dropdown.less-->
				<li class="messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">preferences</a> </li>
				<!-- Notifications: style can be found in dropdown.less -->
				<li class="notifications-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">messages</a> </li>
				<!-- Tasks: style can be found in dropdown.less -->
				<li class="dropdown tasks-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">help<span class="caret"></span></button></a>
					<ul class="dropdown-menu">
						<li class="header">Workspace Help</li>
						<li>
							<ul class="menu">
								<li>
									<a href="#">About Workspace</a> 
								</li>
	
							</ul>
						</li>
					</ul>
				</li>
				<!-- User Account: style can be found in dropdown.less -->
				<li class="user user-menu"> <a href="logout.php">logout</a> </li>
				<!-- Control Sidebar Toggle Button -->
				<li> <a href="#">welcome <?php echo $_SESSION['username']; ?></a> </li>
			</ul>
		</div>
	</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="treeview">
				<a href="#"> <i class="fa fa-binoculars"></i> <span>search templates</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#"> <i class="fa fa-files-o"></i> <span>drafts</span> <span>(2)</span> </a>
			</li>
			<li <?php if (isset($current_user_page)) { ?> class="treeview active" <?php  } ?>>								
				<a href="dashboard.php"> <i class="fa fa-user"></i> <span><?php echo $_SESSION['username']; ?></span><span>(<?php echo $cntloggedUserCards; ?>)</span>  </a>
			</li>
			<li <?php if (isset($proof_admin_page)) { ?> class="treeview active" <?php  } ?>>
				<a href="proofadmin.php"> <i class="fa fa-user"></i> <span>Proof Admin</span> <span>(<?php echo $pdCount; ?>)</span> </a>
			</li>
			<li <?php if (isset($proof_reader_page)) { ?> class="treeview active" <?php  } ?>>
				<a href="proofreader.php"> <i class="fa fa-user"></i> <span>Proof Readers</span> <span>(<?php echo $prCount; ?>)</span> </a>
			</li>
			<li <?php if (isset($reviewer_page)) { ?> class="treeview active" <?php  } ?>>
				<a href="reviewercards.php"> <i class="fa fa-user"></i> <span>Reviewers</span> <span>(<?php echo $reviewerCount; ?>)</span> </a>
			</li>
			<?php 
				/**
				 * Code for displaying other users
				 */
				$users = App::getUsers();
				foreach ($users as $user) {
					if ($user['ID'] == $_SESSION['user_id']) {
						continue;
					}					
					//$userCounts = count(CardManager::userCardList($user['ID']));//sathish
					$userCounts = count(CardManager::anotherUserCardList($user['ID']));
					$cardsurl = 'usercards.php?user_id=' . $user['ID'];
					
			?>
			<li <?php if (isset($user_cards_page) && $user_cards_page == $user['ID']) { ?> class="treeview active" <?php  } ?>>
				<a href="<?php echo $cardsurl; ?>"> <i class="fa fa-binoculars"></i>
				<span><?php echo $user['USERNAME'] ?></span><span>(<?php echo $userCounts ?>)</span>
				</a>
			</li>			
			<?php
				}
			?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>