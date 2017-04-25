<?php
/*	Class Function for Admin	*/
//include_once $config['SiteClassPath']."thumbnail.class.php";
//include_once $config['SiteClassPath']."class.Resize.php";
include_once $config['SiteClassPath']."class.split_page_results.php";
class Product extends MysqlFns
{
	function Product()
	{
		global $config;
		$this->MysqlFns();
		$this->Offset			= 0;
		$this->Limit			= 12;
		$this->page				= 0;
		$this->Keyword			= '';
		$this->Operator			= '';
		$this->PerPage			= '';
	}
	function manage_product()
	{
		global $objSmarty,$objPage;

		$where_condition="";
		$this->Limit			= 30;
		if($_REQUEST['keyword']!="")
		$where_condition.=" and `product_name` like '%".addslashes(trim($_REQUEST['keyword']))."%'";

		$SelQuery	= "select * from `product` where bespoke=0 $where_condition order by `ID` desc";

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
		$objSmarty->assign("CatList",$Res_Tickets);
	}

	function select_product()
	{
		global $objSmarty;

	 $SelQuery	= "SELECT * FROM `product`"
		." WHERE `ID`='".$_REQUEST['Ident']."'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$norows= $this->ExecuteQuery($SelQuery,"norows");
		$objSmarty->assign("Cat",$ExeSelQuery);
		
		$objSmarty->assign("norows",$norows);

		$sqlQry="select DISTINCT dim1_color from tbl_dimensions where productId='".$_REQUEST['Ident']."'";
		$resColor=$this->ExecuteQuery($sqlQry, "select");
		$resClrCnt=$this->ExecuteQuery($sqlQry, "norows");
		$objSmarty->assign("Color",$resColor);

	}
	
	function BrandDetails()
	{
	global $objSmarty,$objPage;

		$where_condition="";
		
		if($_REQUEST['keyword']!="")
		$where_condition.=" and `brandName` like '%".addslashes(trim($_REQUEST['keyword']))."%'";

		$SelQuery	= "select * from brands where brandId !='' GROUP BY brandName order by brandId asc";
        if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!='')
		$_REQUEST['page']="";
		$SelQuery	= "select * from `brands`"
		."$where_condition";

		
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
		$objSmarty->assign("CatList",$Res_Tickets);
	}
function select_carriage()
	{
		global $objSmarty;

	 $SelQuery	= "SELECT * FROM `tbl_carriage`"
		." WHERE `Id`='".$_REQUEST['Ident']."'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$norows= $this->ExecuteQuery($SelQuery,"norows");
		$objSmarty->assign("Car",$ExeSelQuery);
		
		$objSmarty->assign("norows",$norows);
		
		 $countryex=$ExeSelQuery[0]['country_excluded'];
		    $value=explode(",",$countryex);
		  
		    $objSmarty->assign("countryex",$value);

		

	}
