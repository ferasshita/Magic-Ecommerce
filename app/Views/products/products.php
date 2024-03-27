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
				<form action="<?php echo base_url();?>products/add_product" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="row">
					<div class="col-xl-8 col-12">
				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('product'); ?></h3>
					</div>
					<div class="box-body">
													<div class="row overflow-xh" >
														<div class="col-md-3">
															<label style="width: 100%;"><div style="text-align: center; padding: 50% 100px;" class="dropzone dz-clickable"><span class="fa fa-plus"></span></div>
																<input type="file" name="images[]" id="img_item" accept="image/png, image/jpeg, image/jpeg" style="display: none" class="form-control" onchange='itemphoto(this);' multiple />
															</label>
												</div>
														<span id="photo_item"></span>
											</div>
											<?php foreach ($fetchdatai as $postsfetch ) {
												echo "<img src=\"".base_url().$postsfetch['location']."\" class=\"col-md-3\" oncontextmenu=\"delete_transaction('product','".$postsfetch['id']."')\">";
											} ?>
						<div class="form-group">
							<label><?php echo langs('title'); ?></label>
							<input type="text" name="title" id="title" value="<?php echo $title; ?>" autocomplete="off" placeholder="<?php echo langs('title'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('description'); ?></label>
							<textarea class="form-control" name="description" placeholder="<?php echo langs('description'); ?>..." rows="10" cols="80"><?php echo $description; ?></textarea>
						</div>
						<div class="row">
							<div class="col-lg-6">
						<div class="form-group">
							<label><?php echo langs('price'); ?></label>
							<input type="text" name="price" id="price_f" value="<?php echo $price; ?>" autocomplete="off" placeholder="<?php echo langs('price'); ?>" class="form-control">
						</div>
						</div>
						<div class="col-lg-6">
						<div class="form-group">
							<label><?php echo langs('compare_price'); ?></label>
							<input type="text" name="compare_price" id="compare_price" value="<?php echo $compare_price; ?>" autocomplete="off" placeholder="<?php echo langs('compare_price'); ?>" class="form-control">
						</div>
					</div>
					</div>

						<div class="controls">
						<fieldset>
						<input name="track_quantity" value="1" id="track_quantity" type="checkbox" <?php if($track_quantity == '1'){echo "checked";} ?>>
						<label for="track_quantity"><?php echo langs('track_quantity'); ?></label>
						</fieldset>
						</div>
						<div class="controls">
						<fieldset>
						<input name="out_stock" value="1" id="out_stock" type="checkbox" <?php if($out_stock == '1'){echo "checked";} ?>>
						<label for="out_stock"><?php echo langs('out_stock'); ?></label>
						</fieldset>
						</div>
						<div class="form-group">
							<label><?php echo langs('barcode'); ?></label>
							<input type="text" name="barcode" id="barcode" value="<?php echo $barcode; ?>" autocomplete="off" placeholder="<?php echo langs('barcode'); ?>" class="form-control">
						</div>

						<div class="form-group">
							<label><?php echo langs('shipping_weight'); ?></label>
							<input type="text" name="shipping_weight" id="shipping_weight" value="<?php echo $shipping_weight; ?>" autocomplete="off" placeholder="<?php echo langs('shipping_weight'); ?>" class="form-control">
						</div>


									<input type="hidden" name="id" value="<?php echo $pid; ?>">
						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					</div>
					</div>
					</div>


					<div class="col-xl-4 col-12">
				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('settings'); ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('status'); ?></label>
							<select name="status" id="status" class="form-control">
								<option>active</option>
								<option>stoped</option>
							</select>
						</div>

						<div class="form-group">
							<label><?php echo langs('product_catigory'); ?></label>
							<input type="text" name="product_catigory" list="br_product_catigory" id="product_catigory" value="<?php echo $product_catigory; ?>" autocomplete="off" placeholder="<?php echo langs('product_catigory'); ?>" class="form-control">
						</div>
			<?php echo browsing('product','product_catigory','') ?>

						<div class="form-group">
							<label><?php echo langs('product_type'); ?></label>
							<input type="text" name="product_type" id="product_type" list="br_product_type" value="<?php echo $product_type; ?>" autocomplete="off" placeholder="<?php echo langs('product_type'); ?>" class="form-control">
						</div>
						<?php echo browsing('product','product_type','') ?>

						<div class="form-group">
							<label><?php echo langs('vendor'); ?></label>
							<input type="text" name="vendor" id="vendor" list="br_vendor" value="<?php echo $vendor; ?>" autocomplete="off" placeholder="<?php echo langs('vendor'); ?>" class="form-control">
						</div>
						<?php echo browsing('product','vendor','') ?>

						<div class="form-group">
							<label><?php echo langs('collection'); ?></label>
							<select name="collection" id="collection" class="form-control">
								<?php foreach ($fetchdata_collection as $postsfetch ) {?>
							<?php echo "<option value='".$postsfetch['id']."'>".$postsfetch['title']."</option>"; ?><
							<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label><?php echo langs('tags'); ?></label>
							<input type="text" name="tags" id="tags" value="<?php echo $tags; ?>" autocomplete="off" placeholder="<?php echo langs('tags'); ?>" class="form-control">
						</div>
					</div>
					</div>
					</div>

	</form>
<?php if($pid != NULL){ ?>
	<div class="col-xl-8 col-12">
	<div class="box">
	<div class="box-header">
		<h3><?php echo langs('variants'); ?></h3>
	</div>
	<div class="box-body">
			<form action="<?php echo base_url();?>products/add_variant" method="post" id="postingToDBi" enctype="multipart/form-data" >
				<div class="row">

			<div class="col-lg-6">
		<div class="form-group">
			<label><?php echo langs('image'); ?></label>
			<input type="file" name="variant_image" id="variant_image" accept="image/*" class="form-control">
		</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $pid; ?>">
		<div class="col-lg-6">
		<div class="form-group">
			<label><?php echo langs('option_name'); ?></label>

			<input type="text" name="option_name" id="option_name" autocomplete="off" placeholder="<?php echo langs('option_name'); ?>" class="form-control">
</div>
</div>
		</div>


		<div class="box-footer">
			<div class="loadingPostingi"></div>
			<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_nowi">
				<?php echo langs('add'); ?>
			</button>
		</div>
			</form>
	</div>
</div>
</div>
<?php } ?>
</div>

<?php if($pid != NULL){ ?>
<div id="refreshi">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('variants'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('option_name'); ?></th>
				<th><?php echo langs('image'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
<?php
	$serial = 0;
foreach ($fetchdata as $postsfetch ) {
$serial++;
?>
<tr id="tr_<?php echo $postsfetch['id'];; ?>">
<td><?php echo $serial; ?></td>
<td><?php echo $postsfetch['option_name']; ?></td>
<?php if($postsfetch['image'] != ""){ ?>
<td><img style="width:100px" src="<?php echo base_url().$postsfetch['image']; ?>"></td>
<?php }else{ ?>
	<td></td>
<?php } ?>
<td>
<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('variant','<?php echo $postsfetch['id']; ?>')"></button>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>
</div>
</div>
<?php }?>
						<div id="refresh">
							<div class="box">
								<div class="box-header">
									<h3><?php echo langs('products'); ?></h3>
								</div>
								<div class="box-body">
							<div class="table-responsive">
								<table class="reports_1 table table-lg invoice-archive reports_1">
									<thead>
									<tr>
										<th>#</th>
										<th><?php echo langs('product_name'); ?></th>
										<th><?php echo langs('price'); ?></th>
										<th><?php echo langs('inventory'); ?></th>
										<th><?php echo langs('vendors'); ?></th>
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
<td><?php echo $postsfetch['title']; ?></td>
<td><?php echo $postsfetch['price']; ?></td>
<td><?php echo $postsfetch['status']; ?></td>
<td><?php echo $postsfetch['vendor']; ?></td>
<td><?php echo $postsfetch['barcode']; ?></td>
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

<script>
	$(document).ready(function(){
		var i = 1;
		$("#postingToDBi").on('submit',function(e){
				var plus = i++;
				$("#getingNP").prepend("<div id='FetchingNewPostsDiv"+plus+"' style='display:none;'></div>");
				e.preventDefault();
				$(this).ajaxSubmit({
					beforeSend:function(){
						$('.loadingPosting').show();
						$(".loadingPosting").html('<p class="loadingPostingP">0</p>');
						$(".loadingPostingP").css({'width' : '0%'});
					},
					uploadProgress:function(event,position,total,percentCompelete){
						$(".loadingPostingP").css({'width' : percentCompelete + '%'});
						$(".loadingPostingP").html(percentCompelete);
					},
					success:function(data){
						$('.empty').val('');
						$("#refreshi").load(location.href + " #refreshi");
						$(".loadingPosting").html(data);
						$(".loadingPosting").fadeOut(2000);
					}
				});

		});
	});
</script>
<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
