<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>">
<head>
	<?php echo view("includes/head_info"); ?>
</head>
<body class="<?php echo langs('html_dir'); ?> <?php echo view("includes/mode"); ?> sidebar-mini fixed theme-primary">

<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php echo view("includes/navbar_main.php"); ?>
	<!-- /navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content">


				<!-- total sales -->
				<!-- vists -->
<!-- orders -->
<div class="row">

	<div class="col-xl-3 col-md-6 col-12 ">
			<div class="box box-inverse box-success">
				<div class="box-body">
					<div class="flexbox">
						<h5><?php echo langs('orders'); ?></h5>
						<div class="dropdown">
							<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
							</div>
						</div>
					</div>

					<div class="text-center my-2">
						<div class="font-size-60"><?php if($orders_count == "" ){echo "0";}else{echo thousandsCurrencyFormat($orders_count);} ?></div>
						<span><?php echo langs('orders'); ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 col-12 ">
				<div class="box box-inverse box-warning">
					<div class="box-body">
						<div class="flexbox">
							<h5><?php echo langs('net_sales'); ?></h5>
							<div class="dropdown">
								<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
								</div>
							</div>
						</div>

						<div class="text-center my-2">
							<div class="font-size-60"><?php if($total == "" ){echo "0";}else{echo thousandsCurrencyFormat($total);} ?></div>
							<span><?php echo langs('net_sales'); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-md-6 col-12 ">
					<div class="box box-inverse box-info">
						<div class="box-body">
							<div class="flexbox">
								<h5><?php echo langs('average_order'); ?></h5>
								<div class="dropdown">
									<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
									</div>
								</div>
							</div>

							<div class="text-center my-2">
								<div class="font-size-60"><?php if($average_order == "" ){echo "0";}else{echo thousandsCurrencyFormat($average_order);} ?></div>
								<span><?php echo langs('average_order'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 col-12 ">
						<div class="box box-inverse box-danger">
							<div class="box-body">
								<div class="flexbox">
									<h5><?php echo langs('products'); ?></h5>
									<div class="dropdown">
										<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
										</div>
									</div>
								</div>

								<div class="text-center my-2">
									<div class="font-size-60"><?php if($inventory == "" ){echo "0";}else{echo thousandsCurrencyFormat($inventory);} ?></div>
									<span><?php echo langs('products'); ?></span>
								</div>
							</div>
						</div>
					</div>
	</div>


			</section>

		</div>
	</div>
	<!-- /.content-wrapper -->

	<!-- footer -->
	<?php echo view("includes/footer"); ?>
	<!-- /footer -->
</div>

<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
