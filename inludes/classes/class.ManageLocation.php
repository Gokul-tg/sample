<?php
/*	Class Function for Admin	*/

class ManageLocation extends MysqlFns
{
	function ManageLocation()
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
	
	function getCountry(){
		global $objSmarty;
		 $selQuery="select name as countryName,code from cmn_country_mst order by name asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("country",$res);
	}
	
	function getStateByCountry($coun){
		global $objSmarty;
		$selQuery="select * from cmn_state_mst where country='$coun'  order by name asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("state",$res);
	}
	
	function getCityByState($state){
		global $objSmarty;
		 $selQuery="select * from cmn_district_mst where stateId='$state' and deleted='0' order by name asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("city",$res);
	}
	
	function getCityName($id){
		
		global $objSmarty;
		/*$selQuery="select * from cmn_district_mst where id='$id' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$stateId=$res[0]['stateId'];
		$objSmarty->assign("city",$res[0]['name']);
		
		$selQuery="select * from cmn_state_mst where id='$stateId' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$countryCode = $res[0]['country'];
		$objSmarty->assign("state",$res[0]['name']);
		
		$selQuery="select * from cmn_country_mst where code='$countryCode' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("country1",$res[0]['name']);
		$objSmarty->assign("countrycode",$res[0]['code']);*/
		$select="select * from tbl_user where `UserId` = '".$_SESSION['userId']."'";
		$exeselect=$this->ExecuteQuery($select, "select");
		$countryCode = $exeselect[0]['Country'];
		$objSmarty->assign("countrycode",$countryCode);
		$sel="select * from  cmn_country_mst where `code` = '".$countryCode."'";
		$exesel=$this->ExecuteQuery($sel,"select");
		$country = $exesel[0]['name'];
				$objSmarty->assign("country1",$country);
		
	}

	function getCityNames($id){
		global $objSmarty;
		$selQuery="select * from cmn_district_mst where id='$id' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$stateId=$res[0]['stateId'];
		$objSmarty->assign("city",$res[0]['name']);
		
		$selQuery="select * from cmn_state_mst where id='$stateId' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$countryCode = $res[0]['country'];
		$objSmarty->assign("state",$res[0]['name']);
		
		$selQuery="select * from cmn_country_mst where code='$countryCode' limit 1";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("countryName",$res[0]['name']);
		
	}
	
	function getCountryName($id)
	{
		global $objSmarty;
		$selqry="select * from  cmn_country_mst where code='$id'";
		$res=$this->ExecuteQuery($selqry,"select");
		return $res[0]['name'];
	
	}
	function getStateforuserid($id)
	{
		global $objSmarty;
		$selqry="select * from cmn_state_mst where id='$id'";
		$res=$this->ExecuteQuery($selqry,"select");
		$state=$res[0]['name'];
		echo $state;
	}
	function getCityforuserid($id)
	{
		global $objSmarty;
		$selqry="select * from cmn_district_mst where id='$id'";
		$res=$this->ExecuteQuery($selqry,"select");
		$city=$res[0]['name'];
		echo $city;
	}
	
}
?>