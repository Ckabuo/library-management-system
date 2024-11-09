<?php
$server="localhost";
$username="root";
$password="Ud0chukwu@2001";
$databasename="library_management_db";

$conn = mysqli_connect($server, $username, $password);

$abc=mysqli_select_db($conn,$databasename);

if(!$abc)
{
	die("disconnect");
}
else
{
	//die ("successfull");
}
?>