<?php
require("config.php");

if(stripslashes($_GET["a"])=="v") {
$file=$config["filespath"]."/".stripslashes($_GET["y"])."/".stripslashes($_GET["m"])."/".stripslashes($_GET["f"]).".pdf";
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename='".stripslashes($_GET["f"]).".pdf'");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($file));
	header("Accept-Ranges: bytes");
readfile($file);
}

if(stripslashes($_GET["a"])=="d") {
$file=$config["filespath"]."/".stripslashes($_GET["y"])."/".stripslashes($_GET["m"])."/".stripslashes($_GET["f"]).".pdf";
	header("Content-type: application/pdf");
	header("Content-Disposition: attachment; filename='".stripslashes($_GET["f"]).".pdf'");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($file));
	header("Accept-Ranges: bytes");
readfile($file);
}