<?php 
/* start the session */
ob_start();
session_start();

ini_set('memory_limit','128M');
    ini_get('error_reporting');

	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	
	//ini_set('error_reporting', E_ALL ^ E_DEPRECATED);

	if(!defined("_MAINSITEPATH_"))

		define("_MAINSITEPATH_",$_SERVER['DOCUMENT_ROOT']."/task/includes/");

	if(!defined("EMAIL_LINEFEED"))

		define("EMAIL_LINEFEED",'CRLF');

	if(!defined("EMAIL_TRANSPORT"))

		define("EMAIL_TRANSPORT",'smtp');

	if(!defined("CHARSET"))

		define("CHARSET",'iso-8859-1');

	define('PREVNEXT_BUTTON_PREV', '<b>&lt;&lt;</b>');

	define('PREVNEXT_BUTTON_NEXT', '<b>&gt;&gt;</b>');

	define('TEXT_DISPLAY_NUMBER_OF_RESULT', '<b>%d</b> to <b>%d</b> (of <b>%d</b>)');

	define('TEXT_RESULT_PAGE', 'Page %s of %d');

	define('TEXT_RESULT_PAGE1', 'Pages:');

	define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');

	define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');

	define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');

	define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');

	define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');

	define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');

	define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');

	define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');

	define('PREVNEXT_BUTTON_PREV1', '[&lt;&lt;&nbsp;Prev]');

	define('PREVNEXT_BUTTON_NEXT1', '[Next&nbsp;&gt;&gt;]');

	define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

	/*Default Country For Browse */

	include_once _MAINSITEPATH_."config.php";

	include_once $config['SiteClassPath']."class.SqlFunctions.php";

	include_once $config['SiteLocalPath']."includes/smarty/Smarty.class.php";

	
	global $config;

	$objSmarty	= new Smarty();
	
	$access = new MysqlFns();
	
	function printArray($Array)
	{
		print "<Pre>";
		print_r($Array);
		print "</Pre>";
	}
	//PrintArray($_SESSION);
	function Redirect($Url)
	{
		header("Location:".$Url);
		exit;
	}
	
	function PrePopulate($objArray, $ArrayName='')
	{
		global $objSmarty;
		if(!empty($objArray) && is_array($objArray))
		{
			if(!empty($ArrayName))
			{	
				$Array = array();

				foreach($objArray as $key=>$value)

					$Array[$key] = $value;

				$$ArrayName	= $Array;

				$objSmarty->assign($ArrayName,$$ArrayName);
			}
			else
			{
				foreach($objArray as $key=>$value)
				{
					$objSmarty->assign($key,$value);
				}

			}

		}

	}

	if (isset($_SERVER['HTTP_USER_AGENT']) && 
	(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	{$objSmarty->assign("iecheck","true");}
	else{$objSmarty->assign("iecheck","false");}

	/*Drop Down Menu Start */
   function not_null($value) {

    if (is_array($value)) {

      if (sizeof($value) > 0) {

        return true;

      } else {

        return false;

      }

    } else {

      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {

        return true;

      } else {

        return false;

      }

    }

  }

	function output_string($string, $translate = false, $protected = false) {

    if ($protected == true) {

      return htmlspecialchars($string);

    } else {

      if ($translate == false) {

        return parse_input_field_data($string, array('"' => '&quot;'));

      } else {

        return parse_input_field_data($string, $translate);

      }

    }

  }

// Parse the data used in the html tags to ensure the tags will not break

  function parse_input_field_data($data, $parse) {

    return strtr(trim($data), $parse);

  }

  	function convert_linefeeds($from, $to, $string) 
	{
		if ((PHP_VERSION < "4.0.5") && is_array($from)) 
		{
			//return ereg_replace('(' . implode('|', $from) . ')', $to, $string);
		} 

		else 
		{
			return str_replace($from, $to, $string);
		}
	}

  /*Drop Down Menu End */

 function get_all_get_params($exclude_array = '') {
    global $HTTP_GET_VARS;
	$query_string=explode("&",$_SERVER['QUERY_STRING']);
    if (!is_array($exclude_array)) $exclude_array = array();
	
	if(count($query_string) > 1)
	{
		//$get_url = $query_string[0].'&'.$query_string[1];
		$que=explode("=",$query_string[1]);
		if($que[0]!="page")
		{
			$get_url = $query_string[0]."&".$query_string[1];
		}
		else
		{
			$get_url = $query_string[0];
		}
	}
	else
	{
		$que=explode("=",$query_string[0]);
		if($que[0]!="page")
		{
			$get_url = $query_string[0];
		}
		else
		{
			$get_url = '';
		}
	}
    if (is_array($HTTP_GET_VARS) && (sizeof($HTTP_GET_VARS) > 0)) {
      reset($HTTP_GET_VARS);
      while (list($key, $value) = each($HTTP_GET_VARS)) {
        if ( (strlen($value) > 0) && ($key != temp_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
          $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }
	//print_r($get_url);
    return $get_url;
  }

  function db_input($string) {

    global $link;

    if (function_exists('mysql_real_escape_string')) {

      return mysql_real_escape_string($string);

    } elseif (function_exists('mysql_escape_string')) {

      return mysql_escape_string($string);

    }

    return addslashes($string);

  }

    function get_uprid($prid, $params) {

    if (is_numeric($prid)) {

      $uprid = $prid;

      if (is_array($params) && (sizeof($params) > 0)) {

        $attributes_check = true;

        $attributes_ids = '';

        reset($params);

        while (list($option, $value) = each($params)) {

          if (is_numeric($option) && is_numeric($value)) {

            $attributes_ids .= '{' . (int)$option . '}' . (int)$value;

          } else {

            $attributes_check = false;

            break;

          }

        }

        if ($attributes_check == true) {

          $uprid .= $attributes_ids;

        }

      }

    } else {

      $uprid = get_prid($prid);

      if (is_numeric($uprid)) {

        if (strpos($prid, '{') !== false) {

          $attributes_check = true;

          $attributes_ids = '';

// strpos()+1 to remove up to and including the first { which would create an empty array element in explode()

          $attributes = explode('{', substr($prid, strpos($prid, '{')+1));

          for ($i=0, $n=sizeof($attributes); $i<$n; $i++) {

            $pair = explode('}', $attributes[$i]);



            if (is_numeric($pair[0]) && is_numeric($pair[1])) {

              $attributes_ids .= '{' . (int)$pair[0] . '}' . (int)$pair[1];

            } else {

              $attributes_check = false;

              break;

            }

          }

          if ($attributes_check == true) {

            $uprid .= $attributes_ids;

          }

        }

      } else {

        return false;

      }

    }

    return $uprid;

  }
  function temp_session_name($name = '') {
    if (!empty($name)) {
      return session_name($name);
    } else {
      return session_name();
    }
  }
  
   function href_link($page = '', $parameters = '', $connection = 'NONSSL') 
  {
    if ($parameters == '') {
      $link = $link . $page . '?' . SID;
    } else {
      $link = $link . $page . '?' . $parameters . '&' . SID;
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

    return $link;
  }
  $sql="select * from admin where Ident='1'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
 	$adminmail=$result['Email'];
 	$objSmarty->assign("adminEmail",$adminmail);
?>