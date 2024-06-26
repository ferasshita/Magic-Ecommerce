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
				<form action="<?php echo base_url();?>discount/add_discount" method="post" id="postingToDB" enctype="multipart/form-data" >

				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('discount'); ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label><?php echo langs('type'); ?></label>
							<select name="type" id="type" onchange="location = '?disid='+this.value;" class="form-control">
								<option value=""><?php echo langs('select'); ?></option>
								<?php foreach(LoadTypes() as $key => $value) { ?>
<option value="<?= htmlspecialchars($key) ?>" title="<?= $value ?>" <?php if($discount_id == htmlspecialchars($key)){echo "selected";} ?>><?= htmlspecialchars(langs($value)) ?></option>
<?php } ?>							</select>
						</div>
						<?php if($discount_id != NULL){ ?>
						<?php if($discount_id == "0"){ ?>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
										<label><?php echo langs('product'); ?></label>
									<input type="text" name="x"list="br_title" id="x" value="<?php echo $x; ?>" autocomplete="off" placeholder="<?php echo langs('product'); ?>" class="form-control empty">
	<?php echo browsing('product','title','') ?>
					</div>
					<div class="col-lg-6">
						<label><?php echo langs('quantity'); ?></label>

						<input type="number" name="z" id="z" value="<?php echo $z; ?>" autocomplete="off" placeholder="<?php echo langs('quantity'); ?>" class="form-control empty">
		</div>
</div>
</div>
						<div class="form-group">
							<label><?php echo langs('free_product'); ?></label>
							<input type="text" name="y" id="y" list="br_title" value="<?php echo $y; ?>" autocomplete="off" placeholder="<?php echo langs('free_product'); ?>" class="form-control empty empty">
						</div>
					<?php }elseif($discount_id == "1"){ ?>
				<div class="form-group">
					<label><?php echo langs('discount_percent'); ?>%</label>
					<input type="text" name="x" id="x" value="<?php echo $x; ?>" autocomplete="off" placeholder="<?php echo langs('discount_percent'); ?>%" class="form-control empty empty">
				</div>
				<div class="form-group">
					<label><?php echo langs('minimum_purchase'); ?></label>
					<input type="number" name="minimum_purchase" id="minimum_purchase" value="<?php echo $minimum_purchase; ?>" autocomplete="off" placeholder="<?php echo langs('minimum_purchase'); ?>" class="form-control empty">
				</div>
			<?php }elseif($discount_id == "2"){ ?>
			<div class="form-group">
				<label><?php echo langs('discount_percent'); ?>%</label>
				<input type="text" name="x" id="x" value="<?php echo $x; ?>" autocomplete="off" placeholder="<?php echo langs('discount_percent'); ?>%" class="form-control empty">
			</div>
			<div class="form-group">
				<label><?php echo langs('product'); ?></label>
				<input type="text" name="y" id="product" list="br_title" value="<?php echo $y; ?>" autocomplete="off" placeholder="<?php echo langs('code'); ?>" class="form-control empty">
				<?php echo browsing('product','title','') ?>
			</div>
		<?php }elseif($discount_id == "3"){ ?>
<div class="form-group">
	<label><?php echo langs('minimum_purchase'); ?></label>
	<input type="number" name="minimum_purchase" id="minimum_purchase" value="<?php echo $minimum_purchase; ?>" autocomplete="off" placeholder="<?php echo langs('minimum_purchase'); ?>" class="form-control empty">
</div>
<?php } ?>
						<div class="form-group">
							<label><?php echo langs('code'); ?></label>

						<div class="input-group mb-3" >

						<div class="input-group" id="show_hide_password">
						<input type="text" name="code" id="code" value="<?php echo $code; ?>" autocomplete="off" placeholder="<?php echo langs('code'); ?>" class="form-control empty">

						<div class="input-group-addon" style="background:transparent;border-<?php echo langs('homeLinks'); ?>:none">
						<a aria-label="password toggle" onclick="generateRandomText();" href="javascript:void(0)"><i id="eye" class="fa fa-random" aria-hidden="true"></i></a>
						</div>
						</div>

						</div>
						</div>

						<!--<div class="form-group">
							<label><?php echo langs('limit_of_times'); ?></label>
							<input type="number" name="limit" id="limit" value="<?php echo $limit; ?>" autocomplete="off" placeholder="<?php echo langs('limit'); ?>" class="form-control empty">
						</div>-->
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<label><?php echo langs('from_expire_date'); ?></label>

							<input type="date" name="from" id="from" value="<?php echo $from; ?>" autocomplete="off" placeholder="<?php echo langs('from'); ?>" class="md-col-12 form-control empty">
						</div>
							<div class="col-lg-6">
								<label><?php echo langs('to_expire_date'); ?></label>

							<input type="date" name="to" id="to" value="<?php echo $to; ?>" autocomplete="off" placeholder="<?php echo langs('to'); ?>" class="md-col-12 form-control empty">
						</div>
						</div>
						</div>

									<input type="hidden" name="id" value="<?php echo $pid; ?>"
						<div class="box-footer">
							<div class="loadingPosting"></div>
							<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now">
								<?php echo langs('add'); ?>
							</button>
						</div>
					<?php } ?>
				</div>
					</div>

	</form>

<div id="refresh">
	<div class="box">
		<div class="box-header">
			<h3><?php echo langs('discount'); ?></h3>
		</div>
		<div class="box-body">
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('status'); ?></th>
				<th><?php echo langs('code'); ?></th>
				<th><?php echo langs('type'); ?></th>
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
<td><?php if(date($postsfetch['from_date']) <= date($postsfetch['to_date'])){echo"<span class='label label-success'>active</span>";}else{echo"<span class='label label-danger'>not active</span>";} ?></td>
<td><a href="<?php echo base_url() ?>discount/promocode?pid=<?php echo $postsfetch['code']; ?>"><?php echo $postsfetch['code']; ?></a></td>
<td><?php $type_table = LoadTypes();
 echo $type_table[$postsfetch['type']]; ?></td>
<td>
<button class="btn btn-danger fa fa-trash" onclick="delete_transaction('discount','<?php echo $postsfetch['id']; ?>')"></button>
<a href="?pid=<?php echo $postsfetch['id']; ?>&disid=<?php echo $postsfetch['type']; ?>"><button class="btn btn-info fa fa-pencil"></button></a>
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
	function generateRandomText() {
		// Define characters to use for random generation
		const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		let randomString = "";
		for (let i = 0; i < 12; i++) {
			// Get a random character index
			const randomIndex = Math.floor(Math.random() * characters.length);
			// Add the character at that index to the string
			randomString += characters[randomIndex];
		}

		// Set the generated text in the input field
		document.getElementById("code").value = randomString;
	}
</script>
<!-- endJS -->
<?php echo view("includes/endJScodes"); ?>
<!-- /endJS -->
</body>
</html>
