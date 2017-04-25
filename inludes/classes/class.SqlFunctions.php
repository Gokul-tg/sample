<?php 
	/*	Class Function for Mysql Functions	*/

class MysqlFns 
{
	var $ConLink;
	function MysqlFns()
	{
		if(!$this->ConLink)
			$this->makeConnection();
	}
	
		function makeConnection()
	{
		global $config;global $objSmarty;
		$this->ConLink = @mysql_pconnect($config['DBHostName'],$config['DBUserName'],$config['DBPassword']) or die("Database Connection Failed<br>". mysql_error());
		mysql_select_db($config['DBName'], $this->ConLink);
		return true;
	}
	
	function ExecuteQuery($Query, $Qrytype)
	{
		if(!empty($Query) && !empty($Qrytype))
		{
			switch(strtolower($Qrytype))
			{
				case "select":
					$Result = mysql_query($Query) or die("Error in Selection Query <br> ".$Query."<br>". mysql_error());
					if($Result)
					{	
						$ResultSet = array();
						while($ResultSet1 = mysql_fetch_array($Result))
							$ResultSet[] = $ResultSet1;
						return $ResultSet;
						
					}
					else return false;
					break;
				case "update":
					$Result = mysql_query($Query) or die("Error in Updation Query <br> ".$Query."<br>". mysql_error());
					if($Result)
					{
						$AffectedNums = mysql_affected_rows();
						return $AffectedNums;
					}
					else return false;
					break;
				case "norows":
					$Result = mysql_query($Query) or die("Error in No of Rows Query <br> ".$Query."<br>". mysql_error());
					if($Result)
					{
						$Totalrows = mysql_num_rows($Result);
						return $Totalrows;
					}
					else return false;
					break;	
					
				case "insert":
					$Result = mysql_query($Query) or die("Error in Insertion Query <br> ".$Query."<br>". mysql_error());
					if($Result)
					{
						$LastInsertedRow = mysql_insert_id();
						return $LastInsertedRow;
					}
					else return false;
					break;
				case "delete":
					$Result = mysql_query($Query) or die("Error in Deletion Query <br> ".$Query."<br>". mysql_error());
					if($Result)
						return true;
					else
						return false;
			}
		}
		
	}
}
?>
