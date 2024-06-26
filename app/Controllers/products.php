<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class products extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();
		Checkadmin(base_url());

}

public function collections(){
	///check login
	Checklogin(base_url());

	$data['page'] = "collections";
	$data['title'] = $data['page'];
	$data['pid'] = $this->request->getGet('pid');

	$data['title'] = "";
  $data['image'] = "";
  $data['description'] = "";

	$uisql = "SELECT * FROM collection WHERE id='".$data['pid']."'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $data['title'] = $postsfetch['title'];
						 $data['description'] = $postsfetch['description'];
						 $data['image'] = $postsfetch['image'];

				 }
	$uisql = "SELECT * FROM collection";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('products/collections',$data);

}
public function inventory(){
	///check login
	Checklogin(base_url());

	$data['page'] = "inventory";
	$data['title'] = $data['page'];

	$uisql = "SELECT * FROM purchase";
 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);
 foreach ($data['fetchdatas'] as $postsfetch ) {
	 $product_id = $postsfetch['product_id'];
	 $variant_id = $postsfetch['variant'];

	 $uisql = "SELECT * FROM product WHERE id='$product_id'";
	 $fetchdata=$this->comman_model->get_all_data_by_query($uisql);
	 foreach ($fetchdata as $postsfetchs ) {
		 $data['product_name'] = $postsfetchs['title'];
		 $data['price'] = $postsfetchs['price'];
		 $data['barcode'] = $postsfetchs['barcode'];
		  $data['number'] = $postsfetchs['number'];
	 }}
	echo view('products/inventory',$data);

}
public function purchase(){
	///check login
	Checklogin(base_url());

	$data['page'] = "purchase";
	$data['title'] = $data['page'];

	$uisql = "SELECT * FROM product";
 $data['fetch_product']=$this->comman_model->get_all_data_by_query($uisql);


	$uisql = "SELECT * FROM purchase";
 $data['fetchdata']=$this->comman_model->get_all_data_by_query($uisql);
 foreach ($data['fetchdata'] as $postsfetch ) {
	 $product_id = $postsfetch['product_id'];
	 $variant_id = $postsfetch['variant'];

	 $uisql = "SELECT title FROM product WHERE id='$product_id'";
	 $fetchdata=$this->comman_model->get_all_data_by_query($uisql);
	 foreach ($fetchdata as $postsfetchs ) {
		  $data['product_name'] = $postsfetchs['title'];
	 }
	 $uisql = "SELECT option_name FROM variant WHERE id='$variant_id'";
	 $fetchdata=$this->comman_model->get_all_data_by_query($uisql);
	 foreach ($fetchdata as $postsfetchs ) {
			$data['variant_name'] = $postsfetch['option_name'];
	 }
}

	echo view('products/purchase',$data);

}
public function discount(){
	///check login
	Checklogin(base_url());

	$data['page'] = "discount";
	$data['title'] = $data['page'];


	echo view('products/discount',$data);

}
public function gift_card(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Gift cards";
	$data['title'] = $data['page'];
	$data['pid'] = $this->request->getGet('pid');

	$data['title'] = "";
	$data['image'] = "";
	$data['description'] = "";
	$data['price'] = "";

	$uisql = "SELECT * FROM gift_card WHERE id='".$data['pid']."'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $data['title'] = $postsfetch['title'];
						 $data['description'] = $postsfetch['description'];
						 $data['image'] = $postsfetch['image'];
						 $data['price'] = $postsfetch['image'];

				 }
	$uisql = "SELECT * FROM gift_card";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('products/gift_card',$data);

}
public function add_variant(){
	$option_name = filter_var(htmlspecialchars($this->request->getPost('option_name')),FILTER_SANITIZE_STRING);
	$id = filter_var(htmlspecialchars($this->request->getPost('id')),FILTER_SANITIZE_STRING);
	if($option_name==NULL){
		echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
		return false;
	}
	if(isset($_FILES['variant_image'])){
	$image = file_upload('variant','variant_image','png|jpeg|jpg|ico','');
	if(!filter_var(base_url().$image, FILTER_VALIDATE_URL)){
		echo "$image";
	return false;
	}
	}else{
		$image = "";
	}
	$data = array(
		'product_id' => $id,
		'option_name' => $option_name,
		'image' => $image,
	);

	$inserted = $this->comman_model->insert_entry("variant", $data);
	if (isset($inserted)) {
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}
}
public function add_purchase(){
	$product = filter_var(htmlspecialchars($this->request->getPost('product')),FILTER_SANITIZE_STRING);
	$variant = filter_var(htmlspecialchars($this->request->getPost('variant')),FILTER_SANITIZE_STRING);
	$quantity = filter_var(htmlspecialchars($this->request->getPost('quantity')),FILTER_SANITIZE_STRING);
	$vendor = filter_var(htmlspecialchars($this->request->getPost('vendor')),FILTER_SANITIZE_STRING);

	if($product==NULL){
		echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
		return false;
	}

	$data = array(
		'user_id' => $_SESSION['id'],
		'product_id' => $product,
		'variant' => $variant,
		'quantity' => $quantity,
		'vendor' => $vendor,
	);

	$inserted = $this->comman_model->insert_entry("purchase", $data);
	$number=0;
	$uisql = "SELECT * FROM product WHERE id='$product'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $number = $postsfetch['number'];
					 }
					 $quantity_val = $number+intval($quantity);
	$data = array(
		'number' => $quantity_val,
	);
	$where=array('id' => $product, 'user_id' => $_SESSION['id']);
	$inserted=$this->comman_model->update_entry("product",$data,$where);

	if (isset($inserted)) {
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}
}
public function add_collection(){
	$title = filter_var(htmlspecialchars($this->request->getPost('title')),FILTER_SANITIZE_STRING);
	$description = filter_var(htmlspecialchars($this->request->getPost('description')),FILTER_SANITIZE_STRING);

	if($title==NULL){
		echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
		return false;
	}

if(isset($_FILES['images'])){
$image = file_upload('collection','images','png|jpeg|jpg|ico','');
if(!filter_var(base_url().$image, FILTER_VALIDATE_URL)){
	echo "$image";
return false;
}
}else{
	$image = "";
}
	$data = array(
		'title' => $title,
		'description' => $description,
		'image' => $image,
	);

	$inserted = $this->comman_model->insert_entry("collection", $data);
	if (isset($inserted)) {
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}
}

