<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class deliver extends Controller {

public function __construct(){

	helper(
			['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info','discount']);

			$this->comman_model = new \App\Models\Comman_model();
		LoadLang();
		Checkdeliver(base_url());

}

public function report(){
	///check login
	Checklogin(base_url());

	$data['page'] = "discount";
	$data['title'] = $data['page'];


	echo view('deliver/report',$data);

}
}
