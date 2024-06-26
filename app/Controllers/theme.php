<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class theme extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();

}
public function add_costumer(){
	if($_ENV['REGISTER_FORM'] == 'TRUE'){
	$name = filter_var(htmlentities($this->request->getPost('name')),FILTER_SANITIZE_STRING);
	$email = filter_var(htmlentities($this->request->getPost('email')),FILTER_SANITIZE_STRING);
	$phone = filter_var(htmlentities($this->request->getPost('phone')),FILTER_SANITIZE_STRING);
	$address = filter_var(htmlentities($this->request->getPost('address')),FILTER_SANITIZE_STRING);
	$long = filter_var(htmlentities($this->request->getPost('long')),FILTER_SANITIZE_STRING);
	$lat = filter_var(htmlentities($this->request->getPost('lat')),FILTER_SANITIZE_STRING);

	function getData($url,$dataArray){
		$ch = curl_init();
		$data = http_build_query($dataArray);
		$getUrl = $url."?".$data;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		$response = curl_exec($ch);
		if(curl_error($ch)){
			return 'Request Error:' . curl_error($ch);
		}else{
			return json_decode($response,true);
		}
		curl_close($ch);
	}

	if($_ENV['CAPTCHA'] == "TRUE"){
		$urlGoogleCaptcha = 'https://www.google.com/recaptcha/api/siteverify';
		$checkkey = $_ENV['GOOGLE_CAPTCHA_SECRET_KEY'];
		$recaptchaSecretKey = $checkkey;
		$verficationResponse = $this->request->getPost('recaptchaResponses');
		$dataArray = [
			'secret'=>$recaptchaSecretKey,
			'response'=>$verficationResponse
		];
		$recaptchaResonse = getData($urlGoogleCaptcha,$dataArray);
		if(is_array($recaptchaResonse))
		{
			if($recaptchaResonse['success'] == 1)
			{}else{
				//google returns false;
				echo "<p class='alertRed'>".json_encode(['msg'=>'Google reCaptcha Error'])."</p>";
				return false;
			}
		}else{
			//issue in curl request
			echo "<p class='alertRed'>".json_encode(['msg'=>'Error with google'])."</p>";
			return false;
		}
	}
	if($name == null || $email == null || $phone == null || $long == null || $lat == null || $address == null){
		echo "<p class='alertRed'>".langs('please_fill_required_fields')."</p>";
		return false;
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<p class='alertRed'>".langs('invalid_email_address')."</p>";
		return false;
	}elseif ((!preg_match('/[0-9]/', $phone) || strlen($phone) < 6)) {
		echo "<p class='alertRed'>".langs('invalid_phone_number')."</p>";
		return false;
	}

	$data = array(
		'name'      => $name,
		'email'	=>	$email,
		'phone'	=>	$phone,
		'address'	=>	$address,
		'long'	=>	$long,
		'lat'	=>	$lat,
	);
	$insert_post_toDBi = $this->comman_model->insert_entry("costumers",$data);
	echo "<p class='alertGreen'>".langs('done')."</p>";
}
}
public function order(){
	///check login
	if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
	return redirect()->to(base_url()."dashboard");
	}
	Checklogin(base_url());

	$data['pid'] = filter_var(htmlentities($this->request->getGet('pid')),FILTER_SANITIZE_STRING);
	$data['page'] = "Order #".$data['pid'];
	$data['title'] = $data['page'];

	$data['location']="";
	$data['user_id'] ="";
	$sid = sessionCI('id');
	if(file_exists('src/order.html')){
		$html = file_get_contents('src/order.html');
	}else{
		$html = file_get_contents('missing/order.html');
	}

	echo view("includes_site/head_info", $data);


			$uisql = "SELECT * FROM orders WHERE id= '".$data['pid']."'";
			$udata=$this->comman_model->get_all_data_by_query($uisql);
			$item_exist = count($udata);
			foreach ($udata as $postsfetch) {
				$order_id = $postsfetch['id'];
				$user_id = $postsfetch['user_id'];
				$location = $postsfetch['location'];
				$accept = $postsfetch['accept'];
				$shop_finish = $postsfetch['shop_finish'];
				$date = $postsfetch['date'];
				$html= preg_replace('/{%order_id%}/s', $postsfetch['id'], $html);
				$html= preg_replace('/{%order_note%}/s', $postsfetch['note'], $html);
				$html= preg_replace('/{%order_date%}/s', $postsfetch['date'], $html);
				$html= preg_replace('/{%time_ago%}/s', time_ago(strtotime($postsfetch['date'])), $html);

			}

