<!DOCTYPE html>
<html class="<?php echo view("includes/mode"); ?>" translate="no" lang="en">
<head>
	<?php echo view("includes/head_info"); ?>
</head>
<body class="<?php echo view("includes/mode.php"); ?> no-sidebar <?php echo langs('html_dir'); ?> theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom">
	<div id="loader"></div>
	<!-- navbar -->
	<!-- /navbar -->
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content-height">
				<div class="row">
								<div class="box">
									<div class="box-body">
										<form class="" action="<?php echo base_url();?>Setting/SaveLocation" method="post" enctype="multipart/form-data" >
											<h3 align="center"><?php echo langs('location'); ?> </h3>
											<div class="row">
												<div class="col-6">
													<div class="form-group">
														<label><?php echo langs('location_name'); ?></label>
														<input type="text" name="name" id="location_name" autocomplete="off" placeholder="<?php echo langs('location_name'); ?>" class="form-control num-input">
													</div>
													</div>
												<div class="col-6">
													<div class="form-group">
														<label><?php echo langs('address'); ?></label>
														<input type="text" name="address" id="address" autocomplete="off" placeholder="<?php echo langs('address'); ?>" class="form-control num-input">
													</div>
												</div>
											</div>

											<div id="map"></div>
											<input type="hidden" name="long" id="long">
											<input type="hidden" name="lat" id="lat">
											<script>
												var map = L.map('map').setView([0, 0], 15);

												L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
													attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
													maxZoom: 18,
												}).addTo(map);

												var marker = L.marker([0, 0]).addTo(map);

												function updateMarker() {
													var center = map.getCenter();
													marker.setLatLng(center);

													// Reverse geocoding using Nominatim API
													var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + center.lat + '&lon=' + center.lng;
													fetch(url)
														.then(response => response.json())
														.then(data => {
															var address = data.address;
															var displayAddress = address.road + ', ' + address.city + ', ' + address.country;
															document.getElementById('address').value = displayAddress;

														})

														.catch(error => {
															console.log('Error:', error);
														});
													document.getElementById('long').value = center.lng;
													document.getElementById('lat').value = center.lat;
												}

												function onLocationFound(e) {
													var latlng = e.latlng;
													map.setView(latlng, 15);
													marker.setLatLng(latlng);
													updateMarker();
												}

												function onLocationError(e) {
													console.log(e.message);
												}

												map.on('move', updateMarker);

												// Get user's location
												map.locate({ setView: true, maxZoom: 15 });
												map.on('locationfound', onLocationFound);
												map.on('locationerror', onLocationError);
											</script>

											<input type="hidden" name="issteps" value="yes">
											<br><br>
											<a href=""><button type="button" class="btn btn-rounded btn-primary btn-outline" disabled>
													<?php echo langs('skip'); ?>
												</button></a>
											<button type="submit" class="btn btn-rounded btn-primary btn-outline" style="float:<?php echo langs('next_align'); ?>" id="pn" name="post_now">
												<?php echo langs('finish'); ?>
											</button>
											<div style="text-align:center;">
												<span class="cr ac"></span>
											</div>

									</div>
									</form>
								</div>
							</div>
			</section>

		</div>
	</div>
	<!-- footer -->
	<?php echo view("includes/footer"); ?>
	<!-- /footer -->
</div>
<!-- ./wrapper -->
<!-- endJS --><?php echo view("includes/endJScodes"); ?><!-- /endJS -->
</body>
</html>
