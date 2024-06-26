<?php
function sessionCI($id){
  return \Config\Services::session()->get($id);
}
function delete_ac($id,$type){
  ob_start();
  session_start();

$comman_model = new \App\Models\Comman_model();

if($type == "delete_account"){
	$remeveAccount_sql = "DELETE FROM signup WHERE id= $id";
	$IDeleted=$comman_model->run_query($remeveAccount_sql);
}


	$remeveAccount_sql = "DELETE FROM settings WHERE id= $id";
	$IsRun=$comman_model->run_query($remeveAccount_sql);

  $remeveAccount_sql = "DELETE FROM transaction WHERE user_id= $id";
	$IsRun=$comman_model->run_query($remeveAccount_sql);

  return ob_get_clean();
}
?>
<?php
function cartFunctions($html,$pid,$promocode){
  $comman_model = new \App\Models\Comman_model();
  $sid = \Config\Services::session()->get('id');
  if($sid == NULL){
    $request = \Config\Services::request();
    $sid=ip2bigint($request->getIPAddress());
  }
  $order_location = '';

  $date = "";
  $discount_type="";
  $uisql = "SELECT type,x,y,z FROM discount WHERE code='$promocode' AND CAST(to_date AS DATE) <= CAST(from_date AS DATE)";
  $udata = $comman_model->get_all_data_by_query($uisql);
  foreach ($udata as $postsfetch) {
    $discount_type=$postsfetch['type'];
    $discount_value_x=$postsfetch['x'];
    $discount_value_y=$postsfetch['y'];
    $discount_value_z=$postsfetch['z'];
    $minimum_purchase=$postsfetch['minimum_purchase'];

  }
  	$uisql = "SELECT location, date FROM orders WHERE user_id= '$sid' AND id='$pid' AND id!='0'";
  	$udata = $comman_model->get_all_data_by_query($uisql);
  	$isOrder = count($udata);
  	foreach ($udata as $postsfetch) {
  		$order_location = $postsfetch['location'];
  		$date = $postsfetch['date'];
  	}
  		if($pid != NULL && $isOrder > 0){
  			$order_id = $pid;
  			$page_name = "Order #$pid";
  		}else{
  			$order_id = '0';
  			$page_name = "Cart";
  		}
  		$data["page_name"]["name"] = $page_name;
  		if($order_location == NULL){
  			$order_location_sql = 'AND my_location = 1';
  		}else{
  			$order_location_sql = "AND id='$order_location'";
  		}
  		$distance=0;
  	$uisql = "SELECT * FROM locations WHERE user_id= '$sid' $order_location_sql";
  	$udata=$comman_model->get_all_data_by_query($uisql);
    $count_cos_info=count($udata);
  	foreach ($udata as $postsfetch) {
  		$html= preg_replace('/{%costumer_address%}/s', $postsfetch['address'], $html);
  		$html= preg_replace('/{%costumer_location_name%}/s', $postsfetch['location_name'], $html);
  		$html= preg_replace('/{%costumer_long%}/s', $postsfetch['long'], $html);
  	$html= preg_replace('/{%costumer_lat%}/s', $postsfetch['lat'], $html);

  $distance = number_format(calculateDistance($postsfetch['lat'], $postsfetch['long'], $_ENV['LAT'], $_ENV['LONG']), 1);
  $distance = str_replace(",", "", $distance);

  }
  $distance=0;
  if($count_cos_info == 0){
    $html= preg_replace('/{%delivery_info_hide%}/s', 'none', $html);
    $html= preg_replace('/{%register_form_hide%}/s', 'block', $html);
    if($pid!=NULL){
    $uisql = "SELECT * FROM costumers WHERE ip= '$sid'";
    $udata=$comman_model->get_all_data_by_query($uisql);
    $count_cos_info=count($udata);
    foreach ($udata as $postsfetch) {
      $html= preg_replace('/{%costumer_address%}/s', $postsfetch['address'], $html);
      $html= preg_replace('/{%costumer_location_name%}/s', $postsfetch['location_name'], $html);
      $html= preg_replace('/{%costumer_long%}/s', $postsfetch['long'], $html);
    $html= preg_replace('/{%costumer_lat%}/s', $postsfetch['lat'], $html);
    $html= preg_replace('/{%delivery_info_hide%}/s', 'none', $html);
    $html= preg_replace('/{%register_form_hide%}/s', 'block', $html);

  $distance = number_format(calculateDistance($postsfetch['lat'], $postsfetch['long'], $_ENV['LAT'], $_ENV['LONG']), 1);
  $distance = str_replace(",", "", $distance);

}}
  }else{
    $html= preg_replace('/{%delivery_info_hide%}/s', 'block', $html);
    $html= preg_replace('/{%register_form_hide%}/s', 'none', $html);
  }

  $html= preg_replace('/{%project_name%}/s', $_ENV['PROJECT_NAME'], $html);
  $html= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $html);

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
  if(array == ''){
  	document.getElementById('body').innerHTML = '<div class=\"post loading-info\" style=\"min-width: 99%;\"><p style=\"color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;\">".langs('your_cart_is_empty')."</p></div>';
  }
  	</script>
  	";



  	if($pid == NULL){
  		$order_id_btn = rand(0,999999);
  	}
  	$d1 = strtotime("$date +2 minutes");
  	$d2 = (($d1)-time())/60;

  	$html= preg_replace('/{%order_button%}/s', "<button type=\"button\" id=\"order_button\" onclick=\"order('".$order_id_btn."'), start_count()\" class=\"btn ".($isOrder > 0 ?" btn-info": " btn-primary") ."\"".($d2 < 0 ? " disabled": "").">".($isOrder > 0 ? "cancel_order":"order")."</button><span id=\"timer\"></span>", $html);

  			$html .= "<script>
  				function start_count() {
  					var date = \"".$date."\";
  					if (date == \"\") {
  						var countDownDatea = new Date().getTime();
  					}else{
  						var countDownDatea = Date.parse(date);
  					}
  					var countDownDate = countDownDatea + 60000 + 60000;
  					var x = setInterval(function() {
  						var now = new Date().getTime();
  						var distance = countDownDate - now;
  						var minutes = Math.floor((distance % (1000 * 60 * 60)) / (60 * 1000));
  						var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  							$(\"#timer\").text(minutes + \":\" + seconds);
  							if (distance < 0) {
  								clearInterval(x);
  								$(\"#order_button\").attr(\"disabled\", \"true\");
  								$(\"#timer\").text(\"\");
  							}
  					}, 1000);
  				}
  			</script>";
  		if($isOrder > 0){
  			if($d2 > 0){
  		$html .= "
  		<span>
  						<script>start_count()</script>
  		 </span>";
  }
  	 }



  	$quantity = 0;
  	$quantity_val = 0;
  	$item_data ="";
  	$sum_price =0;
  	$uisql = "SELECT item_id, quantity,date FROM cart WHERE user_id= '$sid' AND order_id='".$order_id."' ORDER BY date DESC";
  	$xdata=$comman_model->get_all_data_by_query($uisql);
  	foreach ($xdata as $postsfetch) {
  		$item_id = $postsfetch['item_id'];
  		$quantity = $postsfetch['quantity'];
  		$date = time_ago(strtotime($postsfetch['date']));
  		$uisql = "SELECT * FROM product WHERE id= '$item_id' ";
  		$ydata=$comman_model->get_all_data_by_query($uisql);
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
      $image_location ="";
  		$uisql = "SELECT location FROM image WHERE product_id= '$item_id'";
  		$ydata=$comman_model->get_all_data_by_query($uisql);
  		foreach ($ydata as $postsfetchx) {
  			$image_location = base_url().$postsfetchx['location'];
  		}
      if($discount_type == 2 && $discount_value_y == $title){
      $price = $price-($price*($discount_value_x/100));
    }

  		$quantity_val += $quantity;
  		$sum_price += $price*$quantity;

  		$item_data.= "{id:'".$id."',title:'".$title."', description:'".$description."', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','item_quantity':".$quantity.",'product_catigory':'".$product_catigory."','collection':'".$collection."','item_image':'".$image_location."'},";
      if($discount_type == 0){
        if($title == $discount_value_x && $discount_value_z <= $quantity){
        $uisql = "SELECT * FROM product WHERE title='$discount_value_y'";
        $ydata=$comman_model->get_all_data_by_query($uisql);
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
        $uisql = "SELECT location FROM image WHERE product_id= '$item_id'";
        $ydata=$comman_model->get_all_data_by_query($uisql);
        foreach ($ydata as $postsfetchx) {
          $image_location = base_url().$postsfetchx['location'];
        }
        $quantity = $quantity/$discount_value_z;
        $quantity_val += $quantity;
        $item_data.= "{id:'".$id."',title:'".$title."', description:'".$description."', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','item_quantity':".$quantity.",'product_catigory':'".$product_catigory."','collection':'".$collection."','item_image':'".$image_location."'},";
      }}
  	}}}

  	$html= preg_replace('/{%items%}/s', $item_data, $html);

  	$html= preg_replace('/{%distance%}/s', $distance, $html);
    if($discount_type == 3 && $sum_price >= $minimum_purchase){
      $deliver_price = 0;
    }else{
      if($_ENV['DELIVERY_TYPE'] == "1"){
        $deliver_price = $distance*$_ENV['DELIVERY_PRICE'];
      }elseif($_ENV['DELIVERY_TYPE'] == "2"){
        $deliver_price = $_ENV['DELIVERY_PRICE'];
      }
    }
  	$html= preg_replace('/{%deliver_price%}/s', $deliver_price, $html);

  	$html= preg_replace('/{%quantity%}/s', $quantity_val, $html);
  	$html= preg_replace('/{%sum_price%}/s', $sum_price, $html);
    $branch_total = $sum_price+$deliver_price;

    if($discount_type == 1 && $sum_price >= $minimum_purchase){
      $branch_total = $branch_total-($branch_total*($discount_value_x/100));
    }

  	$html= preg_replace('/{%branch_total%}/s', $branch_total, $html);


  $uisql = "SELECT id FROM cart WHERE user_id= '$sid' AND order_id='".$order_id."'";
  $udata = $comman_model->get_all_data_by_query($uisql);
  $data['isCart'] = count($udata);
  return $html;
}



