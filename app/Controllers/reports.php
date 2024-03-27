<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class reports extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info', 'numkmcount']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();
		Checkadmin(base_url());

}

public function analytics(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Analytics";
	$data['title'] = $data['page'];

	 $data['total']=0;
	$uisql = "SELECT id FROM orders";
	$fetchdatas=$this->comman_model->get_all_data_by_query($uisql);
	$data['orders_count']=count($fetchdatas);
	foreach ($fetchdatas as $postsfetchi) {

	$id=$postsfetchi['id'];

$uisql = "SELECT item_id FROM cart WHERE order_id='$id'";
$fetchdatas=$this->comman_model->get_all_data_by_query($uisql);
foreach ($fetchdatas as $postsfetch) {
$item_id=$postsfetch['item_id'];
$uisql = "SELECT price FROM product WHERE id='$item_id'";
$fetchdatas=$this->comman_model->get_all_data_by_query($uisql);
foreach ($fetchdatas as $postsfetchx) {
$data['total'] +=$postsfetchx['price'];
}
}
}
if($data['orders_count'] != 0){
	$data['average_order']=$data['total']/$data['orders_count'];
}else{
	$data['average_order']=0;

}

$uisql = "SELECT id FROM product";
$fetchdatas=$this->comman_model->get_all_data_by_query($uisql);
$data['inventory'] = count($fetchdatas);

	echo view('reports/analytics',$data);
}
public function marketing(){
	///check login
	Checklogin(base_url());

	$data['page'] = "Marketing";
	$data['title'] = $data['page'];


	echo view('reports/marketing',$data);
}
}
