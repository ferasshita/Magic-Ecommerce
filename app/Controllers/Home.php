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
			['langs', 'Islogedin', 'functions_zone','numkmcount','app_info']
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
		$user_id = \Config\Services::session()->get('id');
	 	echo view("includes_site/head_info", $data);

$html = file_get_contents('src/'.$param.'.html');
//{%ddd%}
if($edits=="edit"){}else{
	$html .= "
	<script>
		var array = [{%items%}];
		var edited = document.getElementById('div_items').innerHTML;
		document.getElementById('div_items').innerHTML='';
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
				const edited_k = edited_j.replace(/{%cart_button%}/g, data.cart_button);
				const edited_l = edited_k.replace(/{%like_button%}/g, data.like_button);
				const edited_m = edited_l.replace(/{%items_image%}/g, data.item_image);

				$('#div_items').append(edited_m);
				});
	if(array == ''){
		document.getElementById('div_items').innerHTML = '';
	}
		</script>
		";
		$item_data="";

		$search_q = "1";
if($search != NULL){
$search_q .= " AND (title LIKE '%$search%' || tags LIKE '%$search%' || description LIKE '%$search%')";
}
if($vendor != NULL){
$search_q .= " AND vendor LIKE '%$vendor%'";
}
if($product_catigory != NULL){
$search_q .= " AND product_catigory LIKE '%$product_catigory%'";
}
if($product_type != NULL){
$search_q .= " AND product_type LIKE '%$product_type%'";
}
if($product_collection != NULL){
$search_q .= " AND collection LIKE '%$product_collection%'";
}
if($barcode != NULL){
$search_q .= " AND barcode LIKE '%$barcode%'";
}
if($fav == 1){
$search_q .= " AND id IN (SELECT item_id FROM item_like WHERE user_id = '$user_id')";
}
$uisql = "SELECT * FROM product WHERE $search_q";
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
	$out_stock = $postsfetchi['out_stock'];
	if($number > 0 || $out_stock == 1){
		$available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
	}else{
		$available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
	}
	$uisql = "SELECT location FROM image WHERE product_id= '$id'";
	$ydata=$this->comman_model->get_all_data_by_query($uisql);
	foreach ($ydata as $postsfetchx) {
		$image_location = base_url().$postsfetchx['location'];
	}
	$uisql = "SELECT id FROM cart WHERE item_id= '$id' AND user_id='$user_id' AND order_id='0'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$cart_item = count($udata);

	$uisql = "SELECT id FROM item_like WHERE item_id= '$id' AND user_id='$user_id'";
	$udata=$this->comman_model->get_all_data_by_query($uisql);
	$like_item = count($udata);

	$cart_button = "<button ".(NULL !== $user_id ? 'disabled':'')." id=\"add_cart_$id\" onclick=\"addCart(\\'$id\\')\" class=\"btn ".($cart_item < 1 ? 'btn-primary' : 'btn-info')."\">".($cart_item < 1 ? langs('add_cart') : langs('added_cart'))."</button>";
	$like_button = "<button style=\"color: red\" ".(NULL !== $user_id ? 'disabled':'')." id=\"item_like_$id\" onclick=\"itemLike(\\'$id\\')\" class=\"btn ".($like_item < 1 ? 'fa fa-heart-o ' : 'fa fa-heart '). "btn-white border-dark\"></button>";

		$item_data.= "{id:'".$id."',title:'".$title."', description:'".$description."', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','product_catigory':'".$product_catigory."','collection':'".$collection."','cart_button':'".$cart_button."','like_button':'".$like_button."','item_image':'".$image_location."'},";
	}


$html= preg_replace('/{%items%}/s', $item_data, $html);