function ip2bigint($ipAddress) {
  // Validate IP format
  if (!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
    return false; // Invalid IP format
  }

  // Check for reserved ranges (version-agnostic approach)
  $reserved_ranges = array(
    '10.0.0.0/8', // Private network
    '172.16.0.0/12', // Private network
    '192.168.0.0/16' // Private network
  );

  foreach ($reserved_ranges as $range) {
    if (strpos($ipAddress, $range) === 0) {
      return false; // Reserved IP
    }
  }

  // Handle IPv4 addresses
  if (defined('FILTER_FLAG_NO_RES') && // Check if constant exists
      filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES)) {
    $ip_arr = explode('.', $ipAddress);
    $result = ($ip_arr[0] << 24) | ($ip_arr[1] << 16) | ($ip_arr[2] << 8) | $ip_arr[3];
    return $result;
  } else {
    // Handle potential missing FILTER_FLAG_NO_RES (alternative logic)
    // Implement alternative logic here (e.g., manual CIDR range checks)
    // ... (consider using a library like geoip2 for more robust handling)
    return '001'; // Indicate potential reserved IP (consider alternative logic)
  }

  // Handle IPv6 addresses (simplified conversion)
  $ip_packed = inet_pton($ipAddress);
  if ($ip_packed !== false) {
    // Unpack the binary string into an array of 4 32-bit integers
    $ip_longs = unpack('Nnnnn', $ip_packed);
    // Combine the longs into a single bigint (simplified approach)
    $result = ($ip_longs[1] << 96) | ($ip_longs[2] << 64) | ($ip_longs[3] << 32) | $ip_longs[4];
    return $result;
  }

  return false; // Invalid IP format
}

 ?>

