<?php
$datas['page'] = $page_name;
$datas['title'] = $page_name;
$comman_model = new \App\Models\Comman_model();
 ?>
<!DOCTYPE html>
<html class="<?php echo view("includes/mode"); ?>" translate="no" lang="en">
<head>
  <?php echo view("includes/head_info", $datas); ?>
  	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.x.x/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.x.x/dist/leaflet.js" ></script>

</head>
<body id="body" class="<?php echo view("includes/mode"); ?> <?php echo langs('html_dir'); ?> no-sidebar  theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom">
  <div id="loader"></div>
<?php echo view('includes_site/navbar_main', $datas); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper content-wrapper-50">
    <div class="container-full">
      <!-- Main content -->
      <section class="content-height">
        <?php if($quantity == 0){ ?>
          <div class="post loading-info" style="min-width: 99%;"><p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo langs('your_cart_is_empty'); ?></p></div>
        <?php }else{
          if($isOrder == 0 && $pid!=NULL){ ?>
            <div class="post loading-info" style="min-width: 99%;"><p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo langs('order_not_found'); ?></p></div>
        <?php }else{ ?>
        <a href="" class="none-link"> <div class="box">
            <div class="vtabs padding-10">
              <div style="background: url('../../Asset/imgs/logo.png') no-repeat center center;" class="tabs-vertical side-product shop-cart-image">
              </div>
              <div class="box-body">
                <p><strong class="font-size-20"><?php echo $_ENV['PROJECT_NAME'] ?></strong></p>
              </div>
            </div>
          </div></a>
          <?php if($pos == 0){ ?>
          <?php if($pid != NULL){ ?>
          <div class="box">
              <div class="box-body">
                <h4><span class="font-size-20"><span class="float-left">#<?php echo $order_id; ?></span></span></h4>
                <br>
                <p><?php echo $date; ?> <small>(<?php echo time_ago(strtotime($date)); ?>)</small> <a href="tel:<?php echo $costumer_phone; ?>"> <button style="margin-left: 5px" class="btn btn-primary float-right"><?php echo langs('call_costumer'); ?></button></a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $_ENV['LAT']; ?>,<?php echo $_ENV['LONG']; ?>&travelmode=driving"><button style="margin-left: 5px" class="btn btn-primary float-right"><?php echo langs('shop_directions'); ?></button></a>
                  <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $costumer_lat; ?>,<?php echo $costumer_long; ?>&travelmode=driving"><button style="margin-left: 5px" class="btn btn-primary float-right"><?php echo langs('costumer_directions'); ?></button></a>
                  <a href="tel:<?php echo $_ENV['PHONE_NUMBER']; ?>"> <button style="margin-left: 5px" class="btn btn-primary float-right"><?php echo langs('call_shop'); ?></button></a>
                </p>
              </div>
            </div>
          <?php } ?>
<?php if($_ENV['REGISTER_FORM'] == 'TRUE' && $user_id == NULL){ ?>
        <?php }else{ ?>
          <div class="box">
              <div class="box-header">
                <h4 class="font-size-20"><span class="fa fa-location-arrow"></span> <?php echo langs('deliver_to'); ?> <span class="label-primary label"><?php echo $costumer_location_name; ?></span><?php if($isOrder == 0 && $pid==NULL){ ?> <a href="<?php echo base_url(); ?>Setting?pid=location"><button class="btn btn-icon-circle-medium btn-primary float-right fa fa-pencil"></button><?php } ?></a> </h4>
              </div>
              <div class="box-body">
                <span class="font-size-20"><?php echo $costumer_address; ?></span>
              </div>
            </div>
      <?php } ?>
    <?php } ?>


      <?php
      $quantity = 0;
      $quantity_val = 0;
      $item_data ="";
      $sum_price =0;
      $uisql = "SELECT item_id, quantity,date,variants FROM cart WHERE user_id= '$costumer_id' AND order_id='".$order_id."' ORDER BY date DESC";
      $xdata=$comman_model->get_all_data_by_query($uisql);
      foreach ($xdata as $postsfetch) {
        $item_id = $postsfetch['item_id'];
        $quantity = $postsfetch['quantity'];
        $variants = $postsfetch['variants'];
        $variants=array($variants);
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
        $sum_price += $price*$quantity; ?>
        <div class="box" id="cart_id_<?php echo $id; ?>">
           <div class="item-cart-grid">
             <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $item_id; ?>" class="none-link">
             <div style="background: url('<?php echo $image_location; ?>') no-repeat center center;height: 100% !important;width: 97% !important;" class="tabs-vertical side-product">
             </div>
             </a>
             <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $item_id; ?>" class="none-link">
             <div class="padding-10">
               <h4><span class="font-size-20"><?php echo $title; ?></span></h4>
               <p class="font-size-14"><?php echo $price; ?> <?php if($variants[0] !='0'){?>(<?php foreach($variants as $value){echo "$value";}?>)<?php } ?></p>
             </div>
             </a>
             <div>
               <div class="float-right padding-10">
                 <br>
                 <?php if($isOrder == 0 && $pid==NULL){ ?><button type="button" onclick="quantity('add','<?php echo $item_id; ?>')" class="btn btn-primary btn-icon-circle-small fa fa-plus"></button><?php } ?>
                 <input type="text" id="quantity_input_<?php echo $item_id; ?>" value="<?php echo $quantity; ?>" class="btn btn-icon-circle-medium border-black text-center" disabled>
                 <?php if($isOrder == 0 && $pid==NULL){ ?><button type="button" onclick="quantity('minus','<?php echo $item_id; ?>')" class="btn btn-primary btn-icon-circle-small fa fa-minus"></button><?php } ?>
               </div>
             </div>
           </div>
         </div>
        <?php
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
          $uisql = "SELECT location FROM image WHERE product_id= '$id'";
          $ydata=$comman_model->get_all_data_by_query($uisql);
          foreach ($ydata as $postsfetchx) {
            $image_location = base_url().$postsfetchx['location'];
          }
          $quantity = $quantity/$discount_value_z;
          $quantity_val += $quantity; ?>
          <div class="box" id="cart_id_<?php echo $id; ?>">
             <div class="item-cart-grid">
               <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $item_id; ?>" class="none-link">
               <div style="background: url('<?php echo $image_location; ?>') no-repeat center center;height: 100% !important;width: 97% !important;" class="tabs-vertical side-product">
               </div>
               </a>
               <a href="<?php echo base_url(); ?>theme/item?pid=<?php echo $item_id; ?>" class="none-link">
               <div class="padding-10">
                 <h4><span class="font-size-20"><?php echo $title; ?></span></h4>
                 <p class="font-size-14"><span class="label label-primary">هدية</span></p>
               </div>
               </a>
               <div>
                 <div class="float-right padding-10">
                   <br>
                   <input type="text" id="quantity_input_<?php echo $id; ?>" value="<?php echo $quantity; ?>" class="btn btn-icon-circle-medium border-black text-center" disabled>
                 </div>
               </div>
             </div>
           </div>      <?php  }}
      }}}?>

