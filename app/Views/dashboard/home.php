<!DOCTYPE html>
<html class="<?php echo view('includes/mode'); ?>">
<head>
	<?php echo view("includes/head_info"); ?>
	<style>
	.aSetup{
		 display: flex;
 }
 .aSetup_item{
		 text-align: center;
		 margin: auto;
 }
 .aSetup_item_empty_wallet{
		 width: 40px;
		 height: 40px;
		 filter: grayscale(100%);
		 background: url('asset/imgs/main_icons/042-wallet.png') no-repeat center center;
		 background-size: 40px;
		 margin: auto;
 }
 .aSetup_item_empty_bank{
		 width: 40px;
 height: 40px;
 filter: grayscale(100%);
 background: url('asset/imgs/main_icons/040-bank.png') no-repeat center center;
 background-size: 40px;
 margin: auto;
 }
 .aSetup_item_empty_buy{
		 width: 40px;
		 height: 40px;
		 filter: grayscale(100%);
		 background: url('asset/imgs/main_icons/012-money bag.png') no-repeat center center;
		 background-size: 40px;
		 margin: auto;
 }
 .aSetup_item_empty_money{
		 width: 40px;
		 height: 40px;
		 filter: grayscale(100%);
		 background: url('asset/imgs/main_icons/046-money.png') no-repeat center center;
		 background-size: 40px;
		 margin: auto;
 }
 .aSetup_item_done1{
		 width: 40px;
		 height: 40px;
		 background: url('asset/imgs/main_icons/042-wallet.png') no-repeat center center;
		 background-size: 40px;
		 margin: auto;
 }.aSetup_item_done2{
			width: 40px;
			height: 40px;
			background: url('asset/imgs/main_icons/040-bank.png') no-repeat center center;
			background-size: 40px;
			margin: auto;
	}.aSetup_item_done3{
			 width: 40px;
			 height: 40px;
			 background: url('asset/imgs/main_icons/012-money bag.png') no-repeat center center;
			 background-size: 40px;
			 margin: auto;
	 }.aSetup_item_done4{
				width: 40px;
				height: 40px;
				background: url('asset/imgs/main_icons/046-money.png') no-repeat center center;
				background-size: 40px;
				margin: auto;
		}
 .aSetup_progrDiv{
		 margin: 10px 15px;
		 background: #e9ebee;
		 border-radius: 50px;
 }
 .aSetup_progrDiv p{
		 width: 10%;
		 background: #4bd37b;
		 margin: 0;
		 font-size: 13px;
		 text-align: center;
		 color: #fff;
		 border-radius: 50px;
		 height: 14px;
 }
	</style>
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