<?php
function magicCodeReplace($content,$array_search) {
  $comman_model = new \App\Models\Comman_model();
  $user_id = \Config\Services::session()->get('id');
  if($user_id == NULL){
     $request = \Config\Services::request();
    $user_id=ip2bigint($request->getIPAddress());
  }
$search= $array_search[0];
$fav= $array_search[1];
$product_catigory= $array_search[2];
$vendor= $array_search[3];
$product_type= $array_search[4];
$product_collection= $array_search[5];
$barcode= $array_search[6];
  $content .= "
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
        const edited_n = edited_m.replace(/{%final_price%}/g, data.final_price);

        $('#div_items').append(edited_n);
        });
  if(array == ''){
    document.getElementById('div_items').innerHTML = '';
  }
    </script>
    ";

    $content .= "
    <script>
      var array = [{%catigories_array%}];
      var edited = document.getElementById('catigories_display').innerHTML;
      document.getElementById('catigories_display').innerHTML='';
    array.forEach((data)=>{

      const edited_a = edited.replace(/{%catigories_id%}/g, data.id);
      const edited_b = edited_a.replace(/{%catigories_title%}/g, data.title);
      const edited_c = edited_b.replace(/{%catigories_description%}/g, data.description);
      const edited_d = edited_c.replace(/{%catigories_image%}/g, data.image);

    $('#catigories_display').append(edited_d);
    });
    if(array == ''){
      document.getElementById('catigories_display').innerHTML = '';
    }
      </script>
      ";
      $catigories_array="";
   $uisql = "SELECT * FROM collection";
     $ydata=$comman_model->get_all_data_by_query($uisql);
   foreach ($ydata as $postsfetchi) {
     $id = $postsfetchi['id'];
     $title = $postsfetchi['title'];
     $description = $postsfetchi['description'];
     $image = $postsfetchi['image'];

     $catigories_array.= "{id:'".$id."',title:'".$title."', description:'".$description."',image:'".$image."'},";
    }
    $content= preg_replace('/{%catigories_array%}/s', $catigories_array, $content);

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
  $ydata=$comman_model->get_all_data_by_query($uisql);
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

  if($compare_price != NULL){
    $sale_percent = (($compare_price-$price)/$compare_price)*100;
    $final_price = "<span style=\"color: forestgreen\">".$price.lang('LYD')."</span><sub><s>".$compare_price.lang('LYD')."</s>(".number_format($sale_percent,1)."%)</sub>";
  }else{
    $final_price = "<span style=\"color: forestgreen\">".$price.lang('LYD')."</span>";
  }

  if($number > 0 || $out_stock == 1){
    $available = "<span class=\"label-success font-size-14 label\">".langs('available')."</span>";
  }else{
    $available = "<span class=\"label-danger font-size-14 label\">".langs('not_available')."</span>";
  }
  $image_location ="";

  $uisql = "SELECT location FROM image WHERE product_id= '$id'";
  $ydata=$comman_model->get_all_data_by_query($uisql);
  foreach ($ydata as $postsfetchx) {
    $image_location = base_url().$postsfetchx['location'];
  }
  $uisql = "SELECT id FROM cart WHERE item_id= '$id' AND user_id='$user_id' AND order_id='0'";
  $udata=$comman_model->get_all_data_by_query($uisql);
  $cart_item = count($udata);

  $uisql = "SELECT id FROM item_like WHERE item_id= '$id' AND user_id='$user_id'";
  $udata=$comman_model->get_all_data_by_query($uisql);
  $like_item = count($udata);

  $cart_button = "<button ".(NULL == $user_id ? 'disabled':'')." id=\"add_cart_$id\" onclick=\"addCart(\\'$id\\')\" aria-label=\"Add to cart\" class=\"btn ".($cart_item < 1 ? 'btn-primary' : 'btn-info')."\">".($cart_item < 1 ? langs('add_cart') : langs('added_cart'))."</button>";
  $like_button = "<button style=\"color: red\" ".(NULL == $user_id ? 'disabled':'')." id=\"item_like_$id\" aria-label=\"Like\" onclick=\"itemLike(\\'$id\\')\" class=\"btn ".($like_item < 1 ? 'fa fa-heart-o ' : 'fa fa-heart '). "btn-white border-dark\"></button>";

    $item_data.= "{id:'".$id."',title:'".$title."', description:'', price:'".$price."', compare_price:'".$compare_price."', available:'".$available."', product_type:'".$product_type."','product_catigory':'".$product_catigory."','collection':'".$collection."','cart_button':'".$cart_button."','like_button':'".$like_button."','item_image':'".$image_location."','final_price':'".$final_price."'},";
  }