function update_carriage()
	{
		global $objSmarty,$objPage;
		//$SelQuery	= "SELECT * from `tbl_carriage`
					//	WHERE 
					//	 Carriage_cost !='".$_REQUEST['car_cost']."' and  Id = '".$_REQUEST['Ident']."'";

		//$ExeSelQuery= $this->ExecuteQuery($SelQuery,"norows");
		//if($ExeSelQuery)
		//{
			$UPQuery	= "Update `tbl_carriage` set
						`To`='".addslashes($_REQUEST['to_price'])."',
						`Carriage_cost`='".addslashes($_REQUEST['car_cost'])."',
						`country_excluded`='".$_REQUEST['optionval']."'
						 where Id=".$_REQUEST['Ident'];
			$ExeInsQuery=$this->ExecuteQuery($UPQuery,"update");
			$objSmarty->assign("SuccessMessage","Carriage has been updated successfully");
		//}
		//else
		//{
			//$objSmarty->assign("ErrorMessage","carriage details already exists");
		//}
	}

	function update_product()
	{
		global $objSmarty;
		$SelQuery	= "SELECT * from `product`"
		." WHERE `product_name`='".mysql_real_escape_string(htmlspecialchars(stripslashes($_REQUEST['product_name'])))."' and  ID = '".$_REQUEST['Ident']."'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$img=$ExeSelQuery[0]['product_image'];
		$SelQuery	= "SELECT * from `product`"
		." WHERE
					  `product_name`='".mysql_real_escape_string(htmlspecialchars(stripslashes($_REQUEST['product_name'])))."' and ID != '".$_REQUEST['Ident']."'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"norows");
		if(isset($_REQUEST['color'])){
			$color = implode(',',$_REQUEST['color']);
		}
		if(isset($_REQUEST['size'])){
			$size = implode(',',$_REQUEST['size']);
		}

		if(!$ExeSelQuery){
			if($_REQUEST['ProductType'] == "XML")
			{
				if($_FILES['txtPicture']['name']!='')
				{
					if ($_FILES["txtPicture"]["size"] == 0) {
						$objSmarty->assign("ErrorMessage","Only .jpg images below 2 MB can be uploaded");
					} else {
							
						if($_FILES['txtPicture']['name'] != "")
						{
							$filename =time().$_FILES['txtPicture']['name'];
							$add="../product/$filename";
							@move_uploaded_file($_FILES['txtPicture']['tmp_name'], $add);
							$resizeObj = new resize("../product/".$filename);
							$resizeObj -> resizeImage(320,320, 'exact');
							$resizeObj -> saveImage("../product/thumbnail/".$filename, 100);
							$resizeObj -> resizeImage(820,820, 'exact');
							$resizeObj -> saveImage("../product/large/".$filename, 100);
							$UpQuery	= "UPDATE `product` SET
							  `product_image`='$filename',
							   `update_date`=now()
							    WHERE `ID`='".$_REQUEST['Ident']."'";
							$ExeInsQuery=$this->ExecuteQuery($UpQuery,"update");
							/*`total_products`='".addslashes($_REQUEST['total_products'])."',
							 `avail_products`='".addslashes($_REQUEST['avail_products'])."',

							 */
						}
						$objSmarty->assign("SuccessMessage","Product has been updated successfully");
					}
				}
			}
			else
			{

				//printArray($_REQUEST);
				//exit;
				if($_FILES['txtPicture']['name']!='')
				{
					if ($_FILES["txtPicture"]["size"] == 0) {
						$objSmarty->assign("ErrorMessage","Only .jpg images below 2 MB can be uploaded");
					} else {
						$filename =time().$_FILES['txtPicture']['name'];
						$add="../product/$filename";
						@move_uploaded_file($_FILES['txtPicture']['tmp_name'], $add);
						$resizeObj = new resize("../product/".$filename);
						$resizeObj -> resizeImage(320,320, 'exact');
						$resizeObj -> saveImage("../product/thumbnail/".$filename, 100);
						$resizeObj -> resizeImage(820,820, 'exact');
						$resizeObj -> saveImage("../product/large/".$filename, 100);

						$upQry="update product set
								`product_image`='$filename'
								 WHERE `ID`='".$_REQUEST['Ident']."'";
						$this->ExecuteQuery($upQry, "update");
					}
				}
				$UpQuery	= "UPDATE `product` SET
						 `catid`='".addslashes($_REQUEST['procat'])."',
						 `sub_catid`='".addslashes($_REQUEST['prosubcat'])."',
						 `brand_id`='".addslashes($_REQUEST['probrnd'])."',
						 `spl_subgroup`='".addslashes($_REQUEST['specialgroup'])."',
						 `product_name`='".addslashes($_REQUEST['product_name'])."',
						 `product_price`='".addslashes($_REQUEST['product_price'])."',
						 `product_desc`='".addslashes($_REQUEST['product_desc'])."',
						 `TechInfo`='".addslashes($_REQUEST['tech_desc'])."',
						 `DeliveryInfo`='".addslashes($_REQUEST['delivery_desc'])."',
						 `ReturnInfo`='".addslashes($_REQUEST['return_desc'])."',
						 `weight`='".addslashes($_REQUEST['weight'])."',
						 `waterproof`='".addslashes($_REQUEST['waterproof'])."',
						 `bespoke`='".addslashes($_REQUEST['bespoke'])."',
						 `canEmbroidery`='".addslashes($_REQUEST['canEmbroidery'])."',
						 `canHeat`='".addslashes($_REQUEST['canHeat'])."',
						 `canName`='".addslashes($_REQUEST['canName'])."',
						 `canPrint`='".addslashes($_REQUEST['canPrint'])."',
						 `prod_status`='".addslashes($_REQUEST['prod_status'])."',
						 `update_date`=now()
						  WHERE `ID`='".$_REQUEST['Ident']."'";
				$ExeInsQuery=$this->ExecuteQuery($UpQuery,"update");


				$delQry ="delete from tbl_dimensions where productId='".$_REQUEST['Ident']."'";
				$this->ExecuteQuery($delQry, "delete");

				$colorCnt=count($_REQUEST['color']);
				$id=$_REQUEST['Ident'];
				for($i=0; $i<$colorCnt; $i++)
				{
					$k=$i+1;
					$sizeCnt=count($_REQUEST['size_'.$k]);
					for($j=0; $j<$sizeCnt; $j++){
						$color=$_REQUEST['color'][$i];

						$size=$_REQUEST['size_'.$k][$j];

						$inQry="insert into tbl_dimensions(`dim1_color`,`dim2_size`,`productId`)
										values(
										'".addslashes($color)."',
										'".addslashes($size)."',
										'$id'
										)";
						$this->ExecuteQuery($inQry, "insert");



					}
				}
				$objSmarty->assign("SuccessMessage","Product has been updated successfully");

			}
		}
		else{
			$objSmarty->assign("ErrorMessage","Product name already exists");
		}
	}


	function add_product()
	{
		global $objSmarty;
		//printArray($_POST);
		$colorCnt=count($_REQUEST['color']);

		//exit;

		$SelQuery	= "SELECT * from `product`"
		." WHERE `product_name`='".mysql_real_escape_string(htmlspecialchars(stripslashes($_REQUEST['product_name'])))."' and catid = '".$_REQUEST['procat']."'";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"norows");
		if(!$ExeSelQuery){

			if ($_FILES["txtPicture"]["size"] == 0) {
				$objSmarty->assign("ErrorMessage","Only .jpg images below 2 MB can be uploaded");
			} else {
				$filename =time().addslashes($_FILES['txtPicture']['name']);
				$add="../product/$filename";
				move_uploaded_file($_FILES['txtPicture']['tmp_name'], $add);
				$resizeObj = new resize("../product/".$filename);
				$resizeObj -> resizeImage(320,320, 'exact');
				$resizeObj -> saveImage("../product/thumbnail/".$filename, 100);
				$resizeObj -> resizeImage(820,820, 'exact');
				$resizeObj -> saveImage("../product/large/".$filename, 100);
				$InsQuery	= "INSERT INTO `product`
														(
														`catid`,
														`sub_catid`,
														`brand_id`,
														`product_name`,
														`product_price`,
														`product_desc`,
														`TechInfo`,
														`DeliveryInfo`,
														`ReturnInfo`,
														`weight`,
														`waterproof`,
														`bespoke`,
														`canEmbroidery`,
														`canHeat`,
														`canName`,
														`canPrint`,
														`spl_subgroup`,
														`prod_status`,
														`product_image`,
														`update_date`,
														`Status`
														) 
														VALUES 
														(
														
														'".addslashes($_REQUEST['procat'])."',
														'".addslashes($_REQUEST['prosubcat'])."',
														'".addslashes($_REQUEST['probrnd'])."',
														'".addslashes($_REQUEST['product_name'])."',
														'".addslashes($_REQUEST['product_price'])."',
														'".addslashes($_REQUEST['product_desc'])."',
														'".addslashes($_REQUEST['tech_desc'])."',
														'".addslashes($_REQUEST['delivery_desc'])."',
														'".addslashes($_REQUEST['return_desc'])."',
														'".addslashes($_REQUEST['weight'])."',
														'".addslashes($_REQUEST['waterproof'])."',
														'".addslashes($_REQUEST['bespoke'])."',
														'".addslashes($_REQUEST['canEmbroidery'])."',
														'".addslashes($_REQUEST['canHeat'])."',
														'".addslashes($_REQUEST['canName'])."',
														'".addslashes($_REQUEST['canPrint'])."',
														'".addslashes($_REQUEST['specialgroup'])."',
														'".addslashes($_REQUEST['prod_status'])."',
														'$filename',
														now(),
														'1'
														)"; 

				$ExeInsQuery=$this->ExecuteQuery($InsQuery,"insert");
				$id=mysql_insert_id();

				for($i=0; $i<$colorCnt; $i++)
				{
					$k=$i+1;
					$sizeCnt=count($_REQUEST['size_'.$k]);
					for($j=0; $j<$sizeCnt; $j++){
						$color=$_REQUEST['color'][$i];

						$size=$_REQUEST['size_'.$k][$j];

						$inQry="insert into tbl_dimensions(`dim1_color`,`dim2_size`,`productId`)
									values(
									'".addslashes($color)."',
									'".addslashes($size)."',
									'$id'
									)";
						$this->ExecuteQuery($inQry, "insert");



					}
				}

				$objSmarty->assign("SuccessMessage","Product has been added successfully");
			}
		}else{

			$objSmarty->assign("product",$_REQUEST);
			$objSmarty->assign("ErrorMessage","Product name already exists");
		}
	}
	function getproduct() {
		global $objSmarty;
		$SelQuery	= "SELECT * from `product`"
		." WHERE `Status`='1' GROUP BY product_name";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$objSmarty->assign("CatList",$ExeSelQuery);

	}
	function getproductName() {
		global $objSmarty;
		$SelQuery	= "SELECT * from `product_coupons`"
		." WHERE `coupon_id`='".$_REQUEST['Ident']."' ";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");

		$SelQuery	= "SELECT * from `product`"
		." WHERE `ID`='".$ExeSelQuery[0]['ID']."' ";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$objSmarty->assign("CatList",$ExeSelQuery);

	}

	function select_category()
	{
		global $objSmarty;

		$SelQuery	= "SELECT * from `tbl_catagory`"
		." WHERE `Status`='1' or `Catagory_Id`=(select `catid` from `product`"
		." WHERE `ID`='".$_REQUEST['Ident']."') GROUP BY Catagory_Name";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		return $ExeSelQuery;
	}

	function select_sub_category()
	{
		global $objSmarty;

		/*$SelQuery	= "SELECT * from `tbl_sub_catagory`
		 WHERE category_id='$id' and `status`='1' or
		 `subcategory_id`=(select `sub_catid` from `product` WHERE `ID`='".$_REQUEST['Ident']."')
		 GROUP BY subcategory_name";*/
		$SelQuery	= "SELECT * from `tbl_sub_catagory`
						WHERE `status`='1' 
						GROUP BY subcategory_name";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		//$objSmarty->assign("SubCategory",$ExeSelQuery);
		return $ExeSelQuery;
	}

	function select_brand()
	{
		global $objSmarty;

		/*$SelQuery	= "SELECT * from `tbl_brands`"
		 ." WHERE `Status`='1' or `Id`=(select `brand_id` from `product`"
		 ." WHERE `ID`='".$_REQUEST['Ident']."') GROUP BY brand_name";*/

		$SelQuery	= "SELECT * from `tbl_brands`"
		." WHERE `Status`='1' GROUP BY brand_name";

		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		//$objSmarty->assign("brand",$ExeSelQuery);
		return $ExeSelQuery;
	}
	
	function get_brand($catid)
	{
		global $objSmarty;

		$SelQuery	= "SELECT * from `tbl_brands`"
		." WHERE `Status`='1' or `Id`=(select `brand_id` from `product`"
		." WHERE `ID`='".$_REQUEST['Ident']."') GROUP BY brand_name";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$objSmarty->assign("brand", $ExeSelQuery);
	}

	function ProductsColor()
	{
		global $objSmarty;

		$SelQuery	= "SELECT * from `tbl_dimensions`"
		." GROUP BY dim1_color";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		//$objSmarty->assign("ProductColor", $ExeSelQuery);
		return $ExeSelQuery;
	}

	function ProductsSize()
	{
		global $objSmarty;

		$SelQuery	= "SELECT * from `tbl_dimensions`"
		." GROUP BY dim2_size";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		//$objSmarty->assign("ProductColor", $ExeSelQuery);
		return $ExeSelQuery;
	}

	function getProductList()
	{
		global $objSmarty,$objPage;
		$this->Limit			= 12;
		$where_condition="";
		if($_REQUEST['catId']!='' && isset($_REQUEST['catId'])){
			$where_condition.=" and p.catid='".$_REQUEST['catId']."'";
		}
		if($_REQUEST['proName']!='' && isset($_REQUEST['proName'])){
			$where_condition.=" and `product_name` like '%".addslashes(trim($_REQUEST['proName']))."%'";
		}
		if($_REQUEST['priceFrom']!='' && isset($_REQUEST['priceFrom'])){
			$where_condition.=" and product_price >='".$_REQUEST['priceFrom']."'";
		}
		if($_REQUEST['priceTo']!='' && isset($_REQUEST['priceTo'])){
			$where_condition.=" and product_price <='".$_REQUEST['priceTo']."'";
		}

		$SelQuery	= "select * from product p join tbl_catagory c on p.catid=c.Catagory_Id where p.Status='1' $where_condition order by ID desc";

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

		if(!empty($Res_Tickets)&& is_array($Res_Tickets)){
			$objSmarty->assign("ProductList",$Res_Tickets);

		}

	}

	function getProductlist_1()
	{
		global $objSmarty,$objPage;
		$this->Limit			= 12;
		$where_condition="";
		/*if($_REQUEST['catId']!='' && isset($_REQUEST['catId'])){
			$where_condition.=" and p.catid='".$_REQUEST['catId']."'";
			}
			if($_REQUEST['proName']!='' && isset($_REQUEST['proName'])){
			$where_condition.=" and `product_name` like '%".addslashes(trim($_REQUEST['proName']))."%'";
			}
			if($_REQUEST['priceFrom']!='' && isset($_REQUEST['priceFrom'])){
			$where_condition.=" and product_price >='".$_REQUEST['priceFrom']."'";
			}
			if($_REQUEST['priceTo']!='' && isset($_REQUEST['priceTo'])){
			$where_condition.=" and product_price <='".$_REQUEST['priceTo']."'";
			}*/

		$SelQuery	= "select * from products where status='enabled' ";

		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split1 = new MsplitPageResults($SelQuery, $this->Limit);
		if ( ($listing_split1->number_of_rows > 0) )
		{
			$objSmarty->assign("LinkPage",$listing_split1->display_count(TEXT_DISPLAY_NUMBER_OF_RESULT));
			$objSmarty->assign("PerPageNavigation",TEXT_RESULT_PAGE1 . ' ' . $listing_split1->display_links($this->Limit, get_all_get_params(array('page', 'info', 'x', 'y'))));
		}

		if ($listing_split1->number_of_rows > 0)
		{
			$rows = 0;
			$Res_Tickets	= $this->ExecuteQuery($listing_split1->sql_query, "select");
		}

		if(!empty($Res_Tickets)&& is_array($Res_Tickets)){
			$objSmarty->assign("ProductDetail",$Res_Tickets);

		}

	}
	function getProductDetailById($id)
	{
		global $objSmarty;

		$SelQuery	= "SELECT * FROM `product` "
		." WHERE `ID`='".$id."' and Status='1' limit 1";
		$ExeSelQuery= $this->ExecuteQuery($SelQuery,"select");
		$count=$this->ExecuteQuery($SelQuery,"norows");
		if($count>'0'){
			$objSmarty->assign("ProductDetail",$ExeSelQuery);
		}
		

			}
	

	function Delete_Product_Record($tablename,$id,$word)
	{
		global $objSmarty;

		$UpQuery="DELETE FROM $tablename"
		. " WHERE $id = '".$_REQUEST['hdIdent']."'";
		$ExeUpQuery= $this->ExecuteQuery($UpQuery,"delete");
			
			
		$objSmarty->assign("SuccessMessage","$word has been deleted successfully");

			
	}
	function getProductDetail()
	{

		global $objSmarty,$objPage;
		$color=$_REQUEST['color'];
		$size=$_REQUEST['size'];
		$whereCondition="";

		if($_REQUEST['subcat_id']!='' && isset($_REQUEST['subcat_id'])){
			$subId=$_REQUEST['subcat_id'];
			$whereCondition= "and  FIND_IN_SET($subId,`sub_catid`)";
		}
		
						
	}			
			
	function getProductbycolor($id,$color)
	{
		global $objSmarty;
		$sel="select * from `product` where `catid`='".$id."' and `Status`='1'";
		$exe=$this->ExecuteQuery($sel,"select");
		$cnt=$this->ExecuteQuery($sel,"norows");
		$i=0;
		$flag=1;
		$c=0;
		$fetcc=array();
		while($i<$cnt)
		{
			$prodcolor=explode(',',$exe[$i]['product_color']);
			if(in_array($color,$prodcolor))
			{
				$prodcolour=implode(',',$prodcolor);
				//print_r ($prodcolour);
				$selqry="select * from `product` where `catid`='".$id."' and product_color='".$prodcolour."'";
				$exeqry=$this->ExecuteQuery($selqry,"select");
				$count=$this->ExecuteQuery($selqry,"norows");
				if($count>0)
				{
					$c=$c+1;
					$fetcc[]=$exeqry;
					$flag=0;
				}
			}
			$i++;
		}
		if($flag==1)
		{
			$objSmarty->assign("err","No Products found");
		}
		else{
			$objSmarty->assign("ProductDetail",$fetcc);
			$objSmarty->assign("count",$c);
		}
	}


	function getBrandDetail($id)
	{
		global $objSmarty;
		$selqry="select * from `tbl_brands` where  Status='1'";
		$ExeSelQuery= $this->ExecuteQuery($selqry,"select");
		$cnt=$this->ExecuteQuery($selqry,"norows");


		$objSmarty->assign("BrandDetail",$ExeSelQuery);
	}

	function getProductbybrand($id,$brand)
	{
		global $objSmarty;
		$fetcc=array();
		 $sel="select * from `product` where `catid`='".$id."' and `brand_id`='".$brand."' and `Status`='1'";
		$exe=$this->ExecuteQuery($sel,"select");
		//print_r($exe);
		$cnt=$this->ExecuteQuery($sel,"norows");
		$objSmarty->assign("count",$cnt);
		if($cnt>0)
		{
			$objSmarty->assign("ProductDetail",$exe);
		}
		else
		{
			//$objSmarty->assign("err","No Productss found");
		}
	}

	function getProductbysize($id,$size)
	{
		global $objSmarty;
		$fetcc=array();
		$sel="select * from `product` where `catid`='".$id."' and `Status`='1'";
		$exe=$this->ExecuteQuery($sel,"select");
		$cnt=$this->ExecuteQuery($sel,"norows");
		$i=0;
		$flag=1;
		$c=0;
		while($i<$cnt)
		{
			$prodsize=explode(',',$exe[$i]['product_size']);
			if(in_array($size,$prodsize))
			{
				$prod_size=implode(',',$prodsize);
				print_r ($prod_size);
				$selqry="select * from `product` where `catid`='".$id."' and product_size='".$prod_size."'";
				$exeqry=$this->ExecuteQuery($selqry,"select");
				$count=$this->ExecuteQuery($selqry,"norows");
				echo $count;
				if($count>0)
				{
					$c=$c+1;
					$fetcc[]=$exeqry;
					$flag=0;
				}
			}
			$i++;
		}
		if($flag==1)
		{
			$objSmarty->assign("err","No Products found");
		}
		else{

			$objSmarty->assign("count",$c);
			$objSmarty->assign("ProductDetail",$fetcc);
		}
	}

	function getAlternativeproduct($id)
	{
		global $objSmarty;
		$selQry ="select catid,sub_catid from product where ID='$id'";
		$res=$this->ExecuteQuery($selQry, "select");
		$catid=$res[0]['catid'];
		$subcatid=$res[0]['sub_catid'];
		$sel="select * from product where catid='".$catid."' and sub_catid='$subcatid' and Status='1' and ID!='".$id."' order by rand() limit 5";
		$exe=$this->ExecuteQuery($sel,"select");
		$objSmarty->assign("AlternativeProducts",$exe);
	}


	function getProductbyprice($id,$price)
	{
		global $objSmarty;
		$fetcc=array();
		$sel="select * from `product` where `catid`='".$id."' and `product_price`<'".$price."' and `Status`='1'";
		$exe=$this->ExecuteQuery($sel,"select");
		//print_r($exe);
		$cnt=$this->ExecuteQuery($sel,"norows");
		$objSmarty->assign("count",$cnt);
		if($cnt>0)
		{
			$objSmarty->assign("ProductDetail",$exe);
		}
		else
		{
			$objSmarty->assign("err","No Products found");
		}
	}
	/*----------------------------- By KM ---------------------------------------- */
	function updateViewed($id){
		global $objSmarty;
		$upQuery= "update product set Viewed=Viewed+1 where ID='$id'";
		$this->ExecuteQuery($upQuery, "update");
	}

	function getMostViewed($id){
		global $objSmarty;
		$SqlQry="select * from product where ID!='$id'order by Viewed desc, rand() limit 5";
		$res= $this->ExecuteQuery($SqlQry, "select");
		$objSmarty->assign("mostViewed",$res);

	}

	function getSearchResult(){
		global $objSmarty,$objPage;

		$where_condition="";
		$color=$_REQUEST['color'];
		$size=$_REQUEST['size'];
		if($_REQUEST['prod']!="")
		$where_condition.=" and ( `product_name` like '%".addslashes(trim($_REQUEST['prod']))."%' or `product_code` like '%".addslashes(trim($_REQUEST['prod']))."%')";
		if($color!='')
		{
			$where_condition.=" and FIND_IN_SET(d.`dim1_color`,'$color') ";
		}
		if($size!='')
		{
			$where_condition.=" and FIND_IN_SET(d.`dim2_size`,'$size') ";
		}
		if($_REQUEST['pLimit']=='All'){

			$this->Limit=9;
			$where_condition="";

				

			 $SelQuery	= "select * from `product` as p
			 				left join tbl_dimensions as d on d.productId=p.ID
			 				where product_price>0 and bespoke=0 
							and Status='1' $where_condition 
			 				group by ID
			 				order by `ID` desc";


			$Res_Tickets=$this->ExecuteQuery($SelQuery, "select");

			$objSmarty->assign("ProductDetail",$Res_Tickets);
			$count=$this->ExecuteQuery($SelQuery,"norows");
			$objSmarty->assign("count",$count);

		}
		else{
			if($_REQUEST['pLimit']!='')
			{
				$this->Limit=$_REQUEST['pLimit'];
			}else{
				$this->Limit			= 9;
			}
				
			 $SelQuery	= "select * from `product` as p
			 				left join tbl_dimensions as d on d.productId=p.ID
			 				where product_price>0 and bespoke=0 
			 				and Status='1' $where_condition 
			 				group by ID
			 				order by `ID` desc";
				
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
			{
				$objSmarty->assign("ProductDetail",$Res_Tickets);
				$count=$this->ExecuteQuery($SelQuery, "norows");
				$objSmarty->assign("count",$count);
			}
				
		}
	}

	function getSpecialProduct(){
		global $objSmarty,$objPage;

		$where_condition="";

		$SelQuery	= "select * from `product` where product_price>0 and spl_subgroup='1'
					  and Status='1' and bespoke=0 $where_condition order by `ID` desc";


		$Res_Tickets=$this->ExecuteQuery($SelQuery, "select");
		$objSmarty->assign("ProductDetail",$Res_Tickets);
		$count=$this->ExecuteQuery($SelQuery,"norows");
		$objSmarty->assign("count",$count);
	}

	function getClearanceProduct(){
		global $objSmarty,$objPage;

		$where_condition="";

		$SelQuery	= "select * from `product` where product_price>0 
						and prod_status='Clearance' and bespoke=0 
						and Status='1' $where_condition order by `ID` desc";


		$Res_Tickets=$this->ExecuteQuery($SelQuery, "select");
		$objSmarty->assign("ProductDetail",$Res_Tickets);
		$count=$this->ExecuteQuery($SelQuery,"norows");
		$objSmarty->assign("count",$count);
	}

	function getColors(){
		global $objSmarty;
		$whereCondition='';
		if($_REQUEST['cat_id']!='' && isset($_REQUEST['cat_id'])){
			$whereCondition.=" and catid='".$_REQUEST['cat_id']."'";
		}
		if(isset($_REQUEST['subcat_id']) && $_REQUEST['subcat_id']!=''){
			$subID=$_REQUEST['subcat_id'];
			$whereCondition.=" and $subID IN (`sub_catid`)";
		}

		$selQuery="select DISTINCT dim1_color from tbl_dimensions as d
					join product as p on p.ID=d.productId
					where d.productId!='' and product_price>0 and bespoke=0 $whereCondition 
					order by dim1_color";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("Colors",$res);
		$resCnt=$this->ExecuteQuery($selQuery, "norows");
		$objSmarty->assign("ColorsCnt",$resCnt);
	}

	function getSpecialOfferColors($val){
		global $objSmarty;
		$whereCondition='';
			
		if($val=='1'){
			$whereCondition=" and p.spl_subgroup='1'";
		}elseif($val=='2'){
			$whereCondition=" and p.prod_status='Clearance'";
		}

		$selQuery="select DISTINCT dim1_color from tbl_dimensions as d
					join product as p on p.ID=d.productId 
					where d.productId!='' and product_price>0 and bespoke=0 $whereCondition 
					order by dim1_color";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("Colors",$res);
		$resCnt=$this->ExecuteQuery($selQuery, "norows");
		$objSmarty->assign("ColorsCnt",$resCnt);

	}
	function getSizes(){
		global $objSmarty;
		$whereCondition='';
		if($_REQUEST['cat_id']!='' && isset($_REQUEST['cat_id'])){
			$whereCondition.=" and catid='".$_REQUEST['cat_id']."'";
		}
		if(isset($_REQUEST['subcat_id']) && $_REQUEST['subcat_id']!=''){
			$subID=$_REQUEST['subcat_id'];
			$whereCondition.=" and $subID IN (`sub_catid`)";
		}

		$selQuery="select DISTINCT dim2_size from tbl_dimensions as d
					join product as p on p.ID=d.productId 
					where d.productId!='' and product_price>0 and bespoke=0 $whereCondition 
					order by dim2_size asc limit 50";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("Sizes",$res);
		$resCnt=$this->ExecuteQuery($selQuery, "norows");
		$objSmarty->assign("SizesCnt",$resCnt);
	}

	function getSpecialOfferSizes($val){
		global $objSmarty;
		$whereCondition='';
		if($val=='1'){
			$whereCondition=" and p.spl_subgroup='1'";
		}elseif($val=='2'){
			$whereCondition=" and p.prod_status='Clearance'";
		}

		$selQuery="select DISTINCT dim2_size from tbl_dimensions as d
					join product as p on p.ID=d.productId 
					where d.productId!='' and product_price>0 and bespoke=0 $whereCondition 
					order by dim2_size asc limit 50";
		$res=$this->ExecuteQuery($selQuery, "select");
		$objSmarty->assign("Sizes",$res);
		$resCnt=$this->ExecuteQuery($selQuery, "norows");
		$objSmarty->assign("SizesCnt",$resCnt);
	}



	function getRelSizes($color,$proId){
		global $objSmarty;
		$sqlQry="select * from tbl_dimensions where dim1_color='$color' and productId ='$proId'";
		$res=$this->ExecuteQuery($sqlQry, "select");
		$objSmarty->assign("Size",$res);
	}
	
	function getProList($catId){
		global $objSmarty;
		 $SelQuery	= "SELECT * FROM `product`"
		              ." WHERE catid = '$catId' and bespoke=0 order by product_name asc";
		 $res=$this->ExecuteQuery($SelQuery, "select");
		 $objSmarty->assign("proList",$res);
		 
	}
	function getProName($id){
		global $objSmarty;
		 $SelQuery	= "SELECT * FROM `product`"
		              ." WHERE ID = '$id' and bespoke=0 order by product_name asc";
		 $res=$this->ExecuteQuery($SelQuery, "select");
		 $objSmarty->assign("product",$res);
	}
	
	function getColorSize($id){
		global $objSmarty;
		$selQry="select DISTINCT dim1_color from tbl_dimensions where productId='$id' order by dim1_color asc";
		$colorRes =$this->ExecuteQuery($selQry, "select");
		$objSmarty->assign("colorRes",$colorRes);

		$sqlQry ="select DISTINCT dim2_size from tbl_dimensions where productId='$id' order by dim_id asc";
		$sizeRes= $this->ExecuteQuery($sqlQry, "select");
		$objSmarty->assign("sizeRes",$sizeRes);
	}
	/*----------------------------- By KM ---------------------------------------- */
    function manage_carriage()
    {
    	global $objSmarty;
    	$where_condition="";
		$this->Limit			= 30;
		if($_REQUEST['keyword']!="")
		$where_condition.=" where `country_excluded` like '%".addslashes(trim($_REQUEST['keyword']))."%'";
		$selQry="select * from tbl_carriage $where_condition";
		$carriage =$this->ExecuteQuery($selQry, "select");
		$objSmarty->assign("carriage",$carriage);
		if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split = new MsplitPageResults($selQry, $this->Limit);
		if ( ($listing_split->number_of_rows > 0) )
		{
			$objSmarty->assign("LinkPage",$listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_RESULT));
			$objSmarty->assign("PerPageNavigation",TEXT_RESULT_PAGE1 . ' ' . $listing_split->display_links($this->Limit, get_all_get_params(array('page', 'info', 'x', 'y'))));
		}
		
    	
    }
    
    function add_carriage()
    {
    	global $objSmarty;
    	$insquery="insert into tbl_carriage (`To`,`Carriage_cost`,`country_excluded`,`created_date`)values('".$_REQUEST['to_price']."','".$_REQUEST['car_cost']."','".$_REQUEST['optionval']."',now())";
        $exequery=$this->ExecuteQuery($insquery,"insert");
        $objSmarty->assign("SuccessMessage","Carriage has been added successfully");
        
    }
