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

<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('inventory'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('item_name'); ?></th>
				<th><?php echo langs('price'); ?></th>
				<th><?php echo langs('quantity_avilable'); ?></th>
				<th><?php echo langs('barcode'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
			<?php
		$serial = 0;
			foreach ($fetchdatas as $postsfetch ) {
			$serial++;
?>
<tr id="tr_<?php echo $postsfetch['id']; ?>">
<td><?php echo $serial; ?></td>
<td><?php echo $product_name; ?></td>
<td><?php echo $price; ?></td>
<td><?php echo $number; ?></td>
<td><?php echo $barcode; ?></td>
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