$distance=0;
$uisql = "SELECT * FROM locations WHERE id= '".$location."'";
$location=$this->comman_model->get_all_data_by_query($uisql);
foreach ($location as $postsfetch) {
	$html= preg_replace('/{%costumer_lat%}/s', $postsfetch['lat'], $html);
	$html= preg_replace('/{%costumer_long%}/s', $postsfetch['long'], $html);
	$html= preg_replace('/{%costumer_address%}/s', $postsfetch['address'], $html);
	$distance = number_format(calculateDistance($postsfetch['lat'], $postsfetch['long'], $_ENV['LAT'], $_ENV['LONG']), 1);
	$distance = str_replace(",", "", $distance);

}

$uisql = "SELECT * FROM signup WHERE id= '".$user_id."'";
$costumer=$this->comman_model->get_all_data_by_query($uisql);
	foreach ($costumer as $postsfetch) {
		$html= preg_replace('/{%costumer_name%}/s', $postsfetch['username'], $html);
		$html= preg_replace('/{%costumer_phone%}/s', $postsfetch['phone'], $html);
		$html= preg_replace('/{%costumer_email%}/s', $postsfetch['email'], $html);
		}
		$html= preg_replace('/{%project_name%}/s', $_ENV['PROJECT_NAME'], $html);
		$html= preg_replace('/{%shop_phone%}/s', $_ENV['PHONE_NUMBER'], $html);

		$html .= "
		<script>
			var array = [{%items%}];
			var edited = document.getElementById('cart_items').innerHTML;
			document.getElementById('cart_items').innerHTML='';
		array.forEach((data)=>{

		const edited_a = edited.replace(/{%items_id%}/g, data.id);
		const edited_b = edited_a.replace(/{%items_title%}/g, data.title);
		const edited_c = edited_b.replace(/{%items_description%}/g, data.description);
		const edited_d = edited_c.replace(/{%items_price%}/g, data.price);
		const edited_e = edited_d.replace(/{%items_compare_price%}/g, data.compare_price);
		const edited_f = edited_e.replace(/{%items_available%}/g, data.available);
		const edited_g = edited_f.replace(/{%product_type%}/g, data.product_type);
		const edited_h = edited_g.replace(/{%item_quantity%}/g, data.item_quantity);
		const edited_i = edited_h.replace(/{%product_catigory%}/g, data.product_catigory);
		const edited_j = edited_i.replace(/{%collection%}/g, data.collection);
		const edited_k = edited_j.replace(/{%item_image%}/g, data.item_image);

		$('#cart_items').append(edited_k);
		});

			</script>
			";

		$quantity = 0;
		$quantity_val = 0;
		$item_data="";
		$sum_price =0;
$uisql = "SELECT item_id, quantity FROM cart WHERE order_id='".$data['pid']."' ORDER BY date DESC";
$udata=$this->comman_model->get_all_data_by_query($uisql);
foreach ($udata as $postsfetch) {
$item_id = $postsfetch['item_id'];
$quantity = $postsfetch['quantity'];
$uisql = "SELECT * FROM product WHERE id= '$item_id'";
$ydata=$this->comman_model->get_all_data_by_query($uisql);
foreach ($ydata as $postsfetchi) {
$id = $postsfetchi['id'];
$title = $postsfetchi['title'];
$description = $postsfetchi['description'];
$price = $postsfetchi['price'];
$compare_price = $postsfetchi['compare_price'];
$product_type = $postsfetchi['product_type'];
$product_catigory = $postsfetchi['product_catigory'];
$collection = $postsfetchi['collection'];
$number = $postsfetchi['number'];
if($number > 0){
	$available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
}else{
	$available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
}
$uisql = "SELECT location FROM image WHERE product_id= '$item_id'";
$ydata=$this->comman_model->get_all_data_by_query($uisql);
foreach ($ydata as $postsfetchx) {
	$image_location = base_url().$postsfetchx['location'];
}
$quantity_val += $quantity;
$sum_price += $price*$quantity;
	$item_data.= "{id:'".$id."',title:'".$title."', description:'".$description."', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','item_quantity':".$quantity.",'product_catigory':'".$product_catigory."','collection':'".$collection."','item_image':'".$image_location."'},";

}
}
$html= preg_replace('/{%items%}/s', $item_data, $html);
$html= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $html);


$html= preg_replace('/{%distance%}/s', $distance, $html);
if($_ENV['DELIVERY_TYPE'] == "1"){
	$deliver_price = $distance*$_ENV['DELIVERY_PRICE'];
}elseif($_ENV['DELIVERY_TYPE'] == "2"){
	$deliver_price = $_ENV['DELIVERY_PRICE'];
}
$html= preg_replace('/{%deliver_price%}/s', $deliver_price, $html);

