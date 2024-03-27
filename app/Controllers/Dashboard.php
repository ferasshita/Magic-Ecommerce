<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller {

	public function __construct()
	{

			helper(
				['langs', 'sendmail', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']
		);
$this->comman_model = new \App\Models\Comman_model();
			echo Checkloginhome(base_url());

	if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
//===========================[cookie function]===============================
	$encryption = $_COOKIE['id'];
	$options   = 0;
	$decryption_iv = '1234567891011121';
	$ciphering = "AES-128-CTR";
	$decryption_key = $_SERVER['REMOTE_ADDR'];
	$decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

//========================[fetch data]==============================
$req = "still";
$varid = "";
	$vpsql = "SELECT * FROM signup WHERE id= '$decryption'";
	$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
	foreach($FetchedData as $row_fetch){
		$fields = $this->comman_model->getFieldData('signup');
	  foreach ($fields as $postsfetchi)
	  {
		  ${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
	}
	}
//=========================[settings]=======================================
	$uisql = "SELECT * FROM settings WHERE user_id= '$varid'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	foreach($udata as $rowx){
	$value_n = $rowx['value'];
	$type_n = $rowx['type'];
	session()->set($type_n, $value_n);
	}
//========================[create sessions]=================================
$fields = $this->comman_model->getFieldData('signup');
foreach ($fields as $postsfetchi)
{
	session()->set($postsfetchi->name, ${"var" . $postsfetchi->name});
}
	}
			LoadLang();
	}
	public function index()
	{

		 if(sessionCI('user_email_status') == "not verified"){
			header("location:".base_url()."Account/email_verification");
		}

		$data['page'] = "home";
		$data['title'] = "";
		$user_id = sessionCI('id');

		$locationCount=$this->comman_model->get_dataCount_where("locations","user_id",$user_id);

		if(sessionCI('account_type') == "user" && $locationCount < 1){
			echo view('dashboard/costumer', $data);

		}elseif(sessionCI('account_type') == "admin" && ($_ENV['LONG'] == 0 || $_ENV['LAT'] == 0)){
			echo view('dashboard/costumer', $data);

		}elseif(sessionCI('account_type') == "admin"){
		//$uid = $_SESSION['id'];
		//capitalcount
		$capital=$this->comman_model->get_data_where("product","user_id",$user_id);
		$capitalCount=$this->comman_model->get_dataCount_where("product","user_id",$user_id);
		$data["productCount"]=$capitalCount;
		//bank count
		$bankCount=$this->comman_model->get_dataCount("deliver");
		$data["deliverCount"] = $bankCount;
		//transaction count
		$TransCount=$this->comman_model->get_dataCount_where("blog","user_id",$user_id);
		$data["blogCount"] = $TransCount;
		//expenses count
		$ExpensesCount=$this->comman_model->get_dataCount_where("purchase","user_id",$user_id);
		$data["purchaseCount"] = $ExpensesCount;

				echo view('dashboard/home', $data);
			}elseif(sessionCI('account_type') == "deliver"){
				echo view('dashboard/deliver', $data);
			}else{
				header("location: ".base_url());
				exit();
			}
	}
	public function blog()
	{
		Checkadmin(base_url());

		$data['page'] = "Blog";
		$data['title'] = "";
		$data['pid']=$this->request->getGet('pid');

		$data['title'] = "";
		$data['blog'] = "";
		$data['description'] = "";
		$data['blog_text'] = "";
		$data['see'] = "";

		$uisql = "SELECT * FROM blog WHERE id= '".$data['pid']."'";
		$FetchedData=$this->comman_model->get_all_data_by_query($uisql);
		foreach($FetchedData as $row_fetch){
			$data['title'] = $row_fetch['title'];
			$data['blog'] = $row_fetch['blog'];
			$data['description'] = $row_fetch['description'];
			$data['blog_text'] = $row_fetch['blog_text'];
			$data['see'] = $row_fetch['see'];
		}
		$uisql = "SELECT * FROM blog";
		$data['udata']=$this->comman_model->get_all_data_by_query($uisql);
		foreach($data['udata'] as $row_fetch){
			$user_id = $row_fetch['user_id'];
			$vpsql = "SELECT username FROM signup WHERE id= '$user_id'";
			$FetchedDatai=$this->comman_model->get_all_data_by_query($vpsql);
			foreach($FetchedDatai as $row_fetchi){
				$data['author'] = $row_fetchi['username'];
			}
		}
		echo view('dashboard/blog', $data);
	}

	public function add_blog()
	{
		Checkadmin(base_url());

		$title = filter_var(htmlentities($this->request->getPost('title')),FILTER_SANITIZE_STRING);
		$see = filter_var(htmlentities($this->request->getPost('see')),FILTER_SANITIZE_STRING);
		$blog = filter_var(htmlentities($this->request->getPost('blog')),FILTER_SANITIZE_STRING);
		$id = filter_var(htmlentities($this->request->getPost('id')),FILTER_SANITIZE_STRING);
		if(!empty($this->request->getPost('blog_text'))){
			$blog_text = $_POST['blog_text'];
		}else{
			$blog_text = "";
		}
		$user_id = $_SESSION['id'];
		if(!empty($_FILES['image'])) {
			$blog_img = file_upload('blog', 'image', '', '');
		}else{
			$blog_img="";
		}
		if($id != NULL){
			$update = array(
				'title'      => $title,
				'blog_text'      => $blog_text,
				'blog'      => $blog,
				'see'      => $see,
			);
			$where=array('id' => $id);
			$update_info=$this->comman_model->update_entry("blog",$update,$where);
		}else{
		$insert = array(
			'user_id'      => $user_id,
			'title'      => $title,
			'blog_text'      => $blog_text,
			'blog_img'      => $blog_img,
			'blog'      => $blog,
			'see'      => $see,

		);
		$update = $this->comman_model->insert_entry("blog", $insert);
}
		if ($update) {
			echo "<p class='alertGreen'>".langs('changes_saved_seccessfully')."</p>";
		}else{
			echo "<p class='alertRed'>".langs('errorSomthingWrong')."</p>";
		}
	}


}