/**
 * 
 * This function is to get the most viewed products
 * By TK on 07/13/2015
 */  
function getMostviewedProducts(){
	global $objSmarty;
	$selQry="select * from product where Mostview='1' order by rand() limit 3";
	$resultSet =$this->ExecuteQuery($selQry, "select");
	$num_rows=$this->ExecuteQuery($selQry,"norows");
	if($num_rows > 0){
		$objSmarty->assign("mostViewedProducts",$resultSet);
	}else{
		$selectProducts="select * from product order by rand() limit 3";
		$resultProducts =$this->ExecuteQuery($selectProducts, "select");
		$objSmarty->assign("mostViewedProducts",$resultProducts);
	}
}
/**
 * 
 * This function is to get the featured products
 * By TK on 07/13/2015
 */ 
function getFeaturedProducts(){
	global $objSmarty;
	$selQry="select * from product where feature='1' order by rand() limit 8";
	$resultSet =$this->ExecuteQuery($selQry, "select");
	$num_rows=$this->ExecuteQuery($selQry,"norows");
	if($num_rows > 0){
		$objSmarty->assign("featuredProducts",$resultSet);
	}else{
		$selectProducts="select * from product order by rand() limit 8";
		$resultProducts =$this->ExecuteQuery($selectProducts, "select");
		$objSmarty->assign("featuredProducts",$resultProducts);
	}
}
/**
 * 
 * This function is to get all the featured products and most viewed products
 * By TK on 07/14/2015
 */
