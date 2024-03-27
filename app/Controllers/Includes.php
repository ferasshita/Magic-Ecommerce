<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Includes extends Controller {

   public function __construct()
 	{

 			helper(
 				['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']
 		);
    $this->comman_model = new \App\Models\Comman_model();
 			LoadLang();
 			// Your own constructor code


 	}
	public function fetch_posts_home()
	{
		$sid = sessionCI('id');
		$plimit = filter_var(htmlspecialchars($this->request->getPost('plimit')), FILTER_SANITIZE_NUMBER_INT);
		$fPosts_sql_sql = "SELECT * FROM transaction ORDER BY date DESC LIMIT $plimit,10";
		$FetchData=$this->comman_model->get_all_data_by_query($fPosts_sql_sql);
		$view_postsNum = count($FetchData);

		if ($view_postsNum > 0) {
//code
			echo"$view_postsNum hi";
		} else {
			echo "0";
		}

	}
  public function accept_deliver()
	{
		$id = filter_var(htmlspecialchars($this->request->getPost('id')), FILTER_SANITIZE_STRING);

		$sid = sessionCI('id');
		$uisql = "SELECT id FROM orders WHERE id= '$id' AND accept='$sid'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$item_exist = count($udata);

		if($item_exist < 1) {
			$update_info_sql = "UPDATE orders SET accept='$sid' WHERE id= '$id' AND accept='0'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 1;
			}
		}else{
			$update_info_sql = "UPDATE orders SET accept='0' WHERE id= '$id' AND accept='$sid'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 2;
			}
		}
	}
  public function fetch_posts_deliver()
	{
		$sid = sessionCI('id');
		$plimit = filter_var(htmlspecialchars($this->request->getPost('plimit')), FILTER_SANITIZE_NUMBER_INT);
		$items_search = htmlentities($this->request->getPost('mSearch'), ENT_QUOTES);
		if($items_search != NULL) {
			$uisql = "SELECT * FROM orders WHERE id LIKE '%$items_search%'(accept='0' OR accept='$sid') AND pos='0' LIMIT 8";
		}else {
			$uisql = "SELECT * FROM orders WHERE (accept='0' OR accept='$sid') AND pos='0' ORDER BY date DESC LIMIT $plimit,10";
		}
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$view_postsNum = count($udata);
		if ($view_postsNum > 0) {
		foreach ($udata as $postsfetch) {
			$id = $postsfetch['id'];
			$location = $postsfetch['location'];
      $accept = $postsfetch['accept'];
			$shop_finish = $postsfetch['shop_finish'];
			$date = strtotime($postsfetch['date']);
      $address="";
			$uisql = "SELECT * FROM locations WHERE id= '$location'";
			$udata=$this->comman_model->get_all_data_by_query($uisql);
			foreach ($udata as $postsfetchi) {
				$address = $postsfetchi['address'];
			}
			?>
			 <div class="box">
					<div class="box-header">
						<h4><a href="<?php echo base_url();?>theme/order?pid=<?php echo $id; ?>" class="none-link"><span class="font-size-20">#<?php echo $id; ?></span></a>
              <?php if(sessionCI('account_type') == "deliver" && $shop_finish == 0){ ?>
							<button type="button" id="accept_btn<?php echo $id; ?>" onclick="accept_deliver('<?php echo $id; ?>')" class="btn float-right <?php if($accept == '0'){ ?>btn-primary<?php }else{ ?>btn-info<?php } ?>"><?php if($accept == '0'){ ?><?php echo langs('accept'); ?><?php }else{ ?><?php echo langs('cancel'); ?><?php } ?></button>
<?php } ?>
            </h4>
					</div>
				 <a href="<?php echo base_url();?>theme/order?pid=<?php echo $id; ?>" class="none-link">
					<div class="box-body">
						<p><span class="font-size-16"><?php echo $address; ?></span> <small>(<?php echo time_ago($date); ?>)</small></p>
					</div>
				 </a>
				</div>
		<?php }}else{
			echo 0;
		}
	}
  public function fetch_table()
	{
    $table = htmlentities($this->request->getPost('table'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $filter = htmlentities($this->request->getPost('filter'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo table_view($table,$column,$filter);
        echo "<!-- /dont_write -->";
	}
  public function count_table()
  {
    $table = htmlentities($this->request->getPost('table'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $value = htmlentities($this->request->getPost('value'), ENT_QUOTES);
    $sid = htmlentities($this->request->getPost('sid'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo count_table($table,$column,$value,$sid);
    echo "<!-- /dont_write -->";
  }
  public function browsing()
  {
    $table_name = htmlentities($this->request->getPost('table_name'), ENT_QUOTES);
    $column = htmlentities($this->request->getPost('column'), ENT_QUOTES);
    $id = htmlentities($this->request->getPost('id'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    echo browsing($table_name,$column,$id);
        echo "<!-- /dont_write -->";
  }
  public function blog()
  {
    $blog = htmlentities($this->request->getPost('blog'), ENT_QUOTES);
    echo "<!-- dont_write -->";
    if($blog != ""){
      $blog_sql = " WHERE blog='$blog'";
    }else{
      $blog_sql = "";
    }
     $uisql = "SELECT * FROM blog $blog_sql";
    					$udata=$this->comman_model->get_all_data_by_query($uisql);
    					foreach ($udata as $postsfetch ) {
    					$id = $postsfetch['id'];
    					$title = $postsfetch['title'];
    					$blog_img = $postsfetch['blog_img'];
    ?>

    						<div class="col-md-6 col-12">
    							<div class="box">
    								<a href="<?php echo base_url()."home/blog/".$id; ?>"><div class="box-body" style="background: url('<?php echo base_url().$blog_img; ?>') center center / cover no-repeat;">
    									</div></a>
    								<div class="box-header">
    <h3><a href="<?php echo base_url()."home/blog/".$id; ?>"><?php echo $title; ?></a> </h3>
    								</div>
    							</div>
    						</div>

    					<?php }
                echo "<!-- /dont_write -->";
  }
  public function fetch_posts_item_view()
  {
  	$sid = sessionCI('id');

  	$collection = htmlentities($this->request->getPost('collection'), ENT_QUOTES);
  	$items_search = htmlentities($this->request->getPost('items_search'), ENT_QUOTES);
  	if($collection != NULL){
  		$collection_sql = "collection='$collection'";
  	}else {
  		$collection_sql = 1;
  	}
  	if($items_search != NULL) {
  		$fPosts_sql_sql = "SELECT * FROM product WHERE $collection_sql AND title LIKE '%$items_search%'";
  	}else {
  		$fPosts_sql_sql = "SELECT * FROM product WHERE $collection_sql ORDER BY date DESC";
  	}
  	$FetchData=$this->comman_model->get_all_data_by_query($fPosts_sql_sql);
  	$view_postsNum = count($FetchData);
  	if ($view_postsNum > 0) {
  			foreach ($FetchData as $postsfetch) {
  			$id = $postsfetch['id'];
  			$title = $postsfetch['title'];
  			$description = $postsfetch['description'];
  			$price = $postsfetch['price'];
  			$sale = $postsfetch['compare_price'];
  			$number = $postsfetch['number'];
  			if($number > 0){
  				$available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
  			}else{
  				$available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."Not available</span>";
  			}

  				$uisql = "SELECT id FROM cart WHERE item_id= '$id' AND user_id='$sid' AND order_id='0'";
  				$udata=$this->comman_model->get_all_data_by_query($uisql);
  				$cart_item = count($udata);

  				$uisql = "SELECT id FROM item_like WHERE item_id= '$id' AND user_id='$sid'";
  				$udata=$this->comman_model->get_all_data_by_query($uisql);
  				$like_item = count($udata);

  				$hashtags_url = '/(\www.)([x00-\xFF]+[a-zA-Z0-9x00-\xFF_\w\.com]+)/';
  				$body = preg_replace($hashtags_url, "<a href='../$2' title='www.$2'>www.$2<i class='fa fa-link'></i></a>", $description);
  				$body = nl2br("$body");

  					if (strlen($body) > 300) {
  						$body2 = substr($body, 0,300)."... ".lang("continue_reading");
  					}else{
  						$body2 = "$body";
  					}
  					$quantity_val=1;
  		?>
  		 <div class="box">
  			 <div class="item-profile-grid">
  					<a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $id; ?>" class="none-link">
  					<div style="background: url('<?php echo base_url().img_output($id); ?>') no-repeat center center;height: 100% !important;width: 97% !important;" class="tabs-vertical side-product">
  					</div>
  					</a>

  					 <div class="padding-10">
  						 <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $id; ?>" style="color:black" class="none-link">
  						 <h4><span class="font-size-20"><?php echo $title; ?></span> <span style="color:green"><?php echo $price." LYD</span> ".$available; ?></h4>
  						 <p class="mo-none"><?php echo $body2; ?></p>
  				 </a>
  				 <button <?php if(NULL !== (sessionCI('id'))){?>disabled<?php } ?> id="add_cart_<?php echo $id; ?>" onclick="addCart('<?php echo $id; ?>')" class="btn <?php if($cart_item < 1){ ?>btn-primary<?php }else{ ?>btn-info<?php } ?>"><?php if($cart_item < 1){ ?><?php echo langs('add_cart'); ?><?php }else{ ?><?php echo langs('added_cart'); ?>!<?php } ?></button>
  				 <button style="color: red" <?php if(NULL !== (sessionCI('id'))){?>disabled<?php } ?> id="item_like_<?php echo $id; ?>" onclick="itemLike('<?php echo $id; ?>')" class="btn <?php if($like_item < 1){ ?>fa fa-heart-o<?php }else{ ?>fa fa-heart<?php } ?> btn-white border-dark"></button>
  			</div>
  			</div>
  			</div>
  <?php
  	}} else {
  		echo "0";
  	}

  }
	public function delete_transaction()
	{
		$c_id = htmlentities($this->request->getPost('cid'), ENT_QUOTES);
		$table = htmlentities($this->request->getPost('table'), ENT_QUOTES);

		$delete_comm_sql = "DELETE FROM $table WHERE id = $c_id";
		$IsUpdate=$this->comman_model->run_query($delete_comm_sql);
		echo "done";
	}
	public function mode()
	{
    $id = sessionCI('id');
    $dhsh = date("H");

if($_SESSION['mode'] == "light" || ($_SESSION['mode'] == "auto" && $dhsh>=4&&$dhsh<=18)){
$mode = "night";
}else{
$mode = "light";
}
     $update_info_sql = "UPDATE signup SET mode= '$mode' WHERE id= '$id'";
     $update_info=$this->comman_model->run_query($update_info_sql);

         $_SESSION['mode'] = $mode;

echo"yes";
	}
}