$html= preg_replace('/{%quantity%}/s', $quantity_val, $html);
$html= preg_replace('/{%sum_price%}/s', $sum_price, $html);
$branch_total = $sum_price+$deliver_price;

$html= preg_replace('/{%branch_total%}/s', $branch_total, $html);

 if($_SESSION['account_type'] == "deliver" && $shop_finish == 0){
 if($accept == '0' || $accept == $sid){
	$html= preg_replace('/{%order_button%}/s', "<button type=\"button\" id=\"accept_btn$order_id\" onclick=\"accept_deliver('$order_id')\" class=\"btn ".($accept == '0'? "btn-primary":"btn-info")."\"> ".($accept == '0'?"".langs('accept')."":"".langs('cancel')."")."</button>", $html);
 }elseif($accept != $sid){
		$html= preg_replace('/{%order_button%}/s', "<button type=\"button\" class=\"btn btn-primary\" disabled>".langs('order_taken')."</button>", $html);
	 }
 }elseif($_SESSION['account_type'] == "admin"){
 if($accept == '0'){
	$html= preg_replace('/{%order_button%}/s', "<button type=\"button\" id=\"give_btn$order_id\" class=\"btn btn-primary\" disabled>".langs('no_deliver')."</button>", $html);
 }else{
		$html= preg_replace('/{%order_button%}/s', "<button type=\"button\" id=\"give_btn$order_id\" onclick=\"giveDeliver('$order_id')\" class=\"btn ".($shop_finish == '0'?'btn-primary':'btn-info')." \">". ($shop_finish == '0'?"".langs('give_deliver')."":"".langs('cancel')."")."</button>", $html);
	 }
 }else{
	 $html= preg_replace('/{%order_button%}/s', "", $html);

 }


	if($item_exist > 0){
		echo $html;
	}else{
		echo view("errors/missing_page",$data);
	}
		echo view("includes_site/endJScodes", $data);
}
public function add_cart(){
	$item_id = htmlspecialchars($this->request->getPost('item_id'), ENT_QUOTES);
	$variant = filter_var(htmlentities($this->request->getPost('variant')),FILTER_SANITIZE_STRING);
	$variant = str_replace("undefined", "", $variant);
if($variant == NULL){
	$variant =0;
}
if($item_id == NULL){
	$item_id =0;
}
	$sid = sessionCI('id');
	if($sid == NULL){
		$sid=ip2bigint($this->request->getIPAddress());
	}
	$uisql = "SELECT id FROM cart WHERE item_id= '$item_id' AND order_id='0' AND user_id='$sid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$item_exist = count($udata);
	$uisql = "SELECT user_id FROM product WHERE id= '$item_id'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch) {
		$shop_id = $postsfetch['user_id'];
	}

	if($item_exist < 1) {
		$data = array(
			'user_id'      => $sid,
			'item_id'	=>	$item_id,
			'quantity'	=>	'1',
			'variants'	=>	$variant,
		);
		$insert_post_toDBi = $this->comman_model->insert_entry("cart",$data);

		if ($insert_post_toDBi){
			echo 1;
		}
	}else{
		$delete_comm_sql = "DELETE FROM cart WHERE item_id = '$item_id' AND user_id='$sid' AND order_id='0'";
		$IsUpdate=$this->comman_model->run_query($delete_comm_sql);
		if ($IsUpdate){
			echo 2;
		}
	}

}
public function give_deliver()
	{
		$id = filter_var(htmlspecialchars($this->request->getPost('id')), FILTER_SANITIZE_STRING);
		global $sum_price;
		$sid = $_SESSION['id'];
		$uisql = "SELECT id FROM orders WHERE id= '$id' AND shop_finish='1'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$item_exist = count($udata);

		if($item_exist < 1) {
			$update_info_sql = "UPDATE orders SET shop_finish='1' WHERE id= '$id' AND shop_finish='0'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 1;
			}
		}else{
			$update_info_sql = "UPDATE orders SET shop_finish='0' WHERE id= '$id' AND shop_finish='1'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 2;
			}
		}
	}
