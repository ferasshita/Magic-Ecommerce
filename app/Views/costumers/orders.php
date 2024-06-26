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

				<div class="box">
					<div class="box-body">
						<form action="<?php echo base_url(); ?>theme/cart" method="get">
					      <div style="padding:10px" class="input-group mb-3" >
					      <div class="input-group">
					      <input type="text" name="pid" value="" id="pid" class="form-control" placeholder="بحث..">
					      <button class="input-group-addon">
					      <span class="fa fa-search"></span>
					    </button>
					  </div>
					      </div>
					      </form>
					</div>
					</div>

<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('orders'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th><?php echo langs('order_number'); ?></th>
				<th><?php echo langs('total'); ?></th>
				<th><?php echo langs('status'); ?></th>
				<th><?php echo langs('deliver'); ?></th>
				<th><?php echo langs('date'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
			<?php
		$serial = 0;
		$comman_model = new \App\Models\Comman_model();
			foreach ($fetchdatas as $postsfetch ) {
			$serial++;
			$total =0;
			if($postsfetch['pos'] == 1){
				$status= "<label class='badge badge-success'>".langs('POS')."</label>";
			}elseif($postsfetch['shop_finish'] != 0){
				$status= "<label class='badge badge-success'>".langs('finished')."</label>";
		}elseif($postsfetch['accept'] != 0){
				$status= "<label class='badge badge-info'>".langs('deliver_accepted')."</label>";
			}elseif($postsfetch['accept'] == 0){
				$status= "<label class='badge badge-warning'>".langs('waiting_deliver')."</label>";
			}
			$id=$postsfetch['id'];
			$user_id=$postsfetch['user_id'];
			$accept=$postsfetch['accept'];
			$uisql = "SELECT name FROM deliver WHERE id='$accept'";
			$fetchdatas=$comman_model->get_all_data_by_query($uisql);
			foreach ($fetchdatas as $postsfetchc) {
			$deliver=$postsfetchc['name'];
			}
			$uisql = "SELECT item_id,quantity FROM cart WHERE order_id='$id'";
			$fetchdatasss=$comman_model->get_all_data_by_query($uisql);
			foreach ($fetchdatasss as $postsfetchi) {
				$item_id=$postsfetchi['item_id'];
			$quantity=$postsfetchi['quantity'];
			$uisql = "SELECT price FROM product WHERE id='$item_id'";
			$fetchdatassss=$comman_model->get_all_data_by_query($uisql);
			foreach ($fetchdatassss as $postsfetchx) {
				$price_total = $quantity*$postsfetchx['price'];
			$total +=$price_total;
			}
			}
	?>
	<tr id="tr_<?php echo $postsfetch['id']; ?>">
	<td>#<?php echo $postsfetch['id']; ?></td>
	<td><?php echo $total; ?></td>
	<td><?php echo $status; ?></td>
	<?php if($postsfetch['pos'] == 0){ ?>
	<td><?php echo $deliver; ?></td>
<?php }else{?>
	<td></td>
<?php } ?>
	<td><?php echo $postsfetch['date']; ?></td>
	<td>
	<a href="<?php echo base_url(); ?>theme/cart?pid=<?php echo $postsfetch['id']; ?>"><button class="btn btn-info fa fa-pencil"></button></a>
	</td>
	</tr>
			<?php } ?>
</tbody>
</table>

</div>
</div>
</div>
</div>


			</section>

		</div>
	</div>
	<!-- /.content-wrapper -->
<script>
var x = setInterval(function() {
$("#refresh").load(location.href + " #refresh");
}, 1000);
</script>
	<!-- footer -->
	<?php echo view("includes/footer"); ?>
	<!-- /footer -->
</div>

<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
