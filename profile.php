<?php
include "includes/common.php";
include_once $config['SiteClassPath']."class.Content.php";
include_once $config['SiteClassPath']."class.Admin.php";
include_once $config['SiteClassPath']."class.Category.php";
include_once $config['SiteClassPath']."class.split_page_results.php";
print_r($_REQUEST);
print_r($_FILES);
$objContent	= new Content();
$objAdmin	= new Admin();
$objCategory	= new Category();

$objContent->getallusers();
//$objAdmin->edituser();
$objSmarty->assign("objCategory",$objCategory);
$objSmarty->assign("objContent",$objContent);
$objSmarty->display("profile.tpl");

?>