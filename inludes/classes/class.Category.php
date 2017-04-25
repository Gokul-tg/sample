<?php
/*	Class Function for Admin	*/
class Category extends MysqlFns
{
	function Category()
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
function manage_country()
{
global $objSmarty,$objPage;

		$where_condition="";

		if($_REQUEST['keyword']!="")
		$where_condition.="and `Countryname` like '%".addslashes(trim($_REQUEST['keyword']))."%'";

	if($_REQUEST['flag']!=""){
			if($_REQUEST['flag']=="1")
			$where_condition1.=" order by `Countryname` asc";
			if($_REQUEST['flag']=="2")
			$where_condition1.=" order by `Countryname` desc";
		}else{
			$where_condition1.=" order by `ID` desc";
		}
	$SelQuery	= "select * from  `tbl_country` where  ID!='' ".$where_condition .$where_condition1 ;
			
		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);
		$objSmarty->assign("pageno",$_REQUEST['page']);
		$listing_split = new MsplitPageResults($SelQuery, $this->Limit);
		
		if ( ($listing_split->number_of_rows > 0) )
		{
			$pagenos=round($listing_split->number_of_rows/$this->Limit)."<br/>";
			$rem=($listing_split->number_of_rows%$this->Limit);
			if($rem>0 && $rem <5 ){
				$pagenos=$pagenos+1;
			}
			if($_REQUEST['page']!="")
			{
				if($_REQUEST['page']-$pagenos>0)
				{
					$pagenos=$_REQUEST['page']-1;
					$i= ($this->Limit * $pagenos )-$this->Limit +1;
					$objSmarty->assign("pageno",$pagenos);
					$objSmarty->assign("i",$i);
				}
				if($this->Limit==$listing_split->number_of_rows)
				{
					$objSmarty->assign("i",1);
				}
			}
			$objSmarty->assign("LinkPage",$listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_RESULT));
			$objSmarty->assign("PerPageNavigation",TEXT_RESULT_PAGE1 . ' ' . $listing_split->display_links($this->Limit, get_all_get_params(array('page', 'info', 'x', 'y'))));
		}

		if ($listing_split->number_of_rows > 0)
		{
			$rows = 0;
			$Res_Tickets	= $this->ExecuteQuery($listing_split->sql_query, "select");
		}
		if(!empty($Res_Tickets)&& is_array($Res_Tickets))
		$objSmarty->assign("Country",$Res_Tickets);

	}

function manage_users()
	{
		 
		global $objSmarty,$objPage;

		$where_condition="";

		if($_REQUEST['keyword']!="")
		$where_condition.="and `Username` like '%".addslashes(trim($_REQUEST['keyword']))."%'";

	if($_REQUEST['flag']!=""){
			if($_REQUEST['flag']=="1")
			$where_condition1.=" order by `Username` asc";
			if($_REQUEST['flag']=="2")
			$where_condition1.=" order by `Username` desc";
				
		}else{
			$where_condition1.=" order by `ID` desc";
		}
	$SelQuery	= "select * from  `tbl_users` where  ID!='' ".$where_condition .$where_condition1 ;
			
		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);
		$objSmarty->assign("pageno",$_REQUEST['page']);
		$listing_split = new MsplitPageResults($SelQuery, $this->Limit);
		
		if ( ($listing_split->number_of_rows > 0) )
		{
			$pagenos=round($listing_split->number_of_rows/$this->Limit)."<br/>";
			$rem=($listing_split->number_of_rows%$this->Limit);
			if($rem>0 && $rem <5 ){
				$pagenos=$pagenos+1;
			}
			if($_REQUEST['page']!="")
			{
				if($_REQUEST['page']-$pagenos>0)
				{
					$pagenos=$_REQUEST['page']-1;
					$i= ($this->Limit * $pagenos )-$this->Limit +1;
					$objSmarty->assign("pageno",$pagenos);
					$objSmarty->assign("i",$i);
				}
				if($this->Limit==$listing_split->number_of_rows)
				{
					$objSmarty->assign("i",1);
				}
			}
			$objSmarty->assign("LinkPage",$listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_RESULT));
			$objSmarty->assign("PerPageNavigation",TEXT_RESULT_PAGE1 . ' ' . $listing_split->display_links($this->Limit, get_all_get_params(array('page', 'info', 'x', 'y'))));
		}

		if ($listing_split->number_of_rows > 0)
		{
			$rows = 0;
			$Res_Tickets	= $this->ExecuteQuery($listing_split->sql_query, "select");
		}
		if(!empty($Res_Tickets)&& is_array($Res_Tickets))
		$objSmarty->assign("CatList",$Res_Tickets);

	}