public function add_sum_cart()
	{
		$id = filter_var(htmlspecialchars($this->request->getPost('id')), FILTER_SANITIZE_STRING);
		$result = filter_var(htmlspecialchars($this->request->getPost('result')), FILTER_SANITIZE_STRING);
		$sid = sessionCI('id');
		if($sid == NULL){
			$sid=ip2bigint($this->request->getIPAddress());
		}

		if($result > 0) {
			$update_info_sql = "UPDATE cart SET quantity='$result' WHERE item_id= '$id' AND order_id='0' AND user_id='$sid'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 1;
			}
		}else{
			$update_info_sql = "DELETE FROM cart WHERE item_id= '$id' AND order_id='0' AND user_id='$sid'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			if ($update_info){
				echo 2;
			}
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
	public function item_like()
	{
		$sid = sessionCI('id');
		$item_id = filter_var(htmlspecialchars($this->request->getPost('id')), FILTER_SANITIZE_STRING);

		$sid = sessionCI('id');
		if($sid == NULL){
			$sid=ip2bigint($this->request->getIPAddress());
		}
		$uisql = "SELECT id FROM item_like WHERE item_id= '$item_id'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$item_exist = count($udata);

		if($item_exist < 1) {
			$iptdbsqli = "INSERT INTO item_like
  (user_id, item_id)
  VALUES
  ($sid, $item_id)
  ";
	$insert_post_toDBi = $this->comman_model->run_query($iptdbsqli);
			if ($insert_post_toDBi){
				echo 1;
			}
		}else{
			$delete_comm_sql = "DELETE FROM item_like WHERE item_id = '$item_id' AND user_id='$sid'";
			$IsUpdate=$this->comman_model->run_query($delete_comm_sql);
			if ($IsUpdate){
				echo 2;
			}
		}
	}