function getAllProducts($type){
	global $objSmarty;
	$this->Limit			= 12;
	$objSmarty->assign("type",$type);
	if($type=='featured'){
		$whereCondition="AND feature='1'";
	}else if($type=='mostviewed'){
		$whereCondition="AND Mostview='1'";
	}else{
		$whereCondition='';
	}
	$selQry="select * from product where ID!='' $whereCondition order by rand()";
	if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split = new MsplitPageResults($selQry, $this->Limit);
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
		$objSmarty->assign("product",$Res_Tickets);
	$resultSet =$this->ExecuteQuery($selQry, "select");
	$num_rows = $this->ExecuteQuery($selQry,"norows");
	if($num_rows > 0){
		$objSmarty->assign("products",$resultSet);
		$objSmarty->assign("resultCnt",$num_rows);
		$objSmarty->assign("searchWhere",$whereCondition);
	}else{
		$selectProducts="select * from product order by rand() limit 12";
		$resultProducts=$this->ExecuteQuery($selectProducts,"select");
		$num_rows=$this->ExecuteQuery($selectProducts,"norows");
		$objSmarty->assign("resultCnt",$num_rows);
		$objSmarty->assign("products",$resultProducts);
		$whereCondition="";
		$objSmarty->assign("searchWhere",$whereCondition);
	}
}



