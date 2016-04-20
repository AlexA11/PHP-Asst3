<?php

function WriteHeaders($Heading="Welcome",$TitleBar="MySite")
{
	echo"
	<!doctype html> 
<html lang = \"en\">
<head>
    <meta charset = \"UTF-8\">
    <title>$TitleBar</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"Asst3Style.css\">
</head>
<body>";
};

function DisplayLabel($Text)
{
    echo "<label class=\"DataPair\">$Text</label>";
}

function DisplayTextbox($Name, $Size, $Value)
{
    echo "<input required class=\"DataPair\" type=\"text\" name=\"$Name\"  size=\"$Size\" value=\"$Value\"> ";
}

function DisplayContactInfo()
{
    echo"<footer class=\"bottom\" > <p>Questions?  Comments?</p> <a href=\"mailto:aash29@student.sl.on.ca\">aash29@student.sl.on.ca</a></footer>";
}

function DisplayImage($FileName, $Alt, $Height="200", $Width="300")
{
    echo"<img class=\"image\" src=\"$FileName\" alt=\"$Alt\" height=\"$Height\" width=\"$Width\" >";
}

function DisplayButton($Name, $Text, $Value="", $FileName="", $Alt="")
{
    echo"<button name=\"$Name\" value=\"$Value\"  >$Text<img src=\"$FileName\" alt=\"$Alt\"></button> &nbsp";
}

function WriteFooters()
{
	echo"</body></html>";
    DisplayContactInfo();
}
?>