<?php

include "includes/common.php";
include_once $config['SiteClassPath']."class.Admin.php";
include_once $config['SiteClassPath']."class.Content.php";

$objAdmin	= new Admin();
$objContent	= new Content();

if($_REQUEST['hdAction']=='1')
{
	$objSmarty->assign('login',$_REQUEST);
}
$objAdmin->checkUserLogin();
$objSmarty->assign("objContent",$objContent);
$objSmarty->assign("objAdmin",$objAdmin);
$objSmarty->display("login.tpl");


?>