$html= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $html);
}
echo $html;

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
		if (file_exists('src/index.html')) {
//include('src/index.html');
$html = file_get_contents('src/index.html');
		}else{
				foreach (scandir('src') as $file) {
					$fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					if($fileExt === 'html'){
					$html = file_get_contents('src/'.$file);
					break;
				}
				}
		}
		$search=filter_var(htmlentities($this->request->getGet('search')), FILTER_SANITIZE_STRING);
		$fav=filter_var(htmlentities($this->request->getGet('fav')), FILTER_SANITIZE_STRING);
		$product_catigory=filter_var(htmlentities($this->request->getGet('product_catigory')), FILTER_SANITIZE_STRING);
		$vendor=filter_var(htmlentities($this->request->getGet('vendor')), FILTER_SANITIZE_STRING);
		$product_type=filter_var(htmlentities($this->request->getGet('product_type')), FILTER_SANITIZE_STRING);
		$product_collection=filter_var(htmlentities($this->request->getGet('collection')), FILTER_SANITIZE_STRING);
		$barcode=filter_var(htmlentities($this->request->getGet('barcode')), FILTER_SANITIZE_STRING);
		$html .= "
		<script>
			var array = [{%items%}];
			var edited = document.getElementById('div_items').innerHTML;
			document.getElementById('div_items').innerHTML='';

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
					const edited_k = edited_j.replace(/{%cart_button%}/g, data.cart_button);
					const edited_l = edited_k.replace(/{%like_button%}/g, data.like_button);
					const edited_m = edited_l.replace(/{%items_image%}/g, data.item_image);

$('#div_items').append(edited_m);
					});
		if(array == ''){
			document.getElementById('div_items').innerHTML = '';
		}
			</script>
			";
			$item_data="";
			$search_q = "1";
if($search != NULL){
	$search_q .= " AND (title LIKE '%$search%' || tags LIKE '%$search%' || description LIKE '%$search%')";
}
if($vendor != NULL){
	$search_q .= " AND vendor LIKE '%$vendor%'";
}
if($product_catigory != NULL){
	$search_q .= " AND product_catigory LIKE '%$product_catigory%'";
}
if($product_type != NULL){
	$search_q .= " AND product_type LIKE '%$product_type%'";
}
if($product_collection != NULL){
	$search_q .= " AND collection LIKE '%$product_collection%'";
}
if($barcode != NULL){
	$search_q .= " AND barcode LIKE '%$barcode%'";
}
if($fav == 1){
	$search_q .= " AND id IN (SELECT item_id FROM item_like WHERE user_id = '$user_id')";
}
$uisql = "SELECT * FROM product WHERE $search_q";
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
		$out_stock = $postsfetchi['out_stock'];
		if($number > 0 || $out_stock == 1){
			$available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
		}else{
			$available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
		}
		$uisql = "SELECT location FROM image WHERE product_id= '$id'";
		$ydata=$this->comman_model->get_all_data_by_query($uisql);
		foreach ($ydata as $postsfetchx) {
			$image_location = base_url().$postsfetchx['location'];
		}
		$uisql = "SELECT id FROM cart WHERE item_id= '$id' AND user_id='$user_id' AND order_id='0'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$cart_item = count($udata);

		$uisql = "SELECT id FROM item_like WHERE item_id= '$id' AND user_id='$user_id'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		$like_item = count($udata);

		$cart_button = "<button ".(NULL == $user_id ? 'disabled':'')." id=\"add_cart_$id\" onclick=\"addCart(\\'$id\\')\" class=\"btn ".($cart_item < 1 ? 'btn-primary' : 'btn-info')."\">".($cart_item < 1 ? langs('add_cart') : langs('added_cart'))."</button>";
		$like_button = "<button style=\"color: red\" ".(NULL == $user_id ? 'disabled':'')." id=\"item_like_$id\" onclick=\"itemLike(\\'$id\\')\" class=\"btn ".($like_item < 1 ? 'fa fa-heart-o ' : 'fa fa-heart '). "btn-white border-dark\"></button>";

			$item_data.= "{id:'".$id."',title:'".$title."', description:'".$description."', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','product_catigory':'".$product_catigory."','collection':'".$collection."','cart_button':'".$cart_button."','like_button':'".$like_button."','item_image':'".$image_location."'},";
		}

		$html= preg_replace('/{%items%}/s', $item_data, $html);
		$html= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $html);
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
