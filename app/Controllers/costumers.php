<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class costumers extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info', 'emailBody', 'Sendmail']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();
	Checkadmin(base_url());
}

public function orders(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Orders";
	$data['title'] = $data['page'];

	$uisql = "SELECT * FROM orders";
	$data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);
foreach ($data['fetchdatas'] as $postsfetchi) {
	$data['total'] =0;
	$data['deliver'] ="";
	$id=$postsfetchi['id'];
	$user_id=$postsfetchi['user_id'];
	$accept=$postsfetchi['accept'];
}
	echo view('costumers/orders',$data);

}
public function costumers(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Costumers";
	$data['title'] = $data['page'];

	$uisql = "SELECT * FROM signup WHERE account_type='user'";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);
			 foreach ($data['fetchdatas'] as $postsfetch ) {
				 $id=$postsfetch['id'];
			 $uisql = "SELECT * FROM orders WHERE user_id='$id'";
						$fetchdata=$this->comman_model->get_all_data_by_query($uisql);
$data['orders_count']=count($fetchdata);
					}

	echo view('costumers/costumers',$data);

}
public function pos(){
	///check login
	Checklogin(base_url());
	$data['page'] = "POS";
	$data['title'] = $data['page'];

	$uisql = "SELECT * FROM product";
	$data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	$uisql = "SELECT * FROM cart WHERE order_id='0' AND user_id='".$_SESSION['id']."'";
	$data['fetchdata']=$this->comman_model->get_all_data_by_query($uisql);
	 foreach ($data['fetchdata'] as $postsfetch ) {
		 $id = $postsfetch['id'];
		 $item_id = $postsfetch['item_id'];
	$uisql = "SELECT * FROM product WHERE id='$item_id'";
	$data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);
}

	echo view('costumers/pos',$data);

}
public function add_pos(){
	$order_id=0;
	$out_stock=0;
	$item = filter_var(htmlspecialchars($this->request->getPost('item')),FILTER_SANITIZE_STRING);
	$quantity = filter_var(htmlspecialchars($this->request->getPost('quantity')),FILTER_SANITIZE_STRING);
	$item_quantity=0;
	if($quantity == NULL){
		$quantity=1;
	}
	$uisql = "SELECT number,out_stock,track_quantity FROM product WHERE id='$item'";
 $udata=$this->comman_model->get_all_data_by_query($uisql);
 foreach ($udata as $postsfetch ) {
	 $item_quantity = $postsfetch['number'];
	 $out_stock = $postsfetch['out_stock'];
	 $track_quantity = $postsfetch['track_quantity'];
 }
 if($out_stock == 0){
 if($item_quantity < $quantity){
echo "only $item_quantity is aviliable";
return false;
 }
}
	$new_number = $item_quantity-$quantity;
	$update_info_sql = "UPDATE product SET number= '$new_number' WHERE id='$item'";
	$update_info=$this->comman_model->run_query($update_info_sql);

 $uisql = "SELECT * FROM cart WHERE item_id='$item' AND order_id='0' AND user_id='".$_SESSION['id']."'";
 $udata=$this->comman_model->get_all_data_by_query($uisql);
$check_cart=count($udata);
if($check_cart>0){
	$where = array(
		'item_id' => $item,
		'order_id' => '0',
		'user_id' => $_SESSION['id'],
	);
	$data = array(
		'order_id' => $order_id,
		'item_id' => $item,
		'user_id' => $_SESSION['id'],
		'quantity' => $quantity,
	);
	$inserted = $this->comman_model->update_entry("cart", $data,$where);
}else{
	$data = array(
		'order_id' => $order_id,
		'item_id' => $item,
		'user_id' => $_SESSION['id'],
		'quantity' => $quantity,
	);
	$inserted = $this->comman_model->insert_entry("cart", $data);
}
echo "item is added";
}
public function add_delivery(){
	$id=rand(0,9999999)+time();
	$name = filter_var(htmlspecialchars($this->request->getPost('name')),FILTER_SANITIZE_STRING);
	$license_number = filter_var(htmlspecialchars($this->request->getPost('license_number')),FILTER_SANITIZE_STRING);
	$passport_number = filter_var(htmlspecialchars($this->request->getPost('passport_number')),FILTER_SANITIZE_STRING);
	$email = filter_var(htmlspecialchars($this->request->getPost('email')),FILTER_SANITIZE_STRING);
	$phone = filter_var(htmlspecialchars($this->request->getPost('phone')),FILTER_SANITIZE_STRING);
	$vehical_number = filter_var(htmlspecialchars($this->request->getPost('vehical_number')),FILTER_SANITIZE_STRING);
	$deliver_id = filter_var(htmlspecialchars($this->request->getPost('deliver_id')),FILTER_SANITIZE_STRING);
	$license_photo="";
	$photo="";
	$passport_photo="";
	if(isset($_FILE['license_photo'])){
		$license_photo = file_upload('Asset/upload/license_photo','license_photo','png|jpeg|jpg|ico','');
	}
	if(isset($_FILE['photo'])){
		$license_photo = file_upload('Asset/upload/deliver','photo','png|jpeg|jpg|ico','');
	}
	if(isset($_FILE['passport_photo'])){
		$passport_photo = file_upload('Asset/upload/passport_photo','passport_photo','png|jpeg|jpg|ico','');
	}
	$password = bin2hex(random_bytes(4));
	$options = array(
		'cost' => 12,
	);

	$signup_password = password_hash($password, PASSWORD_BCRYPT, $options);

	if($deliver_id == NULL) {
		$data = array(
			'id' => $id,
			'name' => $name,
			'license_number' => $license_number,
			'passport_number' => $passport_number,
			'email' => $email,
			'phone' => $phone,
			'photo' => $photo,
			'vehical_number' => $vehical_number,
			'license_photo' => $license_photo,
			'passport_photo' => $passport_photo,
			'password' => $password,

		);
		$inserted = $this->comman_model->insert_entry("deliver", $data);
	}else{
		$data = array(
			'id' => $id,
			'name' => $name,
			'license_number' => $license_number,
			'passport_number' => $passport_number,
			'email' => $email,
			'phone' => $phone,
			'vehical_number' => $vehical_number,
			'license_photo' => $license_photo,
			'passport_photo' => $passport_photo,
			'password' => $password,
		);
		$where=array('id' => $id);
		$inserted=$this->comman_model->update_entry("deliver",$data,$where);
	}

	$data = array(
		'id'      => $id,
		'phone'      => $phone,
		'username'      => $email,
		'email'      => $email,
		'Password'      => $signup_password,
		'language'      => 'العربية',
		'account_type'      => 'deliver',
		'mode'      => 'auto',
		'account_setup'      => date('d/m/Y'),
		'user_email_status'      => 'verified',
	);
	$this->comman_model->insert_entry("signup",$data);

		$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
		$mail_body = emailBody($name,base_url().'Account/login'," شكرا للتسجل في النظم وهدة هي بيانات التسجيل الدخول اسم المستخدم:  $name كلمة السر: $password".$name,$terms_mail);

	$result = SendEmail('Delivery login',$email,$mail_body);
}

public function delivery(){
	///check login
	Checklogin(base_url());

	$data['page'] = "delivery";
	$data['title'] = $data['page'];
	$data['pid'] = $this->request->getGet('pid');

	$data['name'] = "";
	$data['license_number'] = "";
	$data['passport_number'] = "";
	$data['license_photo'] = "";
	$data['passport_photo'] = "";
	$data['photo'] = "";
	$data['phone'] = "";
	$data['email'] = "";
	$data['vehical_number'] = "";

	$uisql = "SELECT * FROM deliver WHERE id='".$data['pid']."'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $data['name'] = $postsfetch['name'];
						 $data['license_number'] = $postsfetch['license_number'];
						 $data['passport_number'] = $postsfetch['passport_number'];
						 $data['license_photo'] = $postsfetch['license_photo'];
						 $data['passport_photo'] = $postsfetch['passport_photo'];
						 $data['photo'] = $postsfetch['photo'];
						 $data['phone'] = $postsfetch['phone'];
						 $data['email'] = $postsfetch['email'];
						 $data['vehical_number'] = $postsfetch['vehical_number'];

				 }
	$uisql = "SELECT * FROM deliver";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('costumers/delivery',$data);

}
}