<?php if($_ENV['REGISTER_FORM'] == 'TRUE' && $user_id == NULL){ ?>
<div class="box">
    <div class="box-header">
      <h4 class="font-size-20"><?php echo langs('info'); ?></h4>
    </div>
    <div class="box-body">
      <form action="" method="post">
        <div class="row">
          <div class="col-md-6">
        <div class="form-group">
          <label><?php echo langs('name'); ?></label>
          <input type="text" name="name" id="name" autocomplete="off" placeholder="<?php echo langs('name'); ?>" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
    <div class="form-group">
      <label><?php echo langs('phone'); ?></label>
      <input type="text" name="phone" id="phone_no" autocomplete="off" placeholder="091xxxxxxx" class="form-control">
    </div>
  </div>
  <div class="col-md-6">
<div class="form-group">
  <label><?php echo langs('email'); ?></label>
  <input type="text" name="email" id="email" autocomplete="off" placeholder="example@email.com" class="form-control">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label><?php echo langs('address'); ?></label>
<input type="text" name="address" id="address" autocomplete="off" placeholder="ainzara, tripoli" class="form-control">
</div>
</div>
<div id="map"></div>
<input type="hidden" name="long" id="long">
<input type="hidden" name="lat" id="lat">
<script>
function calculateDistance() {

  const inputLat1 = document.getElementById("lat").value;
 const inputLon1 = document.getElementById("long").value;

 // Parse input values to numbers
 const lat1 = parseFloat(inputLat1);
 const lon1 = parseFloat(inputLon1);

 const lat21 = <?php echo $_ENV['LAT']; ?>;
 const lon21 = <?php echo $_ENV['LONG']; ?>;
 const lat2 = parseFloat(lat21);
 const lon2 = parseFloat(lon21);
  // Convert latitudes and longitudes to radians
  const radLat1 = Math.PI * lat1 / 180;
  const radLat2 = Math.PI * lat2 / 180;
  const radLon1 = Math.PI * lon1 / 180;
  const radLon2 = Math.PI * lon2 / 180;

  // Earth's radius in kilometers
  const earthRadius = 6371;

  // Calculate the difference in latitude and longitude
  const dLat = radLat2 - radLat1;
  const dLon = radLon2 - radLon1;

  // Haversine formula for great-circle distance
  const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(radLat1) * Math.cos(radLat2) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

  // Distance in kilometers
  const distance = earthRadius * c;
  <?php if($_ENV['DELIVERY_TYPE'] == 1){ ?>
     const deliver= distance.toFixed(2)*<?php echo $_ENV['DELIVERY_PRICE']; ?>;
  <?php }else{?>
    const deliver= <?php echo $_ENV['DELIVERY_PRICE']; ?>;
  <?php } ?>


  document.getElementById("distance").textContent = distance.toFixed(2) + "KM";
  document.getElementById("deliver_price").textContent = deliver.toFixed(2)+"<?php echo langs('LYD'); ?>";

}
</script>
<script>


var map = L.map('map').setView([0, 0], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
maxZoom: 18,
}).addTo(map);

