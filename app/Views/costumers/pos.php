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
				<form action="<?php echo base_url();?>costumers/add_pos" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('POS'); ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('item'); ?></label>
							<select name="item" id="item" class="form-control">
<?php
foreach ($fetchdatas as $postsfetch ) {
	$id = $postsfetch['id'];
	$title = $postsfetch['title'];
	echo "<option value='$id'>$title</option>";
}
 ?>
							</select>
						</div>
						<div class="form-group">
							<label><?php echo langs('quantity'); ?></label>
							<input type="text" name="quantity" id="quantity" autocomplete="off" placeholder="<?php echo langs('quantity'); ?>" class="form-control">
						</div>

						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					</div>
					</div>

	</form>

<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('bill'); ?>	<button onclick="order('<?php echo rand(0,9999); ?>')" class="btn btn-secondary buttons-html5">close order</button></h3>

		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('item_name'); ?></th>
				<th><?php echo langs('quantity'); ?></th>
				<th><?php echo langs('unit_price'); ?></th>
				<th><?php echo langs('total_price'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
<?php
$serial = 0;
	$total = 0;
foreach ($fetchdata as $postsfetch ) {
	$id = $postsfetch['id'];
$quantity = $postsfetch['quantity'];
$serial++;
foreach ($fetchdatas as $postsfetchi ) {
	$title = $postsfetchi['title'];
	$price = $postsfetchi['price'];
	$total_price = $price*$quantity;
$total += $total_price;
}
?>
<tr id="tr_<?php echo $id; ?>">
<td><?php echo $serial; ?></td>
<td><?php echo $title; ?></td>
<td><?php echo $quantity; ?></td>
<td><?php echo $price; ?></td>
<td><?php echo $total_price; ?></td>
<td>
<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('cart','<?php echo $id; ?>')"></button>
</td>
</tr>
<?php } ?>
</tbody>
<tfoot>
	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th><?php echo $total; ?></th>
		<th></th>
	</tr>
</tfoot>
</table>

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