$content= preg_replace('/{%items%}/s', $item_data, $content);

$content= preg_replace('/{%navbar_main%}/s', view('includes_site/navbar_main'), $content);
return $content;

}
  ?>
<?php
function replaceLinks($content) {
  // Regular expression patterns for link replacement
  $linkPatterns = array(
    'css' => '/<link\s+(?:[^>]*?\s+)?href="([^"]+)"(?:[^>]*?)>/i',
    'script' => '/<script\s+(?:[^>]*?\s+)?src="([^"]+)"(?:[^>]*?)>/i',
    'anchor' => '/<a\s+(?:[^>]*?\s+)?href="([^"]+)"(?:[^>]*?)>/i',
    'img' => '/<img\s+(?:[^>]*?\s+)?src="([^"]+)"(?:[^>]*?)>/i',
  );

    $replacements = array(
  'css' => function($matches) {
  // Combine both checks for internal and "src" prefix
  return isInternalLink($matches[1]) ? '<link type="text/css" rel="stylesheet" href="'.base_url().'src/' . $matches[1] . '">' : $matches[0];
  },
  'script' => function($matches) {
  return isInternalLink($matches[1])  ? '<script src="'.base_url().'src/' . $matches[1] . '">' : $matches[0];
  },
  'anchor' => function($matches) {
  return isInternalLink($matches[1]) ? '<a href="'.base_url().'home/page/' . $matches[1] . '">' : $matches[0];
  },
  'img' => function($matches) {
  return isInternalLink($matches[1]) ? '<img src="'.base_url().'src/' . $matches[1] . '">' : $matches[0];
    },

  );

  // Loop through each pattern and perform replacement using callback
  foreach ($linkPatterns as $type => $pattern) {
    $content = preg_replace_callback($pattern, $replacements[$type], $content);
  }

  return $content;
}
function needsSrcPrefix($path) {
  // Check if the path already contains "src/"
  return !strpos($path, 'src/') && !strpos($path, '/'); // Exclude absolute paths
}

