<?php
/*	Class Function for Admin	*/

class ManageAds extends MysqlFns
{
	function ManageAds()
	{
		global $config;
		$this->MysqlFns();
		$this->Offset			= 0;
		$this->Limit			= 10;
		$this->page				= 0;
		$this->Keyword			= '';
		$this->Operator			= '';
		$this->PerPage			= '';
	}
	
function selectuserByID(){
		global $objSmarty;
		if($_REQUEST['Ident']!=''){
			$selQuery="select * from tbl_users where ID='".$_REQUEST['Ident']."'";
			$result=$this->ExecuteQuery($selQuery,"select");
			$objSmarty->assign("Ads",$result);
		}
		else{
			redirect('manage_user.php');
		}
	}
function getCountrynameById($CountryID){
	
		global $objSmarty;
		$SelQuery1	= "select * from `tbl_country` where ID='".$CountryID."'";
		$res= $this->ExecuteQuery($SelQuery1,"select");
	return $res[0][Countryname];
	
	}	
function getStatenameById($StateID){
	
		global $objSmarty;
		$SelQuery1	= "select * from `tbl_state` where ID='".$StateID."'";
		$res= $this->ExecuteQuery($SelQuery1,"select");
	    return $res[0][Statename];
	
	}	
function getCitynameById($CityID){
	
		global $objSmarty;
		$SelQuery1	= "select * from `tbl_city` where ID='".$CityID."'";
		$res= $this->ExecuteQuery($SelQuery1,"select");
	    return $res[0][Cityname];
	
	}
function getcountryid(){
		global $objSmarty;
		$selQuery="select * from tbl_country where Status='1' order by Countryname asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("country",$res);
	}	
	

function getstateid(){
		global $objSmarty;
		$selQuery="select * from tbl_state where Status='1' order by Statename asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("state",$res);
	}	
	
function getstateid1($CountryID){
		global $objSmarty;
		$selQuery="select * from tbl_state where Status='1' order by Statename asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("state",$res);
	}	
	
	
function getcityid(){
		global $objSmarty;
		$selQuery="select * from tbl_city where Status='1' order by Cityname asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("city",$res);
	}
		
function getcityid1($StateID){
		global $objSmarty;
		$selQuery="select * from tbl_city where Status='1' order by Cityname asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("city",$res);
	}

}
?>
