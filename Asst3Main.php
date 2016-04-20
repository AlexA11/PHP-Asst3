<?php
//Alex Ash and Brett Akey

include_once("Asst3Include.php");
include_once("clsDatabaseFunctions.php"); 

//Setup a form
function SetUpForm( $Character )
{
    WriteHeaders();
    echo "
    <div class = \"top\">
	   Music - Alex Ash and Brett Akey
	</div>
    <div class = \"bigpiece\">
	  <div class = \"leftpiece\"> 
	    
         <p>" ;
         
         if(strpbrk($Character, "H"))
				{
					echo"<form action=? method=post>";
					DisplayButton("nextPage", "Home" , "WelcomePage");
					 echo"</form>";
				}
                
         if(strpbrk($Character, "F"))
				{
					echo"<form action=? method=post>";
					DisplayButton("nextPage", "Find Record" , "FoundRecord");
					 echo"</form>";
				}         
		
	      echo"<form action=? method=post>";
		if(strpbrk($Character, "S"))
			{
				echo"<input type=submit name=\"nextPage\" class=\"submit\" value=\"Save\"> ";
			}
        if(strpbrk($Character, "C"))
			{
				echo"<form action=? method=post>";
					DisplayButton("nextPage", "Save Changes" , "ChangesMade");
					 echo"</form>";
			}
			
		elseif(	!strpbrk($Character, "S") && !strpbrk($Character, "H"))
		{
		 DisplayButton("nextPage", "Create Table", "CreateTable");
   	     DisplayButton("nextPage", "Add Record", "EnterData");
         DisplayButton("nextPage", "Modify Record", "ModifyRecord");
         DisplayButton("nextPage", "Display Data", "DisplayData");
		}
			
		echo" </p>
	  </div>
	  <div class = \"middlepiece\" >	    
	 ";
    
	
}

function FinishForm()
{
    echo"
        </form>
        </div>
	  <div class = \"rightpiece\">
	  	 
	     <p>";
		 DisplayImage("music.png", "music" );
	echo"	 </p>
	  </div>
	</div>";
    WriteFooters();
}

function DisplayMainForm()
{
    SetupForm("");
    //display a welcome message
    DisplayLabel("Welcome!");
    FinishForm();
}

function DataEntryForm()
{
	SetUpForm("SH");
	
	echo"<div class=\"leftinput\" >";
	
	DisplayLabel("Band Name: ");
	DisplayTextBox("bandName", "20", "");
	echo"<br/>";
	echo"<br/>";
	
	DisplayLabel("Number of CD's Sold: ");
	DisplayTextBox("numCD", "20", "");
	echo"<br/>";
	echo"<br/>";
	
	DisplayLabel("CD Selling Price: ");
	DisplayTextBox("cdPrice", "20", "");
	echo"<br/>";
	echo"<br/>";
	
	DisplayLabel("Manager Fee: ");
	echo"<br /><input required type=\"radio\" value=\"45\" name=\"managerFee\" >45% <br />";
	echo"<input  type=\"radio\" value=\"55\" name=\"managerFee\" >55% <br />";
	echo"<br/>";
	
	DisplayLabel("Recording Studio");
	echo"
	<select required name=\"recordingStudio\">
		<option value=\"NA\">N\A</option>
		<option value=\"RRRS\">Rock Rules Recording Studio</option>
		<option value=\"STMS\">Sing To Me Studios</option>
		<option value=\"MSNS\">Make Some Noise Studios</option>
	</select>
	<br />";
	echo"<br/>";
	
	DisplayLabel("Advance");
	echo"<input type=\"checkbox\" name=\"advance\" value=\"advance\" />";
	echo"<br/>";
	echo"<br/>";
	
	echo"</div>";
	
	DisplayLabel("Distributer Fees: ");
	DisplayTextBox("distFee", "10", "");
	echo"<br/>";
	echo"<br/>";
	
	DisplayLabel("Manufacturing Costs: ");
	DisplayTextBox("manuFac", "10", "");
	echo"<br/>";
	echo"<br/>";
	
	DisplayLabel("Gig Date (YYYY/MM/DD): ");
	DisplayTextBox("gigDate", "10", "");
	echo"<br/>";
	echo"<br/>";
	
	FinishForm();
}
function ResultsForm()
{
	$dbObj = new dbFunctions();
	SetUpForm("H");
	
	$BandName = $_POST["bandName"];
	$NumCd = $_POST["numCD"];
	$CdPrice = $_POST["cdPrice"];
	$ManagerFee = $_POST["managerFee"];
	$RecordingStudio = $_POST["recordingStudio"];
	$Advance = $_POST["advance"];
	$DistFee = $_POST["distFee"];
	$ManuFac = $_POST["manuFac"];
	$GigDate = $_POST["gigDate"];
	
	$totalRev = $NumCd * $CdPrice;
	
	$totalManageFee=0;
	$advanceValue=0;
	
	if($RecordingStudio == "RRRS")
	{
		$totalManageFee = 0.05 * $totalRev;
		$recordingPercent = 5;
	}
	if($RecordingStudio == "STMS")
	{
		$totalManageFee = 0.10 * $totalRev;
		$recordingPercent = 10;
	}
	if($RecordingStudio == "MSNS")
	{
		$totalManageFee = 0.15 * $totalRev;
		$recordingPercent = 15;
	}
	if($Advance == "advance")
	{
		$advanceValue = 1000;
	}
	if($ManagerFee == "45")
	{
		$ManagerFee = $totalRev * 1.45;
		$ManagerFeeDec = 45;
	}
	if($ManagerFee == "55")
	{
		$ManagerFee = $totalRev * 0.55;
		$ManagerFeeDec = 55;
	}
	
	
	 
	 $totalExpenses = $ManagerFee + $totalManageFee + $advanceValue + $DistFee + $ManuFac;
	 $netIncome = $totalRev - $totalExpenses;
	 $netIncome = number_format($netIncome, 2, '.', ',');
	 $totalRev = number_format($totalRev, 2, '.', ',');
	 $totalManageFee = number_format($totalManageFee, 2, '.', '');
	$totalExpenses = number_format($totalExpenses, 2, '.', ',');
	
	echo"<div class=\"dataFormat\" >";
	echo"<strong>Breakdown of Revenue</strong>
	Number of CDs Sold: $NumCd
	CD Purchase Price: $CdPrice
	     Total Revenue: $$totalRev
		 
	
	<strong>Breakdown of Expenses</strong>
	Management Fees: $ManagerFee
	Recording Cost: $totalManageFee
	Advance: $advanceValue
	Distributer Fees: $DistFee
	Manufacturing Costs: $ManuFac
	     Total Expenses: $$totalExpenses
	
	
	$BandName's Net Income is $$netIncome. Next gig is $GigDate
	";
	
	$Values = array($BandName, $NumCd, $CdPrice, $ManagerFeeDec,  $recordingPercent, $advanceValue, $DistFee, $ManuFac, $GigDate);
	$DataTypes = array("varchar", "integer", "decimal", "decimal", "decimal", "decimal", "decimal", "decimal", "date");
	$Insert = $dbObj->InsertIntoTable("Band", $Values, $DataTypes);
	if ($Insert) 
	{
		echo "Insert was successful. "; 
	}
	else 
	{
		echo "Insert failed. ";
		
	}
	
	echo"</div>";
	
	FinishForm();
}