public function add_order(){
	$sid = sessionCI('id');
	if($sid == NULL){
    $sid=ip2bigint($this->request->getIPAddress());
  }
	$order_id_field = filter_var(htmlspecialchars($this->request->getPost('order_id')), FILTER_SANITIZE_STRING);
	$order_note = filter_var(htmlspecialchars($this->request->getPost('order_note')), FILTER_SANITIZE_STRING);
	$promocode = filter_var(htmlspecialchars($this->request->getPost('promocode')), FILTER_SANITIZE_STRING);
	$pos_check=0;
if($order_id_field == NULL && sessionCI('account_type') == "admin"){
	$order_id_field = rand(0,99999);
	$pos_check = 23;
	$pos_value = 1;
}else{
	$pos_value = 0;
}
	$uisql = "SELECT id FROM orders WHERE user_id= '$sid' AND id='$order_id_field'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$item_exist = count($udata);

$location =0;
	$uisql = "SELECT id FROM locations WHERE user_id= '$sid' AND my_location= 1";
	$udata = $this->comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch) {
		$location = $postsfetch['id'];
	}
	if($_ENV['REGISTER_FORM'] == 'TRUE' && sessionCI('id')==NULL){
	$name = filter_var(htmlentities($this->request->getPost('name')),FILTER_SANITIZE_STRING);
	$email = filter_var(htmlentities($this->request->getPost('email')),FILTER_SANITIZE_STRING);
	$phone = filter_var(htmlentities($this->request->getPost('phone')),FILTER_SANITIZE_STRING);
	$address = filter_var(htmlentities($this->request->getPost('address')),FILTER_SANITIZE_STRING);
	$long = filter_var(htmlentities($this->request->getPost('long')),FILTER_SANITIZE_STRING);
	$lat = filter_var(htmlentities($this->request->getPost('lat')),FILTER_SANITIZE_STRING);

	function getData($url,$dataArray){
		$ch = curl_init();
		$data = http_build_query($dataArray);
		$getUrl = $url."?".$data;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		$response = curl_exec($ch);
		if(curl_error($ch)){
			return 'Request Error:' . curl_error($ch);
		}else{
			return json_decode($response,true);
		}
		curl_close($ch);
	}

	if($_ENV['CAPTCHA'] == "TRUE"){
		$urlGoogleCaptcha = 'https://www.google.com/recaptcha/api/siteverify';
		$checkkey = $_ENV['GOOGLE_CAPTCHA_SECRET_KEY'];
		$recaptchaSecretKey = $checkkey;
		$verficationResponse = $this->request->getPost('recaptchaResponses');
		$dataArray = [
			'secret'=>$recaptchaSecretKey,
			'response'=>$verficationResponse
		];
		$recaptchaResonse = getData($urlGoogleCaptcha,$dataArray);
		if(is_array($recaptchaResonse))
		{
			if($recaptchaResonse['success'] == 1)
			{}else{
				//google returns false;
				echo "<p class='alertRed'>".json_encode(['msg'=>'Google reCaptcha Error'])."</p>";
				return false;
			}
		}else{
			//issue in curl request
			echo "<p class='alertRed'>".json_encode(['msg'=>'Error with google'])."</p>";
			return false;
		}
	}
	if($name == null || $email == null || $phone == null || $address == null){
		echo langs('please_fill_required_fields');
		return false;
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo langs('invalid_email_address');
		return false;
	}elseif ((!preg_match('/[0-9]/', $phone) || strlen($phone) < 6)) {
		echo langs('invalid_phone_number');
		return false;
	}

	$data = array(
		'name'      => $name,
		'email'	=>	$email,
		'phone'	=>	$phone,
		'address'	=>	$address,
		'long'	=>	$long,
		'lat'	=>	$lat,
		'ip'	=> ip2bigint($this->request->getIPAddress()),
	);
	$insert_post_toDBi = $this->comman_model->insert_entry("costumers",$data);
}
	if($pos_check == 23){
		$location = 0;
		$accept = $sid;
		$shop_finish = $sid;
	}else{
		$accept = 0;
		$shop_finish = 0;
	}
	$number = 0;
	$out_stock = "";
	if($item_exist < 1) {
		$uisql = "SELECT id,quantity,item_id FROM cart WHERE order_id='0' AND user_id='$sid'";
		$udata = $this->comman_model->get_all_data_by_query($uisql);
		foreach ($udata as $postsfetch) {
			$item_id = $postsfetch['item_id'];
			$quantity = $postsfetch['quantity'];
			$uisql = "SELECT number,title,track_quantity,out_stock FROM product WHERE id='$item_id'";
			$udata = $this->comman_model->get_all_data_by_query($uisql);
			foreach ($udata as $postsfetchi) {
				$number = $postsfetchi['number'];
				$title = $postsfetchi['title'];
				$track_quantity = $postsfetchi['track_quantity'];
				$out_stock = $postsfetchi['out_stock'];
			}
			$new_number = $number-$quantity;
			if($new_number < 0 && ($out_stock == 0)){
				echo "only ".$number." left of ".$title;
				return false;
			}
			$update_info_sql = "UPDATE product SET number= '$new_number' WHERE id='$item_id'";
			$update_info=$this->comman_model->run_query($update_info_sql);
		}
		$data = array(
			'id'   => $order_id_field,
			'user_id'      => $sid,
			'location'	=>	$location,
			'accept'	=>	$accept,
			'shop_finish'	=>	$shop_finish,
			'note'	=>	$order_note,
			'discount_code'	=>	$promocode,
			'pos'	=>	$pos_value,
		);
		$insert_post_toDBi = $this->comman_model->insert_entry("orders",$data);

		$update_info_sql = "UPDATE cart SET order_id= '$order_id_field' WHERE order_id='0' AND user_id='$sid'";
		$update_info=$this->comman_model->run_query($update_info_sql);

		if ($insert_post_toDBi){
			echo 1;
		}
	}else{
		// you can cancel before 2:00 mins
		$uisql = "SELECT date FROM orders WHERE user_id= '$sid' AND id='$order_id_field'";
		$udata = $this->comman_model->get_all_data_by_query($uisql);
		foreach ($udata as $postsfetch) {
			$date = $postsfetch['date'];
		}
		$d1 = strtotime("$date +2 minutes");
		$d2 = (($d1)-time())/60;
		if($d2 > 0) {
			$delete_comm_sql = "DELETE FROM orders WHERE user_id = '$sid' AND id='$order_id_field'";
			$IsUpdate = $this->comman_model->run_query($delete_comm_sql);

			$update_info_sql = "UPDATE cart SET order_id= '0' WHERE order_id='$order_id_field' AND user_id='$sid'";
			$update_info = $this->comman_model->run_query($update_info_sql);

			$uisql = "SELECT id FROM cart WHERE order_id='$order_id_field' AND user_id='$sid'";
			$udata = $this->comman_model->get_all_data_by_query($uisql);
			foreach ($udata as $postsfetch) {
				$item_id = $postsfetch['item_id'];
				$quantity = $postsfetch['quantity'];
				$uisql = "SELECT number FROM item WHERE id='$item_id'";
				$udata = $this->comman_model->get_all_data_by_query($uisql);
				foreach ($udata as $postsfetchi) {
					$number = $postsfetchi['number'];
				}
				$new_number = $number+$quantity;
				$update_info_sql = "UPDATE item SET number= '$new_number' WHERE item_id='$item_id'";
				$update_info=$this->comman_model->run_query($update_info_sql);
			}
			if ($IsUpdate) {
				echo 2;
			}
		}
	}
}
public function cart(){

	$data['pid'] = $this->request->getGet('pid');
	$pid = $data['pid'];
	$sid = sessionCI('id');
	$data['user_id'] = sessionCI('id');
	$order_location = '';
	$data['page'] = "cart";
	$data['title'] = "cart";
	$data['order_location'] ="";
	$data['discount_code'] = "";

	$promocode=filter_var(htmlentities($this->request->getGet('promocode')), FILTER_SANITIZE_STRING);
$data['discount_code']=$promocode;
	if($sid == NULL){
    $sid=ip2bigint($this->request->getIPAddress());
  }else{
		$data['sid'] = $sid;
	}
	if($pid!=NULL && (sessionCI('account_type') == 'admin' || sessionCI('account_type') == 'deliver')){
$sid_loc="";
}else{
	$sid_loc = " AND user_id= '$sid'";
}

  $order_location = '';

$costumer_id='';
$data['discount_type']='';
$data['discount_value_x']='';
$data['discount_value_y']='';
$data['discount_value_z']='';
$data['minimum_purchase']='';
	$time_st=time();


	$data['date']="";
	$data['costumer_location_name']="default";
	$data['accept'] ="";
	$data['note'] = "";
	$data['shop_finish'] = "";

$data['pos']=0;

	$uisql = "SELECT * FROM orders WHERE id='$pid' $sid_loc AND id!='0'";
	$udata = $this->comman_model->get_all_data_by_query($uisql);
	$data['isOrder'] = count($udata);
	foreach ($udata as $postsfetch) {
		$order_location = $postsfetch['location'];
		$costumer_id = $postsfetch['user_id'];
		$data['date'] = $postsfetch['date'];
		$data['accept'] = $postsfetch['accept'];
		$data['note'] = $postsfetch['note'];
		$data['shop_finish'] = $postsfetch['shop_finish'];
		$data['discount_code'] = $postsfetch['discount_code'];
		$data['pos'] = $postsfetch['pos'];
		$data['costumer_id']=$costumer_id;
	}
	$uisql = "SELECT type,x,y,z,minimum_purchase FROM discount WHERE code='$promocode' OR code='".$data['discount_code']."' AND $time_st <= CAST(to_date AS DATE)";
	$udata = $this->comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch) {
		$data['discount_type']=$postsfetch['type'];
		$data['discount_value_x']=$postsfetch['x'];
		$data['discount_value_y']=$postsfetch['y'];
		$data['discount_value_z']=$postsfetch['z'];
		$data['minimum_purchase']=$postsfetch['minimum_purchase'];

	}
	$data['costumer_long']='';
