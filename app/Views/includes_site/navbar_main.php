<?php
$user_id = session('id', null);
if($user_id != NULL){
$page_name = $page;
$title = $title;
?>
<body class="light-skin sidebar-mini fixed theme-primary">
<header class="main-header">
	<div class="d-flex align-items-center logo-box pl-20">
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

				<li id="cart_box" class="btn-group d-lg-inline-flex">
										<?php
										$comman_model = new \App\Models\Comman_model();
										$sum_price_cart = 0;
										$uisql = "SELECT item_id,quantity FROM cart WHERE user_id= '$user_id' AND order_id = '0'";
										$udata = $comman_model->get_all_data_by_query($uisql);
										foreach ($udata as $postsfetch) {
											$item_id_cart = $postsfetch['item_id'];
											$quantity = $postsfetch['quantity'];
										$uisql = "SELECT price, compare_price FROM product WHERE id= '$item_id_cart'";
										$udata = $comman_model->get_all_data_by_query($uisql);
										foreach ($udata as $postsfetchx) {
											$price_cart = $postsfetchx['price'];
											$sale_cart = $postsfetchx['compare_price'];
											$sum_price_cart +=$price_cart;
											$pricey = price_display($price_cart, $sale_cart, $quantity);
										}
										}
										?>
										<div class="app-menu cart-app-menu">
											<div class="search-bx mx-5">
												<a href="<?php echo base_url();?>theme/cart">
													<div class="input-group">
														<input disabled style="cursor: inherit;width:135px" type="search" class="form-control cart_input_view" value="<?php echo $sum_price_cart.langs('LYD'); ?>" aria-label="Search" aria-describedby="button-addon2">
														<div class="input-group-append">
															<button class="btn" type="button" id="button-addon3"><img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/ecommerce.svg" class="img-fluid" alt="search"></button>
														</div>
													</div>
												</a>
											</div>
										</div>
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
</body>
<?php } ?>
<!-- Left side column. contains the logo and sidebar -->
