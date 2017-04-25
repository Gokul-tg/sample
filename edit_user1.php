<?php 
	include "includes/common.php";
    include_once $config['SiteClassPath']."class.Admin.php";
    include_once $config['SiteClassPath']."class.Content.php";
	include_once $config['SiteClassPath']."class.split_page_results.php";
	$objAdmin	= new Admin();
	$objContent	= new Content();
//print_r($_REQUEST);exit;
		if($_REQUEST['hdAction'] != '')
	{
		
		$objAdmin->edituser();
	}
	$objContent->getallusers();
	$objAdmin->getUserById();
	$objSmarty->assign("objContent",$objContent);
	$objSmarty->assign("objAdmin", $objAdmin);
	$objSmarty->display("edit_user.tpl");
?>