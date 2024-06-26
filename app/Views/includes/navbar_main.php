<?php
$user_id = session('id', null);
$page_name = $page;
$title = $title; ?>
<header class="main-header">
	<div class="d-flex align-items-center logo-box pl-20">
		<?php if($_SESSION['account_type'] == "admin"){ ?>
		<a href="javascript:void(0)" class="waves-effect waves-light nav-link rounded d-none d-md-inline-block push-btn"
		   data-toggle="push-menu" role="button">
			<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/collapse.svg" class="img-fluid svg-icon"
				 alt="">
		</a>
	<?php } ?>
		<!-- Logo -->
		<a href="<?php echo base_url(); ?>" class="logo">
			<!-- logo-->
			<div class="logo-lg">
        <span class="light-logo"><b style="font-size:30px;"><?php echo project_name(); ?></b></span>
        <span class="dark-logo"><b style="font-size:30px;"><?php echo project_name(); ?></b></span>
			</div>
		</a>
	</div>
	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top pl-10">

		<!-- Sidebar toggle button-->
		<div class="app-menu">
			<ul class="header-megamenu nav">
				<?php if($_SESSION['account_type'] == "admin"){ ?>
				<li class="btn-group nav-item d-md-none">
					<a href="javascript:void(0)" class="waves-effect waves-light nav-link rounded push-btn"
					   data-toggle="push-menu" role="button">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/collapse.svg"
							 class="img-fluid svg-icon" alt="">
					</a>
				</li>
			<?php }?>
				<li class="btn-group nav-item">
					<a href="javascript:void(0)" data-provide="fullscreen"
					   class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/fullscreen.svg"
							 class="img-fluid svg-icon" alt="">
					</a>
				</li>
				<li class="btn-group nav-item">
					<a href="javascript:void(0)" class="waves-effect waves-light nav-link rounded" onclick="mode()" accesskey="m" data-toggle="dropdown"
					   title="mode">
						<span class="fa fa-adjust aw-nav img-fluid svg-icon"></span>
					</a>
				</li>

			</ul>
		</div>
		<!-- Button trigger modal -->
<?php if(isset($_SESSION['id'])){ ?>
		<div class="navbar-custom-menu r-side">
			<ul class="nav navbar-nav">
				<!-- User Account-->
				<li class="dropdown user user-menu">

					<a href="javascript:void(0)" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
					   title="User">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/user.svg"
							 class="rounded svg-icon" alt=""/>
					</a>
					<ul class="dropdown-menu animated flipInX">
						<!-- User image -->
						<li class="user-header bg-img"
							style="background-image: url(<?php echo base_url(); ?>Asset/imgs/user-info.jpg)"
							data-overlay="3">
							<div class="flexbox align-self-center">
								<img loading="lazy" src="<?php echo base_url(); ?>Asset/imgs/Currency_img/2705.png"
									 class="float-left rounded-circle" alt="User">
								<h4 class="user-name align-self-center">
									<p><span><?php echo $_SESSION['username']; ?></span><br>
										<small><?php echo $_SESSION['email']; ?></small>
								</h4>
							</div>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<a class="dropdown-item" href="<?php echo base_url(); ?>Setting"><i
										class="fa fa-cog"></i><?php echo langs('general'); ?></a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url(); ?>Setting?pid=language"><i
										class="fa fa-language"></i> <?php echo langs('language'); ?></a>
							<div class='dropdown-divider'></div>
							<a class="dropdown-item" href="<?php echo base_url(); ?>deliver/report"><i
										class="fa fa-file"></i> <?php echo langs('reports'); ?></a>
							<div class='dropdown-divider'></div>
							<a class="dropdown-item" accesskey="m" href="javascript:void(0)" onclick="mode()"><i
										class="fa fa-adjust"></i> <?php echo langs('mode'); ?></a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" style="color:red;"
							  accesskey="l" onclick="return confirm('<?php echo langs('are_logout'); ?>')"
							   href="<?php echo base_url(); ?>Account/logout"><i
										class="ion-log-out"></i> <?php echo langs('logout'); ?></a>

						</li>
					</ul>
				</li>

			</ul>
		</div>
		<?php } ?>
	</nav>
