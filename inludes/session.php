<?
ob_start();

session_start();

if(!defined("_MAINSITEPATH_"))

		define("_MAINSITEPATH_",$_SERVER['DOCUMENT_ROOT']."/craving/includes/");

	include_once _MAINSITEPATH_."config.php";

	include_once _MAINSITEPATH_."dbNames.php";

	include_once $config['SiteClassPath']."class.SqlFunctions.php";

	include_once $config['SiteLocalPath']."includes/smarty/Smarty.class.php";	

	global $config;

	$objSmarty	= new Smarty();

if(isset($_SESSION))

		$objSmarty->assign("Session", $_SESSION);



?>

