<?php
// check current version number
require("config.php");
// open version file on external server
$file = fopen ($ext_version_loc, "r");
$vnum = fgets($file);
fclose($file);
// check users local file for version number
$userfile = fopen ($vnum_loc, "r");
$user_vnum = fgets($userfile);
fclose($userfile);

$hashtags_url = '/[\\r\n]/';
 $user_vnum = preg_replace($hashtags_url, "", $user_vnum);
  $vnum = preg_replace($hashtags_url, "", $vnum);

if($user_vnum == $vnum){
	// data
	$data = array("version" => 0);
}else{
	// data
	$data = array("version" => $vnum);
}
// send the json data
echo json_encode($data);
?>
