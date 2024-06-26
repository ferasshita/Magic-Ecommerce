<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class discount extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info','discount']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();

}

public function promocode(){
	///check login

	$data['page'] = "discount";
	$data['title'] = $data['page'];


	$code = $this->request->getGet('pid');
	$uisql = "SELECT * FROM discount WHERE code='$code'";
	$data['fetchdata']=$this->comman_model->get_all_data_by_query($uisql);

	$uisql = "SELECT * FROM orders WHERE discount_code='$code'";
	$data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('discount/promocode',$data);

}

public function index(){
	///check login
	Checkadmin(base_url());

	Checklogin(base_url());

	$data['page'] = "discount";
	$data['title'] = $data['page'];
	$data['pid'] = $this->request->getGet('pid');
	$data['discount_id'] = $this->request->getGet('disid');


	$data['code'] = "";
  $data['type'] = "";
	$data['from'] = "";
	$data['to'] = "";
	$data['x'] = "";
	$data['y'] = "";
	$data['z'] = "";
	$data['minimum_purchase'] = "";
  $data['limit'] = "";

	$uisql = "SELECT * FROM discount WHERE id='".$data['pid']."'";
					 $udata=$this->comman_model->get_all_data_by_query($uisql);
					 foreach ($udata as $postsfetch ) {
						 $data['code'] = $postsfetch['code'];
						 $data['type'] = $postsfetch['type'];
						 $data['from'] = $postsfetch['from_date'];
						 $data['x'] = $postsfetch['x'];
						 $data['y'] = $postsfetch['y'];
						 $data['z'] = $postsfetch['z'];
						 $data['to'] = $postsfetch['to_date'];
						 $data['minimum_purchase'] = $postsfetch['minimum_purchase'];
						 $data['limit'] = $postsfetch['limit'];

				 }

	$uisql = "SELECT * FROM discount";
			 $data['fetchdatas']=$this->comman_model->get_all_data_by_query($uisql);

	echo view('discount/index',$data);

}
public function add_discount(){
	$id = filter_var(htmlentities($this->request->getPost('id')),FILTER_SANITIZE_STRING);
	$type = filter_var(htmlentities($this->request->getPost('type')),FILTER_SANITIZE_STRING);
	$from_date = filter_var(htmlentities($this->request->getPost('from')),FILTER_SANITIZE_STRING);
	$to_date = filter_var(htmlentities($this->request->getPost('to')),FILTER_SANITIZE_STRING);
	$code = filter_var(htmlentities($this->request->getPost('code')),FILTER_SANITIZE_STRING);
	$x = filter_var(htmlentities($this->request->getPost('x')),FILTER_SANITIZE_STRING);
	$y = filter_var(htmlentities($this->request->getPost('y')),FILTER_SANITIZE_STRING);
	$z = filter_var(htmlentities($this->request->getPost('z')),FILTER_SANITIZE_STRING);
	$limit = filter_var(htmlentities($this->request->getPost('limit')),FILTER_SANITIZE_STRING);
	$minimum_purchase = filter_var(htmlentities($this->request->getPost('minimum_purchase')),FILTER_SANITIZE_STRING);
	$sid=$_SESSION['id'];

	$uisql = "SELECT id FROM discount WHERE code= '$code'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$item_exist = count($udata);

if($id != NULL){
	$data = array(
		'type' => $type,
		'from_date' => $from_date,
		'to_date' => $to_date,
		'code' => $code,
		'limit' => $limit,
		'minimum_purchase' => $minimum_purchase,
		'x' => $x,
		'y' => $y,
		'z' => $z,
	);
	$where=array('id' => $id, 'user_id' => $sid);
	$inserted=$this->comman_model->update_entry("discount",$data,$where);

}else{
	$data = array(
		'user_id' => $sid,
		'type' => $type,
		'from_date' => $from_date,
		'to_date' => $to_date,
		'code' => $code,
		'limit' => $limit,
		'minimum_purchase' => $minimum_purchase,
		'x' => $x,
		'y' => $y,
		'z' => $z,
	);
	$inserted=$this->comman_model->insert_entry("discount",$data);
	  echo "<p class='alertGreen'>" . langs('done') . "</p>";
}
}
}
