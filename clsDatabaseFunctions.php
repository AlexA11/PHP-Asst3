<?php
// Alex Ash, Brett Akey
class dbFunctions
{
	private $Connect;
	//echo "Alex Ash and Brett Akey";
	function __construct()
	{
		global $Connect;
		$Host="localhost";
		$UserName = "root";
		$Password = "";
		$Database = "test";
	  	$Connect = mysqli_connect($Host, $UserName, $Password, $Database); 
		if (!$Connect) 
		{
			echo "Connection open failed.";
			return (false);
		}
	// else echo "good connect";
		return(true);
	}
	function __destruct()
	{
		global $Connect;
		mysqli_close($Connect);
	}
	function RunSelect($TableName, $WhereField, $WhereValue, $OrderField, $Sort)
	{ 
		global $Connect;
		
		$query = "SELECT * FROM ".$TableName;
			if($WhereField != "" && $WhereValue != "")
			{
				if(strcmp($WhereField, "string")|| strcmp($WhereField, "date"))
				{
					$WhereValue = "'".$WhereValue."'";
					$query = $query."WHERE ".$WhereValue;
				}
			}
			if($OrderField != "")
			{
				$query = $query." ORDER BY ".$OrderField." ".$Sort;
			}
			
		$result = mysqli_query($Connect, $query);
		return $result;
   		  
	}
	function GetOneRow($ResultSet)
	{
		 $row = mysqli_fetch_assoc($ResultSet);
		 return $row;
	}
	
	
	function InsertIntoTable($TableName, $Values, $DataTypes)
	{ 
		global $Connect;
		$AddRecord = "INSERT INTO $TableName VALUES(";
		$numValues = sizeof($Values);
		
		for($i=0; $i < $numValues; $i++)
		{
			if(strcmp($DataTypes[$i], "varchar") || strcmp($DataTypes[$i], "date"))
			{
				$AddRecord = $AddRecord."'".$Values[$i]."',";
			}
			else
			{
				if (strcmp($DataTypes[$i], "decimal") || strcmp($DataTypes[$i], "integer"))
				{
					if($Values[$i] == null)
					{
						$AddRecord = $AddRecord."0 ,";
					}
					else
					{
						$AddRecord = $AddRecord.$Values[$i]." ,";
					}
				}
			}
		}
		
		$AddRecord = rtrim($AddRecord,",");
		$AddRecord = $AddRecord.")";
		
		
		
		$result = mysqli_query($Connect, $AddRecord);
		
		if($result)
		{
			return true;
		}
		else{
			return false;
		}
	
 	} 
	function CreateTable($TableName, $FieldNames, $DataTypes, $Sizes, $Decimals=0)
 	{  
	 	global $Connect;
		mysqli_query($Connect,"DROP TABLE IF EXISTS ".$TableName);
		
		$numFields = sizeof($FieldNames);
		
		$CreateQuery = "CREATE TABLE ".$TableName." (";
		
		for($i=0; $i < $numFields; $i++)
		{
			$CreateQuery = $CreateQuery.$FieldNames[$i]." ".$DataTypes[$i];
			
			if(strcmp($DataTypes[$i], "varchar" ) == 0 || strcmp($DataTypes[$i], "integer" ) == 0)
			{
				$CreateQuery = $CreateQuery."(".$Sizes[$i].")";
			}
			elseif(strcmp($DataTypes[$i], "decimal" ) == 0)
			{
				$CreateQuery = $CreateQuery."(".$Sizes[$i].", ".$Decimals[$i].")";
			}
		
			$CreateQuery = $CreateQuery.", ";
			
		}
		$CreateQuery = rtrim($CreateQuery, ', ');
		$CreateQuery = $CreateQuery.")";
		
		$result = mysqli_query($Connect, $CreateQuery);
		
		if($result)
		{			
			return true;
		}
		else{
			
			return false;
		}
	}
	
	function UpdateTable($TableName, $UpdateFieldName, $UpdateFieldValue, $DataTypes, $WhereFieldName, $WhereFieldValue)
	{
		global $Connect;
		$query = "UPDATE $TableName SET";
		
		$numFields = sizeof($UpdateFieldName);
		
		for($i=0; $i < $numFields; $i++)
		{
			if(strcmp($DataTypes[$i], "varchar") || strcmp($DataTypes[$i], "date"))
			{
				$query .= $UpdateFieldName[$i]."= '".$UpdateFieldValue[$i]."'";
			}
			else {
				$query .= $UpdateFieldName[$i]."=".$UpdateFieldValue[$i];
			}
			$query .= ", ";
		}
		$query = rtrim($query, ', ');
		if($WhereFieldName != "" && $WhereFieldValue != "")
			{
			if(strcmp($WhereFieldName, "string")|| strcmp($WhereFieldName, "date"))
				{
					$WhereFieldValue = "'".$WhereValue."'";
					$query = $query."WHERE ".$WhereFieldName."=".$WhereFieldValue;
				}
			}
		
		$result = mysqli_query($Connect, $query);
		
		if($result)
		{			
			return true;
		}
		else{
			
			return false;
		}
	}
}
?>