function add_country()
{
	 global $objSmarty,$objPage;
	 $InsQuery	= "INSERT INTO `tbl_country`
											    (
											      `Countryname`,
											      `Status`
											      
											    )
											     VALUES 
											    (
											       '".addslashes($_REQUEST['cname'])."',
											       '1'
											       )";
			$ExeInsQuery=$this->ExecuteQuery($InsQuery,"insert");
			$objSmarty->assign("SuccessMessage","Country has been added successfully");
}
function update_country()
{
	 global $objSmarty,$objPage;
	 $UpQuery	= "Update `tbl_Country` set
	                                        (
											    `Countryname`='".addslashes($_REQUEST['cname'])."',
											  )";
			$ExeInsQuery=$this->ExecuteQuery($InsQuery,"insert");
			$objSmarty->assign("SuccessMessage","Country has been Updated successfully");
}
function getCountById(){
		global $objSmarty;
		if($_REQUEST['Ident']!=''){
			$selQuery="select * from tbl_country where ID='".$_REQUEST['Ident']."'";
			$res=$this->ExecuteQuery($selQuery, "select");
			$objSmarty->assign("Count",$res);
		}else{
			redirect('manage_country.php');
		}
	}
function getCountryById($CountryID)
{
		global $objSmarty;
		echo $SelQry	= "select * from `tbl_country` where ID='".$CountryID."'";
		$res= $this->ExecuteQuery($SelQry,"select");
		return $res[0][Countryname];
		//$objSmarty->assign("Country",$res);
}
function getStateById($State)
{
		global $objSmarty;
		echo $SelQuery	= "select * from `tbl_state` where ID='".$State."'";
		$res= $this->ExecuteQuery($SelQuery,"select");
		return $res[0][Statename];
		//$objSmarty->assign("State",$res);
}
function getCityById($City)
{
		global $objSmarty;
		echo $SelQuery1	= "select * from `tbl_city` where ID='".$City."'";
		$res= $this->ExecuteQuery($SelQuery1,"select");
		return $res[0][Cityname];
		//$objSmarty->assign("City",$res);
}			
function selectCountByID()
{
		global $objSmarty;
		if($_REQUEST['Ident']!=''){
			$selQuery="select * from tbl_country where ID='".$_REQUEST['Ident']."'";
			$result=$this->ExecuteQuery($selQuery,"select");
			$objSmarty->assign("country",$result);
		}
		else{
			redirect('manage_country.php');
		}
}
function selectCountByID12()
{
		global $objSmarty;
		if($_REQUEST['Ident']!=''){
			$selQuery="select * from tbl_country where ID='".$_SESSION['id']."'";
			$result=$this->ExecuteQuery($selQuery,"select");
			$objSmarty->assign("country",$result);
		}
		else{
			redirect('profile.php');
		}
}
function add_users()
	{
	  global $objSmarty,$objPage;
	  if(isset($_FILES['img'])){
      $errors= array();
      $file_name = time().$_FILES['img']['name'];
      $file_size = $_FILES['img']['size'];
      $file_tmp = $_FILES['img']['tmp_name'];
      $file_type = $_FILES['img']['type'];
     // $file_ext=strtolower(end(explode('.',$_FILES['img']['name'])));
      $expensions= array("jpeg","jpg","png");
      if(in_array($file_ext,$expensions)=== false){
        // $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"../uploads/".$file_name);
         //echo "Success";
      }else{
         print_r($errors);
      }
   }
   $interests=$_REQUEST['interests'];
   $intr=implode(',',$interests);
   		$date=explode('/',$_REQUEST['datepicker']);
   		$date=$date[2]."-".$date[0]."-".$date[1];
			$InsQuery	= "INSERT INTO `tbl_users`
											    (
											      `Firstname`,
											      `Lastname`,											      
											      `Username`,
											      `Password`,
											      `Userimage`,
											      `Intrest`,
											      `Gender`,
											      `City`,
											      `Country`,											      
											      `State`,
											      `BirthDate`,
											      `Status`,
											      `CreatedDate`,
											      `UpdatedDate`
											    )
											     VALUES 
											    (
											       '".addslashes($_REQUEST['fname'])."',
											       '".addslashes($_REQUEST['lname'])."',
											       '".addslashes($_REQUEST['uname'])."',
											       '".addslashes($_REQUEST['pwd'])."',
											       '".addslashes($file_name)."',
											       '".addslashes($intr)."',
											       '".addslashes($_REQUEST['gender'])."',
											       '".addslashes($_REQUEST['city'])."',
											       '".addslashes($_REQUEST['country'])."',
											       '".addslashes($_REQUEST['state'])."',
											       '".$date."',
											       '1',
											       now(),											       										       
											       now())";
			$ExeInsQuery=$this->ExecuteQuery($InsQuery,"insert");
			$objSmarty->assign("SuccessMessage","User has been added successfully");
	}
