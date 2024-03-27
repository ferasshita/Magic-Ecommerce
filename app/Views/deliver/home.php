<!DOCTYPE html>
<html class="<?php $this->load->view("includes/mode"); ?>" translate="no" lang="en">
<head>
	<?php $this->load->view("includes/head_info", $data); ?>
</head>
<body class="<?php $this->load->view("includes/mode.php"); ?> no-sidebar <?php echo langs('html_dir'); ?> theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php $this->load->view("includes/navbar_main.php", $data); ?>
	<!-- /navbar -->
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content-height">
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="mr-auto">
							<h3 class="page-title"><strong><?php echo langs('orders'); ?></strong></h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Orders</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-header">
						<h4><?php echo langs('search'); ?></h4>
					</div>
					<div class="box-body">
						<div class="app-menu cart-app-menu">
							<div class="search-bx-sear mx-5">
								<div class="input-group">
									<input type="search" placeholder="<?php echo langs('search'); ?>.." id="mU_search" onkeypress="fetchPosts_DB('deliver')" class="form-control" aria-label="Search" aria-describedby="button-addon2">
									<div class="input-group-append">
										<button class="btn" onclick="fetchPosts_DB('deliver')" type="button" id="button-addon3"><img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/search.svg" class="img-fluid" alt="search"></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<input type="hidden" id="fetchpost_db" value="deliver">
				<div id="FetchingPostsDiv"></div>
				<!-- post end -->
				<div class="post loading-info" id="LoadingPostsDiv" style="border-radius: 10px">
					<div class="animated-background">
						<div class="background-masker header-top"></div>
						<div class="background-masker header-left"></div>
						<div class="background-masker header-right"></div>
						<div class="background-masker header-bottom"></div>
						<div class="background-masker subheader-left"></div>
						<div class="background-masker subheader-right"></div>
						<div class="background-masker subheader-bottom"></div>
						<div class="background-masker content-top"></div>
						<div class="background-masker content-first-end"></div>
						<div class="background-masker content-second-line"></div>
						<div class="background-masker content-second-end"></div>
						<div class="background-masker content-third-line"></div>
						<div class="background-masker content-third-end"></div>
					</div>
				</div>
				<!-- post load -->
				<div class="post  loading-info" id="NoMorePostsDiv" style="display: none;min-width: 99%;">
					<p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo langs('noMoreStories'); ?></p>
				</div>
				<div class="post loading-info" id="ErrorPosts" style="display: none;min-width: 99%;">
					<p class="alertRed">Some thing went wrong, Please try again later.</p>
				</div>
				<div class="post  loading-info" id="LoadMorePostsBtn" style="display: none;min-width: 99%;">
					<button class="btn btn-primary waves-effect" style="width: 100%" onClick="fetchPosts_DB('deliver')"><?php echo langs('load_more'); ?></button>
				</div>
				<input type="hidden" id="GetLimitOfPosts" value="0">
			</section>

		</div>
	</div>
	<!-- footer -->
	<?php $this->load->view("includes/footer", $data); ?>
	<!-- /footer -->
</div>
<!-- ./wrapper -->
<!-- endJS --><?php $this->load->view("includes/endJScodes", $data); ?><!-- /endJS -->
</body>
</html>
