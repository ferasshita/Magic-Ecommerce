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

				<form action="<?php echo base_url();?>costumers/add_delivery" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('add_deliver'); ?></h3>
					</div>
					<div class="box-body">
						<label>

<?php if($photo!=NULL){ ?>
			<img src="<?php echo base_url().$photo; ?>" alt="profile image" id="profilePhotoPreview_photo" style="width:100px">
		<?php }else{?>
<div id="profilePhotodivPreview_photo" style="text-align: center; padding: 50% 100px;" class="dropzone dz-clickable"><?php echo langs('image'); ?></div>
	<?php	} ?>
	<input type="file" name="photo" id="title" style="display:none" accept="image/*" class="form-control" onchange="profilePhoto(this,'photo');" >
		</label>
		<div class="row">
			<div class="col-md-6">
						<div class="form-group">
							<label><?php echo langs('name'); ?>*</label>
							<input type="text" name="name" id="name" value="<?php echo $name; ?>" autocomplete="off" placeholder="<?php echo langs('name'); ?>" class="form-control">
						</div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label><?php echo langs('email'); ?>*</label>
							<input type="text" name="email" id="email" value="<?php echo $email; ?>" autocomplete="off" placeholder="<?php echo langs('email'); ?>" class="form-control">
						</div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label><?php echo langs('phone'); ?>*</label>
							<input type="text" name="phone" id="phone_no" value="<?php echo $phone; ?>" autocomplete="off" placeholder="<?php echo langs('phone'); ?>" class="form-control">
						</div>
						</div>
					</div>
	<label>

<?php if($license_photo!=NULL){ ?>
			<img src="<?php echo base_url().$license_photo; ?>" alt="profile image" id="profilePhotoPreview_license" style="width:100px">
		<?php }else{?>
<div id="profilePhotodivPreview_license" style="text-align: center; padding: 50% 100px;" class="dropzone dz-clickable"><?php echo langs('license_photo'); ?></div>
	<?php	} ?>

	<input type="file" name="license_photo" id="title" style="display:none" accept="image/*" class="form-control" onchange="profilePhoto(this,'license');" >
		</label>

						<div class="form-group">
							<label><?php echo langs('license_number'); ?></label>
							<input type="text" name="license_number" id="license_number" value="<?php echo $license_number; ?>" autocomplete="off" placeholder="<?php echo langs('license_number'); ?>" class="form-control">
						</div>
						<label>

<?php if($passport_photo!=NULL){ ?>
			<img src="<?php echo base_url().$passport_photo; ?>" alt="profile image" id="profilePhotoPreview_passport" style="width:100px">
		<?php }else{?>
<div id="profilePhotodivPreview_passport" style="text-align: center; padding: 50% 100px;" class="dropzone dz-clickable"><?php echo langs('passport_photo'); ?></div>
	<?php	} ?>

	<input type="file" name="passport_photo" id="passport_photo" accept="image/*" style="display:none" class="form-control" onchange="profilePhoto(this,'passport');" >
		</label>
						<div class="form-group">
							<label><?php echo langs('passport_number'); ?></label>
							<input type="text" name="passport_number" id="passport_number" value="<?php echo $passport_number; ?>" autocomplete="off" placeholder="<?php echo langs('passport_number'); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo langs('vehical_number'); ?></label>
							<input type="text" name="vehical_number" id="vehical_number" value="<?php echo $vehical_number; ?>" autocomplete="off" placeholder="<?php echo langs('vehical_number'); ?>" class="form-control">
						</div>

									<input type="hidden" name="deliver_id" value="<?php echo $pid; ?>"
						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					</div>

	</form>
<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('deliveries'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('delivery_name'); ?></th>
				<th><?php echo langs('phone_no'); ?></th>
				<th><?php echo langs('email'); ?></th>
				<th><?php echo langs('license_number'); ?></th>
				<th><?php echo langs('passport_number'); ?></th>
				<th><?php echo langs('vehical_number'); ?></th>
				<th><?php echo langs('password'); ?></th>
				<th><span class="fa fa-cog"></span></th>
			</tr>
		</thead>
		<tbody>
			<?php
		$serial = 0;
			foreach ($fetchdatas as $postsfetch ) {
			$serial++;
	?>
	<tr id="tr_<?php echo  $postsfetch['id']; ?>">
	<td><?php echo $serial; ?></td>
	<td><?php echo $postsfetch['name']; ?></td>
	<td><?php echo $postsfetch['phone']; ?></td>
	<td><?php echo $postsfetch['email']; ?></td>
	<td><?php echo $postsfetch['license_number']; ?></td>
	<td><?php echo $postsfetch['passport_number']; ?></td>
	<td><?php echo $postsfetch['vehical_number']; ?></td>
	<td><?php echo $postsfetch['password']; ?></td>
	<td>
	<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('deliver','<?php echo $postsfetch['id']; ?>')"></button>
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
