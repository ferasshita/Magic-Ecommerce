<!DOCTYPE html>
<html class="<?php echo view("includes/mode"); ?>" translate="no" lang="en">
<head>
	<?php echo view("includes/head_info");
		$this->comman_model = new \App\Models\Comman_model();
 ?>
</head>
<body class="<?php echo view("includes/mode.php"); ?> no-sidebar <?php echo langs('html_dir'); ?> theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php echo view("includes/navbar_main"); ?>
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

				$uisql = "SELECT * FROM orders WHERE accept='$sid' AND shop_finish!='0'";
				$udata=$this->comman_model->get_all_data_by_query($uisql);
			$count_orders=count($udata);
				?>
				<div class="box">
					<div class="box-body">
						<div class="row">

							<div class="col-xl-3 col-md-6 col-12 ">
								<div class="box box-inverse box-success">
									<div class="box-body">
										<div class="flexbox">
											<h5><?php echo langs('order'); ?></h5>
										</div>

										<div class="text-center my-2">
											<div class="font-size-60"><?php echo $count_orders; ?></div>
											<span><?php echo langs('orders'); ?></span>
										</div>
									</div>
								</div>
							</div>



						</div>
					</div>
				</div>
				<?php
					$uisql = "SELECT * FROM orders WHERE accept='$sid' AND shop_finish!='0'";
					$udata=$this->comman_model->get_all_data_by_query($uisql);
					foreach ($udata as $postsfetchx) {
						$order_id = $postsfetchx['id'];

					?>
					<a href="" class="none-link"> <div class="box">
							<div class="vtabs padding-10">

								<div class="box-body">
									<h4><span class="font-size-20"><a href="<?php echo base_url(); ?>theme/cart?pid=<?php echo $order_id; ?>"><?php echo $order_id; ?></a></span></h4>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>

			</section>

		</div>
	</div>
	<!-- footer -->
	<?php  echo view("includes/footer"); ?>
	<!-- /footer -->
</div>
<!-- ./wrapper -->

<!-- endJS --><?php  echo view("includes/endJScodes"); ?><!-- /endJS -->
</body>
</html>