public function add_gift_card(){
	$title = filter_var(htmlspecialchars($this->request->getPost('title')),FILTER_SANITIZE_STRING);
	$description = filter_var(htmlspecialchars($this->request->getPost('description')),FILTER_SANITIZE_STRING);
	$price = filter_var(htmlspecialchars($this->request->getPost('price')),FILTER_SANITIZE_STRING);
	$id = filter_var(htmlspecialchars($this->request->getPost('id')),FILTER_SANITIZE_STRING);

if(isset($_FILES['image'])){
$image = file_upload('Asset/upload/collection','image','png|jpeg|jpg|ico','');
if(!filter_var(base_url().$image, FILTER_VALIDATE_URL)){
	echo "$image";
return false;
}
}else{
	$image = "";
}
if($id == NULL) {
	$data = array(
		'user_id' => $_SESSION['id'],
		'title' => $title,
		'description' => $description,
		'image' => $image,
		'price' => $price,
	);
	$inserted = $this->comman_model->insert_entry("gift_card", $data);
}else{
	$data = array(
		'user_id' => $_SESSION['id'],
		'title' => $title,
		'description' => $description,
		'image' => $image,
		'price' => $price,
	);
	$where=array('id' => $id, 'user_id' => $sid);
	$inserted=$this->comman_model->update_entry("gift_card",$data,$where);
}
	if (isset($inserted)) {
		echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
	}
}

