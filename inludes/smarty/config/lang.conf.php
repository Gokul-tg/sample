
<?php

// This just initializes Smarty with the locations of the 
// directories it will use

$full_path =         dirname(__FILE__)."/";

define ("SMARTY_DIR",$full_path."libs/Smarty/");
define ("TEMPLATES_PATH",$full_path . "templates");
define ("TEMPLATES_C_PATH",$full_path . "templates_c");
define ("CONFIGS_PATH",$full_path . "configs");
define ("CACHE_PATH",$full_path . "cache");

require_once SMARTY_DIR."Config_File.class.php";
require_once SMARTY_DIR."Smarty.class.php";

// Initialize a new smarty object
$smarty = new Smarty ();

// Assign some variables in our templates file
$smarty->assign ("title", "Smarty Introduction");
$smarty->assign ("body", "Hello There.");

// Thanks goes out to the authors of Smarty 
// Note we are appending here and filling in a dynamic section
$smarty->append ("first", "Monte");
$smarty->append ("last", "Ohrt");

$smarty->append ("first", "Andrei");
$smarty->append ("last", "Zmievski");



[name_form]
    whats_your_name = What is your name?
    first_name = First Name
    last_name = Last Name
    submit = Submit





// Show the template
$smarty->display ("index.tpl");

?>