$data['costumer_lat']='';
  		if($pid != NULL && $data['isOrder'] > 0){
				$uisql = "SELECT * FROM signup WHERE id= '".$costumer_id."'";
				$costumer=$this->comman_model->get_all_data_by_query($uisql);
				$costumer_count=count($costumer);
					foreach ($costumer as $postsfetch) {
						$data['costumer_name'] = $postsfetch['username'];
						$data['costumer_phone']=$postsfetch['phone'];
						$data['costumer_email']=$postsfetch['email'];
						}
		if($costumer_count ==0){
		$uisql = "SELECT * FROM costumers WHERE ip= '".$costumer_id."'";
		$costumer=$this->comman_model->get_all_data_by_query($uisql);
			foreach ($costumer as $postsfetch) {
				$data['costumer_name'] = $postsfetch['name'];
				$data['costumer_phone']=$postsfetch['phone'];
				$data['costumer_email']=$postsfetch['email'];
				$data['costumer_lat']=$postsfetch['lat'];
				$data['costumer_long']=$postsfetch['long'];
				$data['costumer_address']=$postsfetch['address'];
				}
		}

  			$data["order_id"] = $pid;
				$data["page_name"] = "Order #$pid";
  			$data["order_id_btn"] = $pid;
  		}else{
				$costumer_id = $sid;
					$data['costumer_id'] = $sid;
  			$data["order_id"] = '0';
  			$data["page_name"] = "Cart";
				$data["order_id_btn"] = '';
  		}
			$order_id=$data["order_id"];
  		//$data["page_name"]["name"] = $page_name;
  		if($order_location == NULL){
  			$order_location_sql = 'AND my_location = 1';
  		}else{
  			$order_location_sql = "AND id='$order_location'";
  		}
  		$distance=0;
  	$uisql = "SELECT * FROM locations WHERE user_id= '$costumer_id' $order_location_sql";
  	$udata=$this->comman_model->get_all_data_by_query($uisql);
    $count_cos_info=count($udata);
  	foreach ($udata as $postsfetch) {
  		$data['costumer_address']=$postsfetch['address'];
  		$data['costumer_location_name']=$postsfetch['location_name'];
  		$data['costumer_long']=$postsfetch['long'];
  	$data['costumer_lat']=$postsfetch['lat'];
  }

