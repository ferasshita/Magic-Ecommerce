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
				<form action="<?php echo base_url();?>dashboard/add_blog" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('add_gift_card'); ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('title'); ?></label>
							<input type="text" name="title" id="title" value="<?php echo $title; ?>" autocomplete="off" placeholder="<?php echo langs('title'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('description'); ?></label>
							<input type="text" name="description" id="description" value="<?php echo $description; ?>" autocomplete="off" placeholder="<?php echo langs('description'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('image'); ?></label>
							<input type="file" name="image" id="title" accept="image/*" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('price'); ?></label>
							<input type="text" name="price" id="price" value="<?php echo $price; ?>" autocomplete="off" placeholder="<?php echo langs('price'); ?>" class="form-control">
						</div>

									<input type="hidden" name="id" value="<?php echo $pid; ?>">
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
			<h3><?php echo langs('inventory'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('title'); ?></th>
				<th><?php echo langs('description'); ?></th>
				<th><?php echo langs('price'); ?></th>
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
<td><?php echo $postsfetch['title']; ?></td>
<td><?php echo $postsfetch['description']; ?></td>
<td><?php echo $postsfetch['price']; ?></td>
<td>
<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('gift_card','<?php echo $postsfetch['id']; ?>')"></button>
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