function getCountrynameById($CountryID)
{
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
function getcityid(){
		global $objSmarty;
		$selQuery="select * from tbl_city where Status='1' order by Cityname asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("city",$res);
	}
function getstateid1($CountryID){
		global $objSmarty;
		$selQuery="select * from tbl_state where Status='1' order by Statename asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("state",$res);
	}	
function getcityid1($StateID){
		global $objSmarty;
		$selQuery="select * from tbl_city where Status='1' order by Cityname asc";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("city",$res);
	}	
function update_user()
	{
	global $objSmarty,$objPage;
	if($_FILES['img']['name']!=''){
      $errors= array();
      $file_name = time().$_FILES['img']['name'];
      $file_size = $_FILES['img']['size'];
      $file_tmp = $_FILES['img']['tmp_name'];
      $file_type = $_FILES['img']['type'];
     // $file_ext=strtolower(end(explode('.',$_FILES['img']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
        // $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"../uploads/".$file_name);
      }else{
         print_r($errors);
      }
      $updateQry = "update tbl_users set `Userimage`='".addslashes($file_name)."' where ID='".$_REQUEST['Ident']."'";
      mysql_query($updateQry);
   }
      $interests=$_REQUEST['interests'];
      $intr=implode(',',$interests);
	   $date=explode('/',$_REQUEST['datepicker']);
	   $date=$date[2]."-".$date[0]."-".$date[1];     
 $UPQuery	= "Update `tbl_users` set
						`Firstname`='".addslashes($_REQUEST['fname'])."',
						`Lastname`='".addslashes($_REQUEST['lname'])."',
						`Username`='".addslashes($_REQUEST['uname'])."',
						`Gender`='".addslashes($_REQUEST['gender'])."',
						`Intrest`='".addslashes($intr)."',
						`Country`='".addslashes($_REQUEST['country'])."',
						`City`='".addslashes($_REQUEST['city'])."',
						`State`='".addslashes($_REQUEST['state'])."',
						`BirthDate`='".$date."'
				   where ID='".$_REQUEST['Ident']."'"; 
			$ExeInsQuery=$this->ExecuteQuery($UPQuery,"update");
			$objSmarty->assign("SuccessMessage","User has been updated successfully");
	}
function getUserById(){
		global $objSmarty;
		if($_REQUEST['Ident']!=''){
			$selQuery="select * from tbl_users where ID='".$_REQUEST['Ident']."'";
			$res=$this->ExecuteQuery($selQuery, "select");
			$objSmarty->assign("Category",$res);
		}else{
			redirect('manage_user.php');
		}
	}
function Delete_Category_Record($tablename,$id,$word)
	{
		global $objSmarty,$objPage;
		$UpQuery="DELETE FROM $tablename"
			. " WHERE $id = '".$_REQUEST['hdIdent']."'";
		$ExeUpQuery= $this->ExecuteQuery($UpQuery,"delete");
		$objSmarty->assign("SuccessMessage","$word has been deleted successfully");
	}		
function Set_Status($tablename,$id,$word)
	{
		global $objSmarty,$objPage;
		$UpQuery="UPDATE ".$tablename." SET `Status`='".$_REQUEST['setStatus']."'"
		. " WHERE $id='".$_REQUEST['Ident']."'";
			
		if($_REQUEST['setStatus']==0){
			$ExeUpQuery= $this->ExecuteQuery($UpQuery,"update");
			$objSmarty->assign("SuccessMessage","$word has been deactivated successfully");
		}
		else{
			$ExeUpQuery= $this->ExecuteQuery($UpQuery,"update");
			$objSmarty->assign("SuccessMessage","$word has been activated successfully");
		}
	}
}

?>