// Function to check if the link is internal
function isInternalLink($url) {
  // Check if the URL starts with a protocol (external)
  if (strpos($url, 'http') === 0) {
    return false;
  }
  // Check if the URL starts with a slash (absolute path)
  if (strpos($url, '/') === 0) {
    return false;
  }
  // Internal link if none of the above conditions are met
  return true;
}
 ?>
<?php
function resize_image($url, $new_width) {

	// Get the image file contents from the URL
	$image_data = file_get_contents($url);

	// Create an image resource from the file contents
	$image = imagecreatefromstring($image_data);

	// Get the original width and height of the image
	$orig_width = imagesx($image);
	$orig_height = imagesy($image);

	// Calculate the new height based on the new width
	$new_height = ($new_width / $orig_width) * $orig_height;

	// Create a new image resource with the new dimensions
	$new_image = imagecreatetruecolor($new_width, $new_height);

	// Copy the original image to the new image with the new dimensions
	imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

	// Output the resized image to the browser
	header('Content-Type: image/jpeg');
	imagejpeg($new_image);

	// Clean up the image resources
	imagedestroy($image);
	imagedestroy($new_image);
}
?>
<?php
function displayVersion() {
return $_ENV['PROJECT_VERSION'];
}
?>
<?php
function file_upload($path,$name,$accept,$size){
	LoadLang();
	$image = addslashes(file_get_contents($_FILES[$name]['tmp_name']));
	$image_name = addslashes($_FILES[$name]['name']);
	$image_size = getimagesize($_FILES[$name]['tmp_name']);

	$post_fileName = $_FILES[$name]["name"];
	$post_fileTmpLoc = $_FILES[$name]["tmp_name"];
	$post_fileType = $_FILES[$name]["type"];
	$post_fileSize = $_FILES[$name]["size"];
	$post_fileErrorMsg = $_FILES[$name]["error"];
	$post_fileName = preg_replace('#[^a-z.0-9]#i', '', $post_fileName);
	$post_kaboom = explode(".", $post_fileName);
	$post_fileExt = end($post_kaboom);
	$post_fileName = time().rand().".".$post_fileExt;

	if (!$post_fileTmpLoc) {
		$location = '<p class="error_msg">'.langs('errorPost_n2').'</p>';
	}else{
		//================[ if image size more than 8Mb ]================
		if($size != NULL && $post_fileSize > $size) {
			$location = '<p class="error_msg">'.langs('errorPost_n3').'</p>';
			unlink($post_fileTmpLoc);
		} else {
			//================[ if image format not supported ]================
			if ($accept != NULL && !preg_match("/.($accept)$/i", $post_fileName) ) {
				$location = '<p class="error_msg">'.langs('errorPost_n4').'</p>';
				unlink($post_fileTmpLoc);
			} else {
				//================[ if an error was found ]================
				if ($post_fileErrorMsg == 1) {
					$location = '<p class="error_msg">'.langs('errorPost_n5').'</p>';
				}else{

					move_uploaded_file($_FILES[$name]["tmp_name"], "Asset/upload/$path/" .$post_fileName);
					$location = "Asset/upload/$path/" .$post_fileName;
				}}}}
	return $location;
}
function resizeimage($file, $newWidth, $newHeight, $destination) {
// Get the original image size and create a new image with the given dimensions
	list($width, $height) = getimagesize($file);
	$image = imagecreatetruecolor($newWidth, $newHeight);

// Load the original image and resize it
	$original = imagecreatefromstring(file_get_contents($file));
	imagecopyresampled($image, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// Save the resized image to the destination path
	return imagepng($image, $destination);
}
?>
<?php
function browsing($table_name,$column,$id){
	ob_start();

$comman_model = new \App\Models\Comman_model();

	if($id != NULL){
		$id = "user_id = '".$_SESSION['id']."'";
	}
	echo "<datalist id='br_$column'>";

	$browsing = "SELECT DISTINCT $column FROM $table_name WHERE 1 $id";
	$FetchData=$comman_model->get_all_data_by_query($browsing);
	foreach ($FetchData as $postsfetch ) {
		$value = $postsfetch[$column];
		echo "<option value='$value'>";
	}
	echo "</datalist>";
	return ob_get_clean();
}
?>
<?php
function count_table($table_name,$column,$value,$sid){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();

	helper(
			array('numkmcount')
	);

	if($sid != NULL){
		$where = " AND user_id = '$sid'";
	}
	if($value != NULL){
		$where_to = "AND $column = '$value'";
	}
	$count = 0;
	$emExist = "SELECT $column FROM $table_name WHERE 1 $where";
	$FetchData=$comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch) {
		$count =+ 1;
	}
	$emExist = "SELECT DISTINCT $column FROM $table_name WHERE 1 $where $where_to";
	$FetchData=$comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch) {
		$value = $postsfetch[$column]; ?>
		<div class="col-xl-3 col-md-6 col-12 ">
			<div id="container_<?php echo $value; ?>" class="box box-inverse">
				<div class="box-body">
					<div class="flexbox">
						<h5><?php echo $value; ?></h5>
						<div class="dropdown">
							<span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
							</div>
						</div>
					</div>

					<div class="text-center my-2">
						<div class="font-size-60"><?php if($count == "" ){echo "0";}else{echo thousandsCurrencyFormat($count);} ?></div>
						<span><?php echo $value; ?></span>
					</div>
				</div>
			</div>
		</div>
		<script>
			function setup_<?php echo $value; ?>(){

				var container = document.getElementById("container_<?php echo $value; ?>");

				for (var i = 0; i < 1; i++) {
					var colors = random_bg_color();
					container.style.backgroundColor = colors;

				}
			}
			setup_<?php echo $value; ?>()
		</script>
	<?php } ?>
	<?php
	return ob_get_clean();
}
?>
<?php
function price_display($price, $compare, $quantity) {
	global $sum_price;
	if($compare != NULL){
		$sale_percent = (($compare-$price)/$compare)*100;
		$final_price = "<span style=\"color: forestgreen\">".$price.lang('LYD')."</span><sub><s>".$compare.lang('LYD')."</s> (".number_format($sale_percent,1)."%)</sub>";
		$sum_price = $price*$quantity;
	}else{
		$final_price = "<span style=\"color: forestgreen\">".$price.lang('LYD')."</span>";
		$sum_price += $price*$quantity;
	}
	return $final_price;
}
?>
<?php
function img_output($id){


	// You may need to load the model if it hasn't been pre-loaded
$comman_model = new \App\Models\Comman_model();

$location="";

	$uisql = "SELECT location FROM image WHERE product_id= '$id'";
	$udata=$comman_model->get_all_data_by_query($uisql);
	foreach ($udata as $postsfetch ) {
		$location = $postsfetch['location'];
	}
	if($location == NULL){
		$location = "Asset/imgs/product.png";
	}
	return $location;
}
?>
<?php
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
	$R = 6371; // Radius of the Earth in kilometers
  $lat1 = floatval($lat1);
  $lon1 = floatval($lon1);
  $lat2 = floatval($lat2);
  $lon2 = floatval($lon2);

	$dLat = deg2rad($lat2 - $lat1);
	$dLon = deg2rad($lon2 - $lon1);

	$a = sin($dLat / 2) * sin($dLat / 2) +
			cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
			sin($dLon / 2) * sin($dLon / 2);

	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

	$distance = $R * $c;
	$distancing = round($distance, 2);
	return $distancing;
}
?>
<?php
function settings_output($type,$id){

$comman_model = new \App\Models\Comman_model();

$value='';
	$uisql = "SELECT * FROM settings WHERE user_id= '$id' AND type='$type'";
	$udata=$comman_model->get_all_data_by_query($uisql);
	$count_val = count($udata);
	foreach ($udata as $postsfetch ) {
		$value = $postsfetch['value'];
	}
	if($type == "profile_img" && $count_val < 1){
		$value = "Asset/imgs/user-male.png";
	}
	if($type == "profile_back" && $count_val < 1){
		$value = "Asset/imgs/1.jpg";
	}
	return $value;
}
?>
<?php
function settings($type,$access,$value){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();

	$sid = $_SESSION['id'];

		$access_id = $sid;

	if($_SESSION[$type] != $value) {
		$uisql = "SELECT * FROM settings WHERE user_id= '$sid' AND type='$type'";
		$udata = $comman_model->get_all_data_by_query($uisql);
		$count_set = count($udata);
		if ($count_set > 0) {
			$data = array(
					'value' => $value,
			);
			$where = array('user_id' => $access_id, 'type' => $type);
			$update_info = $comman_model->update_entry("settings", $data, $where);
		} else {
			$iptdbsqli = "INSERT INTO settings
  (user_id,type,value,access)
  VALUES
  ($access_id, '$type', '$value', '$access')
  ";
			$insert_post_toDBi = $comman_model->run_query($iptdbsqli);
		}
		$_SESSION[$type] = $value;
	}
	return ob_get_clean();
}
?>
<?php
function table_view($table_name,$column,$filter){
	ob_start();
	session_start();
$CI = \Config\Services::request();
$comman_model = new \App\Models\Comman_model();
	?>
	<div class="table-responsive">
		<table class="reports_1 table table-lg invoice-archive reports_1">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo langs('Username'); ?></th>
				<?php
				if($column != NULL){
					foreach($column as $column_name => $value){ ?>
						<th><?php echo lang($value); ?></th>
					<?php }
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							echo "<th>".lang($postsfetchi->name)."</th>";
						}
					}
				}
				?>
				<th><span class="fa fa-cog"></span></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$q = filter_var(htmlentities($CI->getGet('q')),FILTER_SANITIZE_STRING);
			$val = filter_var(htmlentities($CI->getGet('val')),FILTER_SANITIZE_STRING);
			if($q != NULL && $val != NULL){
				$filter = "AND $q='$val'";
			}
			$vpsql = "SELECT * FROM $table_name WHERE 1 $filter ORDER BY id DESC";
			$result=$comman_model->get_all_data_by_query($vpsql);
			foreach ($result as $postsfetch)
			{
				$post_id = $postsfetch['id'];
				$user_id = $postsfetch['user_id'];
				if($column != NULL){
					foreach($column as $column_name => $value){
						${"var".$value} = $postsfetch[$column_name];
					}
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							${"var".$postsfetchi->name} = $postsfetch[$postsfetchi->name];
						}
					}
				}
				$vpsql = "SELECT * FROM signup WHERE id='$user_id'";
				$result=$comman_model->get_all_data_by_query($vpsql);
				foreach ($result as $postsfetchi)
				{
					$username = $postsfetchi['username'];
				}
				$acc_colum += 1;
				echo"<tr id='tr_$post_id'>
  <td> $acc_colum</td>
  <td> $username</td>
