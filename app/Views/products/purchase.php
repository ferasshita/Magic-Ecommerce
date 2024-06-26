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
				<form action="<?php echo base_url();?>products/add_purchase" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('purchase'); ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('product'); ?></label>
							<select name="product" id="product" class="form-control">
<?php
foreach ($fetch_product as $postsfetch ) {
	$title = $postsfetch['title'];
	$id = $postsfetch['id'];
	echo "<option value='$id'>$title</option>";
}
 ?>
							</select>
						</div>
						<div class="form-group">
							<label><?php echo langs('quantity'); ?></label>
							<input type="text" name="quantity" id="quantity" autocomplete="off" placeholder="<?php echo langs('quantity'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('vendor'); ?></label>
							<input type="text" name="vendor" id="vendor" autocomplete="off" placeholder="<?php echo langs('vendor'); ?>" class="form-control">
						</div>

						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					</div>

	</form>
</div>

<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('purchases'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('item_name'); ?></th>
				<th><?php echo langs('quantity'); ?></th>
				<th><?php echo langs('vendor'); ?></th>
				<th><?php echo langs('date'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
			<?php
		$serial = 0;
			foreach ($fetchdata as $postsfetch ) {
			$serial++;
?>
<tr id="tr_<?php echo $postsfetch['id']; ?>">
<td><?php echo $serial; ?></td>
<td><?php echo $product_name; ?></td>
<td><?php echo $postsfetch['quantity']; ?></td>
<td><?php echo $postsfetch['vendor']; ?></td>
<td><?php echo $postsfetch['date']; ?></td>
<td>
<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('product','<?php echo $postsfetch['id']; ?>')"></button>
<a href="?pid=<?php echo $postsfetch['id']; ?>"><button class="btn btn-info fa fa-pencil"></button></a>
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

	<!-- footer -->
	<?php echo view("includes/footer"); ?>
	<!-- /footer -->
</div>

<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