function getProductsbySorting($sortBy,$type){
	global $objSmarty;
	$this->Limit			= 12;
	$objSmarty->assign("type",$type);
	$objSmarty->assign("sortBy",$sortBy);
	if($type=='featured'){
		if($sortBy=='hightolow'){
			$whereCondition="AND feature='1' order by SalePrice desc";
		}else if($sortBy=='lowtohigh'){
			$whereCondition="AND feature='1' order by SalePrice asc";
		}else if($sortBy=='mostviewed'){
			$whereCondition="AND feature='1' AND Mostview='1'";
		}else{
			$whereCondition="AND feature='1'";
		}
	}else if($type=='mostviewed'){
		if($sortBy=='hightolow'){
			$whereCondition="AND Mostview='1' order by SalePrice desc";
		}else if($sortBy=='lowtohigh'){
			$whereCondition="AND Mostview='1' order by SalePrice asc";
		}else if($sortBy=='featured'){
			$whereCondition="AND Mostview='1' AND feature='1'";
		}else{
			$whereCondition="AND Mostview='1'";
		}
	}else{
		if($sortBy=='hightolow'){
			$whereCondition="order by SalePrice desc";
		}else if($sortBy=='lowtohigh'){
			$whereCondition="order by SalePrice asc";
		}else{
			$whereCondition="";
		}
	}
$selQry="select * from product where ID!='' $whereCondition ";
if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split = new MsplitPageResults($selQry, $this->Limit);
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
		$objSmarty->assign("product",$Res_Tickets);
	$resultSet =$this->ExecuteQuery($selQry, "select");
	$num_rows = $this->ExecuteQuery($selQry,"norows");
	if($num_rows > 0){
		$objSmarty->assign("products",$resultSet);
		$objSmarty->assign("resultCnt",$num_rows);
		$objSmarty->assign("searchWhere",$whereCondition);
	}else{
		$selectProducts="select * from product order by rand() limit 12";
		$resultProducts=$this->ExecuteQuery($selectProducts,"select");
		$num_rows=$this->ExecuteQuery($selectProducts,"norows");
		$objSmarty->assign("resultCnt",$num_rows);
		$objSmarty->assign("products",$resultProducts);
		$whereCondition='';
		$objSmarty->assign("searchWhere",$whereCondition);
	}
}