";
				if($column != NULL){
					foreach($column as $column_name => $value){
						echo "<td><a href='?q=$column_name&val=".${"var".$value}."'> ".${"var".$value}."</a></td>";
					}
				}else{
					$fields = $comman_model->getFieldData($table_name);
					foreach ($fields as $postsfetchi)
					{
						if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
							echo "<td>".${"var".$postsfetchi->name}."</td>";
						}
					}
				}
				echo"
  <td class='text-center'>
  <div class='list-icons d-inline-flex'>
  <div class='list-icons-item dropdown'>
  <a href='#' class='list-icons-item dropdown-toggle' data-toggle='dropdown'><i class='fa fa-file-text'></i></a>
  <div class='dropdown-menu dropdown-menu-right'>
  <a href='#' onclick=\"print_co('$post_id')\" class='dropdown-item'><i class='fa fa-print'></i> ".langs('print')."</a>
  <div class='dropdown-divider'></div>
  <a href='#' onclick=\"delete_transaction('$table_name','$post_id')\" style='color:#d71717' class='dropdown-item'><i class='fa fa-remove'></i> ".langs('delete')."</a>
  </div>
  </div>
  </div>
  </td>
  </tr>";
			}
			?></tbody>
		</table>

	</div>

	<?php
	return ob_get_clean();
}
?>
<?php
function form_back($table,$form_array){
	ob_start();
	session_start();

	$sid = $_SESSION['id'];
	// You may need to load the model if it hasn't been pre-loaded
$comman_model = new \App\Models\Comman_model();
	$pid = filter_var(htmlentities($_GET['pid']),FILTER_SANITIZE_STRING);
	if($pid == $table) {
		$table_data = array(
				'id' => $sid,
				'user_id' => $sid,
		);
		foreach ($form_array as $name => $settings) {
			${'var_' . $name} = filter_var(htmlspecialchars($_POST[$name]), FILTER_SANITIZE_STRING);
			$table_data = array($name => ${'var_' . $name},);
		}

		$inserted = $comman_model->insert_entry($table, $table_data);

		if (isset($inserted)) {
			echo "<span class='success_msg'>" . langs('changes_saved_seccessfully') . "</span>";
		} else {
			echo "<span class='error_msg'>" . langs('errorSomthingWrong') . "</span>";
		}
	}
	return ob_get_clean();
}
?>
<?php
function form_view($form_array){
	ob_start();
	session_start();

$comman_model = new \App\Models\Comman_model();?>
	<div class="box">
		<div class="box-header">
			<h4><?php echo langs('add_image'); ?></h4>
		</div>
		<div class="box-body">
			<form action="<?php echo base_url(); ?>item/add_item" id="postingToDB" method="post" enctype="multipart/form-data">
				<?php foreach ($form_array as $name => $settings){ ?>
					<div class="form-group">
						<label><?php echo lang($name); ?></label>
						<input type="text" name="<?php echo $name; ?>" title="" id="<?php echo $name; ?>" value="" autocomplete="off" placeholder="<?php echo lang($name); ?>" class="form-control font-size-20">
					</div>
				<?php } ?>
				<div class="box-footer">
					<div class="loadingPosting"></div>
					<button type="submit" value="<?php echo langs('save_changes'); ?>"class="btn btn-rounded btn-primary btn-outline" >
						<i class="ti-save-alt"></i> <?php echo langs('save'); ?>
					</button>
				</div>

			</form>
		</div>
	</div>
	<?php return ob_get_clean();
}
?>
