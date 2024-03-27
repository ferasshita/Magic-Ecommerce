<!DOCTYPE html>
<html class="<?php $this->load->view("includes/mode"); ?>" translate="no" lang="en">
<head>
	<?php $this->load->view("includes/head_info", $data); ?>
</head>
<body class="<?php $this->load->view("includes/mode.php"); ?> no-sidebar <?php echo langs('html_dir'); ?> theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php $this->load->view("includes/navbar_back.php", $data); ?>
	<!-- /navbar -->
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper content-wrapper-50">
		<div class="container-full">
			<!-- Main content -->
			<section class="content-height">
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="mr-auto">
							<h3 class="page-title"><strong><?php echo langs('reports'); ?></strong></h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page"><?php echo langs('reports'); ?></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<?php
				global $sum_price;
				$sid=$_SESSION['id'];
				$uisql = "SELECT value FROM payment WHERE user_id= '$sid'";
				$udata=$this->comman_model->get_all_data_by_query($uisql);
				foreach ($udata as $postsfetchx) {
					$payment_value += $postsfetchx['value'];
				}
				$uisql = "SELECT * FROM orders WHERE accept='$sid' AND shop_finish!='0'";
				$udata=$this->comman_model->get_all_data_by_query($uisql);
				foreach ($udata as $postsfetchx) {
					$order_id = $postsfetchx['id'];
					$deliver_bill += $postsfetchx['deliver_bill'];
					$shop_bill += $postsfetchx['shop_bill'];
				}
				?>
				<div class="box">
					<div class="box-body">
						<div class="row">

							<div class="col-xl-3 col-md-6 col-12 ">
								<div class="box box-inverse box-success">
									<div class="box-body">
										<div class="flexbox">
											<h5><?php echo langs('dept'); ?></h5>
										</div>

										<div class="text-center my-2">
											<div class="font-size-60"><?php echo $shop_bill-$payment_value; ?><?php echo langs('LYD'); ?></div>
											<span><?php echo langs('dept'); ?></span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-3 col-md-6 col-12 ">
								<div class="box box-inverse box-danger">
									<div class="box-body">
										<div class="flexbox">
											<h5><?php echo langs('profits'); ?></h5>
										</div>

										<div class="text-center my-2">
											<div class="font-size-60"><?php echo $deliver_bill; ?><?php echo langs('LYD'); ?></div>
											<span><?php echo langs('profits'); ?></span>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<?php
				global $sum_price;
				$uisql = "SELECT * FROM hire WHERE deliver= '$sid'";
				$udata=$this->comman_model->get_all_data_by_query($uisql);
				foreach ($udata as $postsfetch) {
					$serial += 1;
					$shop_id = $postsfetch['shop'];
					$deliver_bill = 0;
					$shop_bill = 0;
					$payment_value = 0;
					$uisql = "SELECT value FROM payment WHERE user_id= '$sid' AND shop_id = '$shop_id'";
					$udata=$this->comman_model->get_all_data_by_query($uisql);
					foreach ($udata as $postsfetchx) {
						$payment_value += $postsfetchx['value'];
					}
					$uisql = "SELECT * FROM orders WHERE shop_id= '$shop_id' AND accept='$sid' AND shop_finish!='0'";
					$udata=$this->comman_model->get_all_data_by_query($uisql);
					foreach ($udata as $postsfetchx) {
						$order_id = $postsfetchx['id'];
						$deliver_bill += $postsfetchx['deliver_bill'];
						$shop_bill += $postsfetchx['shop_bill'];
					}
					?>
					<a href="" class="none-link"> <div class="box">
							<div class="vtabs padding-10">
								<div style="background: url('<?php echo base_url().settings_output('profile_img',$shop_id); ?>') no-repeat center center;height: 70px !important;width: 70px !important;border-radius: 100%;margin: 10px" class="tabs-vertical side-product">
								</div>
								<div class="box-body">
									<h4><span class="font-size-20"><?php echo settings_output('name',$shop_id); ?></span><span class="label label-danger float-right"><?php echo $shop_bill-$payment_value; ?><?php echo langs('LYD'); ?></span></h4>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>

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