if($data['costumer_lat'] !=NULL && $data['costumer_long'] !=NULL){
	$distance = number_format(calculateDistance($postsfetch['lat'], $postsfetch['long'], $_ENV['LAT'], $_ENV['LONG']), 1);
	$distance = str_replace(",", "", $distance);
}

  	$quantity = 0;
  	$quantity_val = 0;
  	$item_data ="";
  	$sum_price =0;
  	$uisql = "SELECT item_id, quantity,date FROM cart WHERE user_id= '$costumer_id' AND order_id='".$data["order_id"]."' ORDER BY date DESC";
  	$xdata=$this->comman_model->get_all_data_by_query($uisql);
  	foreach ($xdata as $postsfetch) {
  		$item_id = $postsfetch['item_id'];
  		$quantity = $postsfetch['quantity'];
  		$date = time_ago(strtotime($postsfetch['date']));
  		$uisql = "SELECT * FROM product WHERE id= '$item_id' ";
  		$ydata=$this->comman_model->get_all_data_by_query($uisql);
  	foreach ($ydata as $postsfetchi) {
  		$id = $postsfetchi['id'];
  		$title = $postsfetchi['title'];
  		$description = $postsfetchi['description'];
  		$price = $postsfetchi['price'];
  		$compare_price = $postsfetchi['compare_price'];
  		$product_type = $postsfetchi['product_type'];
  		$product_catigory = $postsfetchi['product_catigory'];
  		$collection = $postsfetchi['collection'];
  		$number = $postsfetchi['number'];
      $image_location ="";

      if($data['discount_type'] == 2 && $data['discount_value_y'] == $title){
      $price = $price-($price*($data['discount_value_x']/100));
    }

  		$quantity_val += $quantity;
  		$sum_price += $price*$quantity;
      if($data['discount_type'] == 0){
        if($title == $data['discount_value_x'] && $data['discount_value_z'] <= $quantity){
        $uisql = "SELECT * FROM product WHERE title='".$data['discount_value_y']."'";
        $ydata=$this->comman_model->get_all_data_by_query($uisql);
      foreach ($ydata as $postsfetchz) {
        $id = $postsfetchz['id'];
        $title = $postsfetchz['title'];
        $description = $postsfetchz['description'];
        $price = $postsfetchz['price'];
        $compare_price = $postsfetchz['compare_price'];
        $product_type = $postsfetchz['product_type'];
        $product_catigory = $postsfetchz['product_catigory'];
        $collection = $postsfetchz['collection'];
        $number = $postsfetchz['number'];
        if($number > 0){
          $available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
        }else{
          $available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
        }
        $image_location ="";
        $quantity = $quantity/$data['discount_value_z'];
        $quantity_val += $quantity;
      }}
  	}}}


  	$data['distance']=$distance;
    if($data['discount_type'] == 3 && $sum_price >= $data['minimum_purchase']){
      $deliver_price = 0;
    }else{
			if($_ENV['DELIVERY_TYPE'] == "1"){
				$deliver_price = $distance*$_ENV['DELIVERY_PRICE'];
			}elseif($_ENV['DELIVERY_TYPE'] == "2"){
				$deliver_price = $_ENV['DELIVERY_PRICE'];
			}
    }
  	$data['deliver_price']=$deliver_price;

  	$data['quantity']=$quantity_val;
  	$data['sum_price']=$sum_price;
    $branch_total = $sum_price+$deliver_price;

    if($data['discount_type'] == 1 && $sum_price >= $data['minimum_purchase']){
      $branch_total = $branch_total-($branch_total*($data['discount_value_x']/100));
    }

  	$data['branch_total']=$branch_total;


  $uisql = "SELECT id FROM cart WHERE user_id= '$costumer_id' AND order_id='".$order_id."'";
  $udata = $this->comman_model->get_all_data_by_query($uisql);
  $data['isCart'] = count($udata);

if(file_exists('src/cart.html')){
	$html = file_get_contents('src/cart.html');
}else{
echo view('theme/cart',$data);
}

}
public function item()
{
	if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
	return redirect()->to(base_url()."dashboard");
	}
	$data['page'] = "item";
		$data['title'] = $data['page'];

		$sid = sessionCI('id');
	  if($sid == NULL){
	     $request = \Config\Services::request();
	    $sid=ip2bigint($request->getIPAddress());
	  }
			$pid = filter_var(htmlentities($this->request->getGet('pid')),FILTER_SANITIZE_STRING);
$data['pid'] = $pid;
if(file_exists('src/item.html')){
	$html = file_get_contents('src/item.html');
}else{
	$html = file_get_contents('missing/item.html');
}



$html .= "
<script>
	var array = [{%image%}];
	var edited = document.getElementById('images_container').innerHTML;
	document.getElementById('images_container').innerHTML='';
