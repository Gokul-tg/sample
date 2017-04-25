<?php 
	include "includes/common.php";
    include_once $config['SiteClassPath']."class.Admin.php";
	include_once $config['SiteClassPath']."class.split_page_results.php";
	$objAdmin	= new Admin();
		if($_REQUEST['hdAction'] != '')
	{
		
		$objAdmin->userlogin();
	}
	$objSmarty->assign("objAdmin", $objAdmin);
	$objSmarty->display("index.tpl");
?>