var marker = L.marker([0, 0]).addTo(map);

function updateMarker() {
var center = map.getCenter();
marker.setLatLng(center);

// Reverse geocoding using Nominatim API
var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + center.lat + '&lon=' + center.lng;
fetch(url)
.then(response => response.json())
.then(data => {
  var address = data.address;
  var displayAddress = address.road + ', ' + address.city + ', ' + address.country;
  document.getElementById('address').value = displayAddress;

})

.catch(error => {
  console.log('Error:', error);
});
document.getElementById('long').value = center.lng;
document.getElementById('lat').value = center.lat;
calculateDistance();
}

function onLocationFound(e) {
var latlng = e.latlng;
map.setView(latlng, 15);
marker.setLatLng(latlng);
updateMarker();
}

function onLocationError(e) {
console.log(e.message);
}

map.on('move', updateMarker);

// Get user's location
map.locate({ setView: true, maxZoom: 15 });
map.on('locationfound', onLocationFound);
map.on('locationerror', onLocationError);
</script>
      </div>
      </form>
    </div>
  </div>
          <?php } ?>
          <?php if($pos == 0){ ?>
<div class="box">
    <div class="box-header">
      <h4 class="font-size-20"><span class="fa fa-pencil"></span> <?php echo langs('notey'); ?> </h4>
    </div>
    <div class="box-body">
      <input type="text" name="order_note" value="<?php echo $note; ?>" <?php if($isOrder > 0 && $pid!=NULL){ echo "disabled"; }?> id="order_note" class="form-control" placeholder="<?php echo langs('notey'); ?>">
    </div>
  </div>
  <div class="box">
      <div class="box-header">
        <h4 class="font-size-20"><span class="fa fa-pencil"></span> <?php echo langs('code'); ?> </h4>
      </div>
      <div class="box-body">
        <form action="" method="get">
        <div class="input-group mb-3" >
        <div class="input-group">
        <input type="text" name="promocode" value="<?php echo $discount_code; ?>" <?php if($isOrder > 0 && $pid!=NULL){ echo "disabled"; }?> id="promocode" class="form-control" placeholder="<?php echo langs('code'); ?>.">
        <button class="input-group-addon">
        <?php echo langs('try'); ?>
      </button>
    </div>
        </div>
      </form>
      </div>
    </div>
  <?php } ?>
        <div id="refresh" class="box">
          <div class="box-header">
            <h4><?php echo langs('bill'); ?></h4>
          </div>

          <div class="box-body">
            <p><?php echo langs('quantity'); ?> <b class="float-right"><?php echo $quantity_val; ?></b></p>
            <p><?php echo langs('total'); ?> <b class="float-right"><?php echo $sum_price; ?><?php echo langs('LYD'); ?></b></p>
            <p><?php echo langs('distance'); ?> <b id="distance" class="float-right"><?php echo $distance; ?>KM</b></p>
            <p><?php echo langs('delivery_price'); ?> <b id="deliver_price" class="float-right"><?php echo $deliver_price; ?><?php echo langs('LYD'); ?></b></p>
            <p><?php echo langs('branch_total'); ?> <b class="float-right"><?php echo $branch_total; ?><?php echo langs('LYD'); ?></b></p>
          </div>
        </div>
        <?php
        if($pid == NULL){
          $order_id_btn = rand(0,999999);
          $d2 = 2;
        }else{
        $d1 = strtotime("$date +2 minutes");
        $d2 = (($d1)-time())/60;
      }
        ?>
        <div class="box div-bottom">
          <div class="box-body">
            <?php
            if(sessionCI("account_type") == "deliver" && $shop_finish == 0){
            if($accept == '0' || $accept == $sid){
           echo "<button type=\"button\" id=\"accept_btn$order_id\" onclick=\"accept_deliver('$order_id')\" class=\"btn ".($accept == '0'? "btn-primary":"btn-info")."\"> ".($accept == '0'?"".langs('accept')."":"".langs('cancel')."")."</button>";
            }elseif($accept != $sid){
           		echo "<button type=\"button\" class=\"btn btn-primary\" disabled>".langs('order_taken')."</button>";
           	 }
            }elseif(sessionCI("account_type") == "admin"){
            if($accept == '0'){
           	echo "<button type=\"button\" id=\"give_btn$order_id\" class=\"btn btn-primary\" disabled>".langs('no_deliver')."</button>";
            }else{
           		echo "<button type=\"button\" id=\"give_btn$order_id\" onclick=\"giveDeliver('$order_id')\" class=\"btn ".($shop_finish == '0'?'btn-primary':'btn-info')." \">". ($shop_finish == '0'?"".langs('give_deliver')."":"".langs('cancel')."")."</button>";
           	 }
            }else{
              echo "<button type=\"button\" id=\"order_button\" onclick=\"order('".$order_id_btn."'), start_count()\" class=\"btn ".($isOrder > 0 ?" btn-info": " btn-primary") ."\"".($d2 < 0 ? " disabled": "").">".($isOrder > 0 ? "".langs('cancel_order')."":"".langs('add_order')."")."</button><span id=\"timer\"></span>";

            }
            ?>
          </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <script>
          function start_count() {
            var date = "<?php echo strtotime($date); ?>";
           if (date == "") {
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

                $("#timer").text(minutes + ":" + seconds);
                if (distance < 0) {
                  clearInterval(x);
                  $("#order_button").attr("disabled", "true");
                  $("#timer").text("");
                }
            }, 1000);
          }
        </script>
        <?php
        if($isOrder > 0){
          if($d2 > 0){ ?>

        <span>
                <script>start_count()</script>
         </span>


<?php }} ?>
      </section>

    </div>
  </div>
    </div>

     <?php
}
   }
     ?>
     <?php echo view("includes_site/endJScodes", $datas); ?>

<!-- ./wrapper -->
<script src="<?php echo base_url(); ?>Asset/assets/vendor_components/dropzone/dropzone.js"></script>
</body>
</html>
