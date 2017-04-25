<?php
class Content extends MysqlFns
{
	function Content()
	{
		global $config;
		$this->MysqlFns();
		$this->Offset			= 0;
		$this->Limit			= 10;
		$this->Keyword			= '';
		$this->Operator			= '';
		$this->PerPage			= '';
	}

	/*=========================Get all Users===============*/
	function getallusers()
	{
		global $objSmarty,$objPage;
		$sql="select * from tbl_user where ID='".$_SESSION['id']."'";
		$res= $this->ExecuteQuery($sql, "select");
		$objSmarty->assign("Users", $res);
	}
	/*========================*/
	function GetContentLists()
	{
		global $objSmarty,$objPage;
		$where_condition="";
		if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!='')
		$where_condition.=" where `title` like '%".addslashes(trim($_REQUEST['keyword']))."%'";
		if($_REQUEST['flag']!=""){
			if($_REQUEST['flag']=="1")
			$where_condition.=" order by title asc";
			if($_REQUEST['flag']=="2")
			$where_condition.=" order by title desc";
		}else{
			$where_condition.=" order by `id` desc";
		}
		$SelQuery	= "select * from `tbl_staticpages`"
		." $where_condition";
		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);
		$listing_split = new MsplitPageResults($SelQuery, $this->Limit);
		if ( ($listing_split->number_of_rows > 0) )
		{
			$pagenos=round($listing_split->number_of_rows/$this->Limit);
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
		$objSmarty->assign("CatsList",$Res_Tickets);
	}

	function EditContent()
	{
		global $objSmarty;
		$CatIdent=$_REQUEST['CatIdent'];
		$objSmarty->assign("title", $_REQUEST["title"]);
		if($this->ChkDuplicate(trim(addslashes($_REQUEST['title'])),$CatIdent)){

			if(!$_REQUEST["title"]){
				$objSmarty->assign("ErrorMessage", "Title should not be blank");
			}elseif(!trim(strip_tags(str_replace("&nbsp;",' ',$_REQUEST["content"])))){
				$objSmarty->assign("ErrorMessage", "Content should not be blank");
			}
			else if($_REQUEST["title"] && $_REQUEST["content"]){
				$UpQuery = "UPDATE `tbl_staticpages` SET `title` = '".trim(addslashes($_REQUEST['title']))."', `content` = '".trim(addslashes($_REQUEST['content']))."' WHERE `id` =".$_REQUEST['CatIdent'];

				$this->ExecuteQuery($UpQuery, "update");
				$objSmarty->assign("SuccessMessage", "Content has been updated successfully");
				return true;
			}
		}else{
			$objSmarty->assign("title", $_REQUEST["title"]);
			$objSmarty->assign("content",$_REQUEST["content"]);
			$objSmarty->assign("ErrorMessage", "Title already exists");
			$objSmarty->assign("err", "exist");
			PrePopulate($_REQUEST, "CatDetail");
		}
	}
	function GetContentById()
	{
		global $objSmarty;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		." WHERE `id` = ".$_REQUEST['CatIdent']." LIMIT 0,1";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");

		$CatDetail[0]['title'] = stripslashes($CatDetail[0]['title']);
		$CatDetail[0]['content'] = stripslashes($CatDetail[0]['content']);
		$CatDetail[0]['meta_title'] = stripslashes($CatDetail[0]['meta_title']);
		$CatDetail[0]['meta_keywords'] = stripslashes($CatDetail[0]['meta_keywords']);
		$CatDetail[0]['meta_description'] = stripslashes($CatDetail[0]['meta_description']);
		$objSmarty->assign("title", $CatDetail[0]['title']);
		$objSmarty->assign("meta_title", $CatDetail[0]['meta_title']);
		$objSmarty->assign("meta_keywords", $CatDetail[0]['meta_keywords']);
		$objSmarty->assign("meta_description", $CatDetail[0]['meta_description']);
		$sBasePath = "../includes/FCKeditor/";
		$oFCKeditor 			= new FCKeditor('content') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Width		= 600 ;
		$oFCKeditor->Height		= 450 ;
		$oFCKeditor->Value		= $CatDetail[0]['content'];
		//$Editor 				= $oFCKeditor->Create() ;
		$objSmarty->assign("Editor", $oFCKeditor);
		$objSmarty->assign("image", $CatDetail[0]['con_image']);
		return $CatDetail[0]['content'];
	}
	function ChkDuplicate($Title, $Ident='')
	{
		global $objSmarty;
		if(!empty($Ident))
		$WhereClause	= " AND `id` != ".$Ident;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		. " WHERE `title` = '".$Title."' ".$WhereClause
		. " LIMIT 0,1";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");
		if(!empty($CatDetail) && is_array($CatDetail))
		return false;
		else
		return true;
	}
	function GetContent($title)
	{
		global $objSmarty;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		." WHERE `title` = '".$title."'";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");

		$objSmarty->assign("title", $CatDetail[0]['title']);
		$objSmarty->assign("content", $CatDetail[0]['content']);
		$objSmarty->assign("StaticContent",$CatDetail);
	}
	function GetAboutUsContent()
	{
		global $objSmarty;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		." WHERE `title` = 'About Us'";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");
		//$content = $CatDetail[0]['content'];

		$contents = explode('.', $CatDetail[0]['content']);
		$aboutusContent = $contents[0];

		$objSmarty->assign("title", $CatDetail[0]['title']);
		$objSmarty->assign("aboutusContent", $aboutusContent);
		$objSmarty->assign("AboutUs",$CatDetail);
	}
	function GetServicesContent()
	{
		global $objSmarty;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		." WHERE `title` = 'Services'";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");

		$contents = explode('.', $CatDetail[0]['content']);
		$servicesContent = $contents[0];

		$objSmarty->assign("title", $CatDetail[0]['title']);
		$objSmarty->assign("servicesContent", $servicesContent);
		$objSmarty->assign("Services", $CatDetail);
	}
	function GetContactUsContent()
	{
		global $objSmarty;
		$SelQuery		= "SELECT * FROM `tbl_staticpages`"
		." WHERE `title` = 'Contact Us'";
		$CatDetail		= $this->ExecuteQuery($SelQuery, "select");
		$objSmarty->assign("title", $CatDetail[0]['title']);
		$objSmarty->assign("content", $CatDetail[0]['content']);
		$objSmarty->assign("ContactUs",$CatDetail);
	}
	function get_content($pagename)
	{
		global $objSmarty,$objPage;
		$SelQuery	= "SELECT * FROM `tbl_staticpages` WHERE `pagename`='$pagename'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$objSmarty->assign("StaticContent",$ExeSelQuery);
	}
}
?>