array.forEach((data)=>{


	const edited_a = edited.replace(/{%image_id%}/g, data.id);
	const edited_b = edited_a.replace(/{%image_location%}/g, data.image_location);

$('#images_container').append(edited_b);
});
	</script>
	";
	$html .= "
	<script>
		var array = [{%variant%}];
		var edited = document.getElementById('varient_container').innerHTML;
		document.getElementById('varient_container').innerHTML='';
	array.forEach((data)=>{


		const edited_a = edited.replace(/{%varient_id%}/g, data.id);
		const edited_b = edited_a.replace(/{%varient_image%}/g, data.variant_image);
		const edited_c = edited_b.replace(/{%varient_name%}/g, data.variant_name);

$('#varient_container').append(edited_c);
	});
	if(array == ''){
		$('#varient_container').hide();
	}
		</script>
		";
	$uisql = "SELECT * FROM product WHERE id= '$pid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$item_exist = count($udata);
	if($item_exist > 0){
	foreach ($udata as $postsfetch) {
			$item_id= $postsfetch['id'];
		$html= preg_replace('/{%item_id%}/s', $postsfetch['id'], $html);
		$html= preg_replace('/{%title%}/s', $postsfetch['title'], $html);
		$html= preg_replace('/{%description%}/s', $postsfetch['description'], $html);
		$html= preg_replace('/{%price%}/s', $postsfetch['price'], $html);
		$html= preg_replace('/{%compare_price%}/s', $postsfetch['compare_price'], $html);
		$html= preg_replace('/{%product_type%}/s', $postsfetch['product_type'], $html);
		$html= preg_replace('/{%product_catigory%}/s', $postsfetch['product_catigory'], $html);
		$html= preg_replace('/{%collection%}/s', $postsfetch['collection'], $html);
		$html= preg_replace('/{%quantity%}/s', $postsfetch['number'], $html);
		$number = $postsfetch['number'];

		$quantity_val = 0;
		$out_stock = $postsfetch['out_stock'];
		if($number > 0 || $out_stock == 1){
			$available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
		} else {
	$available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
		}
		$data['page'] = $postsfetch['title'];
		$data['title'] = $data['page'];
		$data['tags'] = $postsfetch['tags'];

		echo view("includes_site/head_info", $data);

		$html= preg_replace('/{%available%}/s', $available, $html);

		$final_price = price_display($postsfetch['price'], $postsfetch['compare_price'], $quantity_val);
		$html= preg_replace('/{%final_price%}/s', $final_price, $html);

	}
	$uisql = "SELECT id FROM cart WHERE item_id= '$pid' AND user_id='$sid' AND order_id='0'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$cart_item = count($udata);
	$image_data="";
$variant_data="";
	$uisql = "SELECT * FROM image WHERE product_id= '$pid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch) {
		$id = $postsfetch['id'];
		$location = base_url().$postsfetch['location'];
		$image_data.= "{image_id:'".$id."',image_location:'".$location."'},";
	}
	$uisql = "SELECT * FROM variant WHERE product_id= '$pid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch) {
		$id = $postsfetch['id'];
		$option_name = $postsfetch['option_name'];
		$location = base_url().$postsfetch['image'];
		$variant_data.= "{id:'".$id."',variant_name:'".$option_name."',variant_image:'".$location."'},";
	}
	if($image_data == ""){
		$image_data= "{image_id:'1',image_location:'Asset/imgs/main_icons/cover.jpg'},";

	}

	$html= preg_replace('/{%image%}/s', $image_data, $html);
		$html= preg_replace('/{%variant%}/s', $variant_data, $html);
		$cart_button = "<button ".(NULL == $sid ? 'disabled':'')." aria-label='Add cart' id=\"add_cart_$item_id\" onclick=\"addCart('$item_id')\" class=\"btn ".($cart_item < 1 ? 'btn-primary' : 'btn-info')."\">".($cart_item < 1 ? langs('add_cart') : langs('added_cart'))."</button>";

		$html= preg_replace('/{%cart_button%}/s', $cart_button, $html);


		$html= preg_replace('/{%project_name%}/s', $_ENV['PROJECT_NAME'], $html);

		echo "<meta property=\"og:image\" content=\"$location\">";
		$html= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $html);
		echo $html;

			echo view("includes_site/endJScodes", $data);
			}else{
		echo view("errors/missing_page", $data);
	}
}
public function item_view()
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
						 <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $id; ?>" class="none-link">
						 <h4><span class="font-size-20"><?php echo $title; ?></span> <?php echo price_display($price, $sale, $quantity_val)." ".$available; ?></h4>
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
}