public function add_product(){

	$sid=$_SESSION['id'];
$title = filter_var(htmlspecialchars($this->request->getPost('title')),FILTER_SANITIZE_STRING);
$price = filter_var(htmlspecialchars($this->request->getPost('price')),FILTER_SANITIZE_STRING);
if(isset($_POST['description'])){
	$description = $_POST['description'];
}
$compare_price = filter_var(htmlspecialchars($this->request->getPost('compare_price')),FILTER_SANITIZE_STRING);
$track_quantity = filter_var(htmlspecialchars($this->request->getPost('track_quantity')),FILTER_SANITIZE_STRING);
$out_stock = filter_var(htmlspecialchars($this->request->getPost('out_stock')),FILTER_SANITIZE_STRING);
$barcode = filter_var(htmlspecialchars($this->request->getPost('barcode')),FILTER_SANITIZE_STRING);
$shipping_weight = filter_var(htmlspecialchars($this->request->getPost('shipping_weight')),FILTER_SANITIZE_STRING);
$product_catigory = filter_var(htmlspecialchars($this->request->getPost('product_catigory')),FILTER_SANITIZE_STRING);
$product_type = filter_var(htmlspecialchars($this->request->getPost('product_type')),FILTER_SANITIZE_STRING);
$vendor = filter_var(htmlspecialchars($this->request->getPost('vendor')),FILTER_SANITIZE_STRING);
$collection = filter_var(htmlspecialchars($this->request->getPost('collection')),FILTER_SANITIZE_STRING);
$tags = filter_var(htmlspecialchars($this->request->getPost('tags')),FILTER_SANITIZE_STRING);
$id = filter_var(htmlspecialchars($this->request->getPost('id')),FILTER_SANITIZE_STRING);
if($id == NULL){
	$item_id=rand(0,9999999)+time();

}else{
	$item_id=$id;
}
if($title==NULL ||$price==NULL){
	echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
	return false;
}
if(isset($_FILES['images'])){
	$item_file = $_FILES['images'];

	foreach($item_file['tmp_name'] as $key => $tmpName){
		$item_file['name'][$key];

		$post_fileName = $item_file["name"][$key];
		$post_fileTmpLoc = $item_file["tmp_name"][$key];
		$post_fileSize = $item_file["size"][$key];
		$post_fileErrorMsg = $item_file["error"][$key];
		$post_fileName = preg_replace('#[^a-z.0-9]#i', '', $post_fileName);
		$post_kaboom = explode(".", $post_fileName);
		$post_fileExt = end($post_kaboom);
		$post_fileName = time().rand().".".$post_fileExt;

		if (!$post_fileTmpLoc) {
			echo '<p class="error_msg">'.langs('errorPost_n2').'</p>';
			return false;
		}else{
				//================[ if image format not supported ]================
				if (!preg_match("/.(png|jpg|jpeg)$/i", $post_fileName) ) {
					echo '<p class="error_msg">'.langs('errorPost_n4').'</p>';
					unlink($post_fileTmpLoc);
					return false;
				} else {
					//================[ if an error was found ]================
					if ($post_fileErrorMsg == 1) {
						echo '<p class="error_msg">'.langs('errorPost_n5').'</p>';
						return false;
					}else{

						move_uploaded_file($item_file["tmp_name"][$key], "Asset/upload/item/" .$post_fileName);
						$img = "Asset/upload/item/" .$post_fileName;
			$data = array(
			'product_id'   => $item_id,
			'location'   => $img,
		);
		$inserted = $this->comman_model->insert_entry("image",$data);
	}
					}}}
}

if($id == NULL) {
	$data = array(
		'id' => $item_id,
		'user_id' => $sid,
		'title' => $title,
		'price' => $price,
		'description' => $description,
		'compare_price' => $compare_price,
		'track_quantity' => $track_quantity,
		'out_stock' => $out_stock,
		'barcode' => $barcode,
		'shipping_weight' => $shipping_weight,
		'product_catigory' => $product_catigory,
		'product_type' => $product_type,
		'vendor' => $vendor,
		'collection' => $collection,
		'tags' => $tags,
	);
	$inserted = $this->comman_model->insert_entry("product", $data);
}else{
	$data = array(
		'title'   => $title,
		'price'   => $price,
		'description'   => $description,
		'compare_price'   => $compare_price,
		'track_quantity'   => $track_quantity,
		'out_stock'   => $out_stock,
		'barcode'   => $barcode,
		'shipping_weight'   => $shipping_weight,
		'product_catigory'   => $product_catigory,
		'product_type'   => $product_type,
		'vendor'   => $vendor,
		'collection'   => $collection,
		'tags'   => $tags,
	);
	$where=array('id' => $item_id, 'user_id' => $sid);
	$inserted=$this->comman_model->update_entry("product",$data,$where);
}

if (isset($inserted)) {
	echo"<span class='success_msg'>".langs('changes_saved_seccessfully')."</span>";
} else {
	echo"<span class='error_msg'>".langs('errorSomthingWrong')."</span>";
}
}
public function index(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Add product";
	$data['title'] = $data['page'];
	$data['pid'] = $this->request->getGet('pid');

	$data['title'] = "";
  $data['price'] = "";
  $data['description'] = "";
  $data['compare_price'] = "";
  $data['track_quantity'] = "";
  $data['out_stock'] = "";
  $data['barcode'] = "";
 	$data['shipping_weight'] = "";
  $data['product_catigory'] = "";
  $data['product_type'] = "";
  $data['vendor'] = "";
  $data['collection'] = "";
	$data['tags'] = "";

	$uisql = "SELECT * FROM product WHERE id='".$data['pid']."'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $data['title'] = $postsfetch['title'];
						 $data['price'] = $postsfetch['price'];
						 $data['description'] = $postsfetch['description'];
						 $data['compare_price'] = $postsfetch['compare_price'];
						 $data['track_quantity'] = $postsfetch['track_quantity'];
						 $data['out_stock'] = $postsfetch['out_stock'];
						 $data['barcode'] = $postsfetch['barcode'];
						 $data['shipping_weight'] = $postsfetch['shipping_weight'];
						 $data['status'] = $postsfetch['status'];
						 $data['product_catigory'] = $postsfetch['product_catigory'];
						 $data['product_type'] = $postsfetch['product_type'];
						 $data['vendor'] = $postsfetch['vendor'];
						 $data['collection'] = $postsfetch['collection'];
						 $data['tags'] = $postsfetch['tags'];
					 $data['number'] = $postsfetch['number'];
				 }
				 $uisql = "SELECT * FROM image WHERE product_id='".$data['pid']."'";
			 	$data['fetchdatai']=$this->comman_model->get_all_data_by_query($uisql);
				 $uisql = "SELECT * FROM variant WHERE product_id='".$data['pid']."'";
			 	$data['fetchdata']=$this->comman_model->get_all_data_by_query($uisql);

				$uisql = "SELECT * FROM product";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);
			 $uisql = "SELECT * FROM collection";
			$data['fetchdata_collection']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('products/products',$data);

}
}
