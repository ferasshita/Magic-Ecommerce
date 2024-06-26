<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>">
<head>
	<?php echo view("includes/head_info"); ?>
</head>
<body class="<?php echo view("includes/mode"); ?> <?php echo langs('html_dir'); ?> no-sidebar  theme-primary sidebar-collapse fixed">

<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<?php echo view("includes_site/navbar_main.php"); ?>
	<!-- /navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content">
				<div class="box">
					<div class="box-header">
						<h3><?php echo langs('code'); ?></h3>
					</div>
					<div class="box-body">
							<?php foreach ($fetchdata as $postsfetch ) { ?>
								<?php $type_table = LoadTypes(); ?>
						<h3><?php echo langs('type'); ?>: <?php echo langs($type_table[$postsfetch['type']]); ?></h3>

						<h3><?php echo langs('status'); ?>: <?php
						function isDateBeforeToday($dateString) {
  // Validate format (optional)
  if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dateString)) {
    return false; // Invalid format
  }

  // Convert strings to DateTime objects
  $dateToCheck = DateTime::createFromFormat('d/m/Y', $dateString);
  $today = new DateTime('now');

  // Check if dateToCheck is before today
  return $dateToCheck < $today;
}

// Example usage
$dateString = $postsfetch['to_date']; // Or any other date string
$isBefore = isDateBeforeToday($dateString);
if ($isBefore) {
  echo "<span class='label label-danger'>".langs('not_active')."</span>.";
} else {
  echo "<span class='label label-success'>".langs('active')."</span>";
}
?></h3>
					<?php } ?>
					</div>
					</div>
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
				<th><?php echo langs('order'); ?></th>
				<th><?php echo langs('date'); ?></th>
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
<td><?php echo $postsfetch['id']; ?></td>
<td><?php echo $postsfetch['date']; ?></td>
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