function CreateTableForm()
{
	$dbObj = new dbFunctions();
    SetUpForm("H");
	
	$FieldNames = array("BandName", "CDsSold", "Price", "ManagerPercent", "RecordingPercent", "AdvanceAmt", "DistributerFee", "ManufacturingFee", "GigDate");
	$DataTypes = array("varchar", "integer", "decimal", "decimal", "decimal", "decimal", "decimal", "decimal", "date");
	$Sizes = array(30, 0, 8, 8, 8, 8, 8, 8, 0);
	$Decimals = array(0, 0, 2, 2, 2, 2, 2, 2, 0);
	$Create = $dbObj->CreateTable("Band", $FieldNames, $DataTypes, $Sizes, $Decimals);
	if($Create)
	{
		echo"Table has been created successfully";
	}
	else{
		echo"Table was not created successfully";
	}
    
    FinishForm();
}

function DisplayData()
{
	$dbObj = new dbFunctions();
    SetUpForm("H");
	
    
	$result = $dbObj->RunSelect("Band", "", "", "BandName", "");
	
		
        echo "<table style='border:1px solid black'>";
        echo "<th>Band</th><th>CDs Sold</th><th>Price</th><th>Manager %</th>
		<th>Recording %</th><th>Advance Amt</th><th>Distributer</th><th>Manufacturing</th><th>Gig Date</th>";
        while($row = mysqli_fetch_assoc($result))
        {
            echo"<tr>";
            foreach($row as $col)
            {
                echo "<td style='border:1px solid black'>";				
                echo $col;
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
	
	
    FinishForm();
}

function ModifyRecord()
{
    SetUpForm("HF");
    echo"You can search records here";
    FinishForm();
}

function ShowFoundRecord()
{
    SetUpForm("HC");
    echo"Show Found Record page";
    FinishForm();
}

function WriteFoundRecordData()
{
    SetUpForm("H");
    echo"Record has been saved to the database";
    FinishForm();
}
//main
if (!isset($_POST["nextPage"])) 
 DisplayMainForm();
elseif (!strcmp($_POST["nextPage"], "EnterData")) 
	  DataEntryForm();
  elseif(!strcmp($_POST["nextPage"], "Save")) 
	  ResultsForm();
	  elseif(!strcmp($_POST["nextPage"], "WelcomePage"))
        DisplayMainForm();
        elseif(!strcmp($_POST["nextPage"], "CreateTable"))
          CreateTableForm();
           elseif(!strcmp($_POST["nextPage"], "ModifyRecord"))
            ModifyRecord();
            elseif(!strcmp($_POST["nextPage"], "DisplayData"))
                DisplayData();
                elseif(!strcmp($_POST["nextPage"], "FoundRecord"))
                    ShowFoundRecord();
                     elseif(!strcmp($_POST["nextPage"], "ChangesMade"))
                    WriteFoundRecordData();
  
?>