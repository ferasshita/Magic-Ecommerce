<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		helper(
			['langs', 'Islogedin', 'functions_zone','numkmcount','app_info', 'timefunction']
	);
$this->comman_model = new \App\Models\Comman_model();
			LoadLang();

	}
	public function page($param = null)
	{
		if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
		return redirect()->to(base_url()."dashboard");
		}
		if($_ENV['LANDING_PAGE'] == "FALSE"){
		return redirect()->to(base_url()."Account/login");
		}
		$edits=$this->request->getGet('edit');
		if($param == ""){
			$param = "index";
		}
		$data['page'] = $param;
		$data['title'] = "";
		LoadLang();

		$search=filter_var(htmlentities($this->request->getGet('search')), FILTER_SANITIZE_STRING);
		$fav=filter_var(htmlentities($this->request->getGet('fav')), FILTER_SANITIZE_STRING);
		$product_catigory=filter_var(htmlentities($this->request->getGet('product_catigory')), FILTER_SANITIZE_STRING);
		$vendor=filter_var(htmlentities($this->request->getGet('vendor')), FILTER_SANITIZE_STRING);
		$product_type=filter_var(htmlentities($this->request->getGet('product_type')), FILTER_SANITIZE_STRING);
		$product_collection=filter_var(htmlentities($this->request->getGet('collection')), FILTER_SANITIZE_STRING);
		$barcode=filter_var(htmlentities($this->request->getGet('barcode')), FILTER_SANITIZE_STRING);
		$promocode=filter_var(htmlentities($this->request->getGet('promocode')), FILTER_SANITIZE_STRING);
		$array_search= array($search, $fav, $product_catigory, $vendor, $product_type, $product_collection, $barcode);

		$user_id = \Config\Services::session()->get('id');
	 	echo view("includes_site/head_info", $data);

		if(!IS_FILE('src/'.$param.'.html')){
echo view("errors/404",$data);
		}else{
$html = file_get_contents('src/'.$param.'.html');

$html = replaceLinks($html);
//{%ddd%}
if($edits=="edit"){}else{
	$html = magicCodeReplace($html,$array_search);
$html = cartFunctions($html,'',$promocode);
}
echo $html;

}

			echo view("includes_site/endJScodes", $data);
	}
	public function index()
	{
		if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
		return redirect()->to(base_url()."dashboard");
		}
		if($_ENV['LANDING_PAGE'] == "FALSE"){
	  return redirect()->to(base_url()."Account/login");
		}
	//	loginRedirect(base_url()."Account/login");

		$data['page'] = "Home";
		$data['title'] = "";
		LoadLang();
		$user_id = \Config\Services::session()->get('id');
		echo view("includes_site/head_info", $data);
		//echo view("includes/head_info",$data);

		$html="";
		if (file_exists('src/index.html')) {
//include('src/index.html');
$html = file_get_contents('src/index.html');
		}else{
						$html = file_get_contents('missing/home.html');

				}
		$promocode=filter_var(htmlentities($this->request->getGet('promocode')), FILTER_SANITIZE_STRING);

		$html = replaceLinks($html);
		$html = cartFunctions($html,'',$promocode);
		$search=filter_var(htmlentities($this->request->getGet('search')), FILTER_SANITIZE_STRING);
		$fav=filter_var(htmlentities($this->request->getGet('fav')), FILTER_SANITIZE_STRING);
		$product_catigory=filter_var(htmlentities($this->request->getGet('product_catigory')), FILTER_SANITIZE_STRING);
		$vendor=filter_var(htmlentities($this->request->getGet('vendor')), FILTER_SANITIZE_STRING);
		$product_type=filter_var(htmlentities($this->request->getGet('product_type')), FILTER_SANITIZE_STRING);
		$product_collection=filter_var(htmlentities($this->request->getGet('collection')), FILTER_SANITIZE_STRING);
		$barcode=filter_var(htmlentities($this->request->getGet('barcode')), FILTER_SANITIZE_STRING);
		$array_search= array($search, $fav, $product_catigory, $vendor, $product_type, $product_collection, $barcode);

		$user_id = \Config\Services::session()->get('id');
$html = magicCodeReplace($html,$array_search);

echo $html;
		echo view("includes_site/endJScodes", $data);
	}
	public function pay()
	{
		if($_ENV['PAYMENT'] == "TRUE"){
		$data['page'] = "Payment";
		$data['title'] = "";
		LoadLang();

		echo view('home/pay', $data);
	}
	}
public function blog($pid)
	{
		LoadLang();
		$vpsql = "SELECT * FROM blog WHERE id= '$pid'";
		$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
		foreach($FetchedData as $row_fetch){
			$user_id = $row_fetch['user_id'];
			$data['blog_text'] = $row_fetch['blog_text'];
			$data['blog_img'] = $row_fetch['blog_img'];
			$data['title'] = $row_fetch['title'];
			$data['description'] = $row_fetch['description'];
			$see = $row_fetch['see'];

			$vpsql = "SELECT username FROM signup WHERE id= '$user_id'";
			$FetchedDatai=$this->comman_model->get_all_data_by_query($vpsql);
			foreach($FetchedDatai as $row_fetchi){
				$data['author'] = $row_fetchi['username'];
			}
		}

		$data['page'] = $data['title'];
		if($see == '0' && session()->get('id') == NULL){
		echo view('errors/404');
		}else{
		echo view('home/page',$data);
	}
	}
	}
