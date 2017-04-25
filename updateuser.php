<?php
include "includes/common.php";
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
         move_uploaded_file($file_tmp,"uploads/".$file_name);
      }else{
         print_r($errors);
      }
     $updateQry = "update tbl_user set `UserImage`='".addslashes($file_name)."' where ID='".$_REQUEST['Ident']."'";
      mysql_query($updateQry);
   }
echo $UPQuery	= "Update `tbl_user` set
						`Name`='".addslashes($_REQUEST['name'])."',
						`Age`='".addslashes($_REQUEST['age'])."',
						`Designation`='".addslashes($_REQUEST['designation'])."',
						`Email`='".addslashes($_REQUEST['email'])."',
						`Address`='".addslashes($_REQUEST['address'])."',
						`Prof_status`='".addslashes($_REQUEST['Prof_status'])."',
						`UserImage`='".addslashes($file_name)."',
						`Background`='".addslashes($_REQUEST['bgcolor'])."'
				   where ID='".$_SESSION['id']."'"; 
		$ExeInsQuery=$access->ExecuteQuery($UPQuery,"update");
echo 'User has been updated successfully.';

?>