<div id="steps" class="box">
         <div class="box-body">
             <!--==========[ Account Setup ]=========-->
             <div class="aSetup"  align="center">
                 <div class="aSetup_item">
                     <?php
                     $aSetupVal = array();?>
                     <?php

                     $sqlQ_checkCount = $productCount;

                     if ($sqlQ_checkCount > 0) {
                         $cFollowClass = "aSetup_item_done1";
                         $cFollowColor = "color: #4bd37b;";
                         if (!in_array('followPeople', $aSetupVal)) {
                             array_push($aSetupVal,'followPeople');
                         }
                     }else{
                         $cFollowClass = "aSetup_item_empty_wallet";
                         $cFollowColor = "color: #c3c3c3;";
                     }
                     ?>
                     <div class="<?php echo $cFollowClass; ?>"></div>
                     <p style="<?php echo $cFollowColor; ?>">Product</p>
                     <?php if(!in_array('followPeople', $aSetupVal)){ ?><a href="<?php echo base_url(); ?>products/index"><?php echo langs('complete_product') ?></a><?php } ?>
                 </div>
                 <div class="aSetup_item">
                     <?php

                     $sqlQ_checkCounto = $deliverCount;
                     if ($sqlQ_checkCounto > 0) {
                         $cCphotoClass = "aSetup_item_done2";
                         $cCphotoColor = "color: #4bd37b;";
                         if (!in_array('uCoverPhoto', $aSetupVal)) {
                             array_push($aSetupVal,'uCoverPhoto');
                         }
                     }else{
                         $cCphotoClass = "aSetup_item_empty_bank";
                         $cCphotoColor = "color: #c3c3c3;";
                     }
                     ?>
                     <div class="<?php echo $cCphotoClass; ?>"></div>
                     <p style="<?php echo $cCphotoColor; ?>"><?php echo langs('deliver') ?></p>
                     <?php if(!in_array('uCoverPhoto', $aSetupVal)){ ?><a href="<?php echo base_url(); ?>costumers/delivery"><?php echo langs('complete_deliver') ?></a><?php } ?>
                 </div>
                 <div class="aSetup_item">

                     <?php

                     $sqlQ_checkCountg = $blogCount;
                     if ($sqlQ_checkCountg > 0) {
                         $cUphotoClass = "aSetup_item_done3";
                         $cUphotoColor = "color: #4bd37b;";
                         if (!in_array('Userphoto', $aSetupVal)) {
                             array_push($aSetupVal,'Userphoto');
                         }
                     }else{
                         $cUphotoClass = "aSetup_item_empty_buy";
                         $cUphotoColor = "color: #c3c3c3;";
                     }
                     ?>
                     <div class="<?php echo $cUphotoClass; ?>"></div>
                     <p style="<?php echo $cUphotoColor; ?>"><?php echo langs('blog') ?></p>
                     <?php if(!in_array('Userphoto', $aSetupVal)){ ?><a href="<?php echo base_url(); ?>dashboard/blog"><?php echo langs('complete_blog') ?></a><?php } ?>

								 </div>
                 <div class="aSetup_item">
                     <?php

                     $sqlQ_checkCounti = $purchaseCount;
                     if ($sqlQ_checkCounti > 0) {
                         $cInfoClass = "aSetup_item_done4";
                         $cInfoColor = "color: #4bd37b;";
                         if (!in_array('CompleteInfo', $aSetupVal)) {
                             array_push($aSetupVal,'CompleteInfo');
                         }
                     }else{
                         $cInfoClass = "aSetup_item_empty_money";
                         $cInfoColor = "color: #c3c3c3;";
                     } ?>
                     <div class="<?php echo $cInfoClass; ?>"></div>
                     <p style="<?php echo $cInfoColor; ?>"><?php echo langs('purchase') ?></p>
                     <?php if(!in_array('CompleteInfo', $aSetupVal)){ ?><a href="<?php echo base_url(); ?>products/purchase"><?php echo langs('complete_purchase') ?></a><?php } ?>
                 </div>

             </div>
             <div class="aSetup_progrDiv" style="text-align: <?php echo langs('textAlign'); ?>">
                 <?php
                 $aSetupVal = count($aSetupVal);
                 switch ($aSetupVal) {
                     case '1':
                         $aSetupProg = "25";
                         break;
                     case '2':
                         $aSetupProg = "50";
                         break;
                     case '3':
                         $aSetupProg = "75";
                         break;
                     case '4':
                         $aSetupProg = "100";?>
                         <style>#steps{display:none}</style>
                         <?php
                         break;
                     default:
                         $aSetupProg = "0";
                         break;
                 }
                 ?>
                 <p style="width: <?php echo $aSetupProg; ?>%;"><?php if($aSetupProg > 0){echo $aSetupProg.'%';} ?></p>
             </div>

       </div>
   </div>

	 <input type="hidden" id="fetchpost_db" value="deliver">
		<div id="FetchingPostsDiv"></div>
		<!-- post end -->
		<div class="post loading-info" id="LoadingPostsDiv" style="border-radius: 10px">
			<div class="animated-background">
				<div class="background-masker header-top"></div>
				<div class="background-masker header-left"></div>
				<div class="background-masker header-right"></div>
				<div class="background-masker header-bottom"></div>
				<div class="background-masker subheader-left"></div>
				<div class="background-masker subheader-right"></div>
				<div class="background-masker subheader-bottom"></div>
				<div class="background-masker content-top"></div>
				<div class="background-masker content-first-end"></div>
				<div class="background-masker content-second-line"></div>
				<div class="background-masker content-second-end"></div>
				<div class="background-masker content-third-line"></div>
				<div class="background-masker content-third-end"></div>
			</div>
		</div>
		<!-- post load -->
		<div class="post  loading-info" id="NoMorePostsDiv" style="display: none;min-width: 99%;">
			<p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo langs('noMoreStories'); ?></p>
		</div>
		<div class="post loading-info" id="ErrorPosts" style="display: none;min-width: 99%;">
			<p class="alertRed">Some thing went wrong, Please try again later.</p>
		</div>
		<div class="post  loading-info" id="LoadMorePostsBtn" style="display: none;min-width: 99%;">
			<button class="btn btn-primary waves-effect" style="width: 100%" onClick="fetchPosts_DB('deliver')"><?php echo langs('load_more'); ?></button>
		</div>
		<input type="hidden" id="GetLimitOfPosts" value="0">
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
