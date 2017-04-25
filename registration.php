<?php 
	include "includes/common.php";
    include_once $config['SiteClassPath']."class.Admin.php";
	include_once $config['SiteClassPath']."class.split_page_results.php";
	$objAdmin	= new Admin();
	
//print_r($_REQUEST);
		if($_REQUEST['hdAction'] != '')
	{
		//print_r($_REQUEST);
		$objAdmin->adduser();
	}
	
	$objSmarty->assign("objAdmin", $objAdmin);
	$objSmarty->display("registration.tpl");
?>