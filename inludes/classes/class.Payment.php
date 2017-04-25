<?php
/*	Class Function for Admin	*/

class ManagePayment extends MysqlFns
{
	function ManagePayment()
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
	function manage_payment()
	{
		global $objSmarty,$objPage;

		$where_condition="";

		if($_REQUEST['keyword']!="")
		$where_condition.="";

		$SelQuery	= "select * from payment ";

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
	function selectOrderById()
	{
		global $objSmarty;		
	$sql = "select *,DATE_FORMAT(paymentMadeDate,'%b %d,%Y') as paymentMadeDate from payment where ID = '".$_REQUEST['CatIdent']."'";
		$result = $this->ExecuteQuery($sql,"select");
		$objSmarty->assign("Order",$result);		
	}

function update_payment()
	{
		global $objSmarty;
			$UpQuery="UPDATE tbl_payment SET `deliveryStatus`='".$_REQUEST['deliverystatus']."'"
					 . " WHERE ID  ='".$_REQUEST['CatIdent']."'";
			$ExeSelQuery= $this->ExecuteQuery($UpQuery,"update");
		$objSmarty->assign("SuccessMessage","Payment status has been updated successfully");	
	}
	function getStudentname($id)
	{
		global $objSmarty;
		$sql = "select FirstName,LastName,Email from  tbl_student where StudId='$id' ";
		$result = $this->ExecuteQuery($sql,"select");
		$objSmarty->assign("student",$result);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function mypayments()
	{
		global $objSmarty,$objPage;
		
	$SelQuery="select * from payment where CustomerId='".$_SESSION['UserId']."' order by paymentMadeDate asc";

		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split = new MsplitPageResults($SelQuery, $this->Limit);
		if ( ($listing_split->number_of_rows > 0) )
		{
			$objSmarty->assign("LinkPage",$listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_RESULT));
			$objSmarty->assign("PerPageNavigation",TEXT_RESULT_PAGE1 . ' ' . $listing_split->display_links($this->Limit, get_all_get_params(array('page', 'info', 'x', 'y'))));
		}

		if ($listing_split->number_of_rows > 0)
		{
			$rows = 0;
			$Res_Tickets	= $this->ExecuteQuery($listing_split->sql_query, "select");
		}

		if(!empty($Res_Tickets)&& is_array($Res_Tickets))
		$objSmarty->assign("mypayment",$Res_Tickets);
		
		
	}
	
	
	


	////////////////////////////////////////////////////////------------------end-------------------------///////////////////////////////////////////////
}
?>