</header>
<?php if($_SESSION['account_type'] == "admin"){ ?>
<aside id="sidebar" class="main-sidebar">
	<!-- sidebar-->
	<section class="sidebar">
		<!-- sidebar menu-->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header"><?php echo langs('pages'); ?></li>

			<li class="treeview">
								<a href="#">
								<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/user.svg" class="svg-icon" alt="">
								<span><?php echo langs('costumers'); ?></span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
								</span>
								</a>

								<ul class="treeview-menu">

								<li>
									<a href="<?php echo base_url(); ?>costumers/costumers">
									<i class="ti-more"></i>
									<span><?php echo langs('costumers'); ?></span>
									</a>
								</li>

								<li>
									<a href="<?php echo base_url(); ?>costumers/delivery">
									<i class="ti-more"></i>
									<span><?php echo langs('deliveries'); ?></span>
									</a>
								</li>

								<li>
									<a href="<?php echo base_url(); ?>costumers/orders">
									<i class="ti-more"></i>
									<span><?php echo langs('orders'); ?></span>
									</a>
								</li>

								<li>
									<a href="<?php echo base_url(); ?>costumers/pos">
									<i class="ti-more"></i>
									<span><?php echo langs('POS'); ?></span>
									</a>
								</li>

								</ul>
							</li>

							<li class="treeview">
											  <a href="#">
												<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/sidebar-menu/invoice.svg" class="svg-icon" alt="">
												<span><?php echo langs('products'); ?></span>
												<span class="pull-right-container">
												  <i class="fa fa-angle-right pull-right"></i>
												</span>
											  </a>

											  <ul class="treeview-menu">

												<li>
												  <a href="<?php echo base_url(); ?>products/index">
													<i class="ti-more"></i>
													<span><?php echo langs('products'); ?></span>
												  </a>
												</li>

												<li>
													<a href="<?php echo base_url(); ?>products/collections">
													<i class="ti-more"></i>
													<span><?php echo langs('collections'); ?></span>
													</a>
												</li>

												<li>
													<a href="<?php echo base_url(); ?>products/inventory">
													<i class="ti-more"></i>
													<span><?php echo langs('inventory'); ?></span>
													</a>
												</li>

												<li>
													<a href="<?php echo base_url(); ?>discount">
													<i class="ti-more"></i>
													<span><?php echo langs('discount'); ?></span>
													</a>
												</li>

												<li>
													<a href="<?php echo base_url(); ?>products/purchase">
													<i class="ti-more"></i>
													<span><?php echo langs('purchase'); ?></span>
													</a>
												</li>


											  </ul>
											</li>

							<li class="treeview">
												<a href="#">
												<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/chart.svg" class="svg-icon" alt="">
												<span><?php echo langs('reports'); ?></span>
												<span class="pull-right-container">
													<i class="fa fa-angle-right pull-right"></i>
												</span>
												</a>

												<ul class="treeview-menu">

												<li>
													<a href="<?php echo base_url(); ?>reports/analytics">
													<i class="ti-more"></i>
													<span><?php echo langs('analytics'); ?></span>
													</a>
												</li>

												</ul>
											</li>

											<li class="header"><?php echo langs('pages'); ?></li>
											<li>
												<a href="<?php echo base_url(); ?>dashboard/blog">
													<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/sidebar-menu/icons.svg"
														 class="svg-icon" alt="">
													<span><?php echo langs('blog'); ?></span>
												</a>
											</li>
<?php
$htmlFiles = glob("src/*.html");

if ($htmlFiles) {
  // Extract filenames with extension
  $fileNames = array_map(function($file) {
    return pathinfo($file, PATHINFO_BASENAME);
  }, $htmlFiles);

  // Display comma-separated list with extension
  $file_display = implode(",", $fileNames);
} else {
		$filename = "src/page.html";

$handle = fopen($filename, 'w');

fwrite($handle, '');

fclose($handle);
$file_display="page.html";
}
?>
											<li>
												<a href="<?php echo base_url(); ?>editor/edit?folder=&page=<?php echo $file_display; ?>">
													<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/sidebar-menu/apps.svg"
														 class="svg-icon" alt="">
													<span><?php echo langs('editor'); ?></span>
												</a>
											</li>
											<li>
												<a href="<?php echo base_url(); ?>control_panel">
													<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/sidebar-menu/extensions.svg"
														 class="svg-icon" alt="">
													<span><?php echo langs('control_panel'); ?></span>
												</a>
											</li>
											<li>
												<a href="<?php echo base_url(); ?>setting">
													<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/settings.svg"
														 class="svg-icon" alt="">
													<span><?php echo langs('setting'); ?></span>
												</a>
											</li>


			<li class="header"><?php echo langs('logout'); ?></li>
			<li>
				<a onclick="return confirm('<?php echo langs('confirm_logout'); ?>')" accesskey="l"
				   href="<?php echo base_url(); ?>Account/logout">
					<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/sidebar-menu/logout.svg"
						 class="svg-icon" alt="">
					<span><?php echo langs('logout'); ?></span>
				</a>
			</li>

		</ul>
	</section>
</aside>
<?php } ?>
<div class="control-sidebar-bg"></div>
<!-- Left side column. contains the logo and sidebar -->