function getAllBrands(){
	global $objSmarty;
	$selQuery="select * from `brands` where status = '1'";
	$result=$this->ExecuteQuery($selQuery, "select");
	$objSmarty->assign("brands",$result);
}

function getBrands($id){
	global $objSmarty, $objPage;
	$this->Limit			= 12;
	$selQuery="select * from `product` where Brand = '$id'";
	if(isset($_REQUEST['page']) && $_REQUEST['page'] >1)
		$i= ($this->Limit * $_REQUEST['page'] )-$this->Limit +1;
		else
		$i=1;
		$objSmarty->assign("i",$i);

		$listing_split = new MsplitPageResults($selQuery, $this->Limit);
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
			$objSmarty->assign("product",$Res_Tickets);
	//$result=$this->ExecuteQuery($selQuery, "select");
	//$objSmarty->assign("product",$result);
    $resultCnt=$this->ExecuteQuery($selQuery, "norows");
	$objSmarty->assign("resultCnt",$resultCnt);
	$objSmarty->assign("searchWhere",$whereCondition);
}
function getBrandname($id){
	global $objSmarty;
	$selQuery="select * from `product` where Brand = '$id'";
	$result=$this->ExecuteQuery($selQuery, "select");
	$objSmarty->assign("product",$result);
	$str = $result[0][ProductName];
	$name=explode("-",$str);
	$objSmarty->assign("productname",$name[0]);
	$objSmarty->assign("product1",$name[1]);
	//return $result[0]['Brand'];
}


}
?>