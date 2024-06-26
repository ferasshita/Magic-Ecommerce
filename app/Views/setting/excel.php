<?php
	Checkadmin(base_url());
 ?>
  <div class="row">
  <div class="col-12">
  <div class="box">
  <div class="box-body">
  <form class="form" id="postingToDB" action="<?php echo base_url();?>Setting/Saveexcel" method="post" enctype="multipart/form-data">

  <!-- name input -->
  <div class="form-group"><label><?php echo lang('Excel'); ?> <a href="<?php echo base_url();?>Asset/upload/product_excel.xlsx" download>Download</a></label>
  <input type="file" name="temp" class="form-control" accept="application/xls,application/xlsx,application/csv">
  </div>


  <div style="padding-top: 21px;">

  <!-- password input -->
  <div class="form-group"><label><?php echo langs('current_password'); ?></label>
  <input type="password"  name="EditProfile_current_pass" placeholder="<?php echo langs('current_password'); ?>" class="form-control">
  </div>
  <div class="loadingPosting"></div>

  <button name="EditProfile_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
  <?php echo langs('save_changes'); ?>
  </button>

  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
