<?php
if(isset($_POST["action"]) && $_POST["action"]=="1") {
	$data=search($_POST["for"],$_POST["from"],$_POST["to"]);
echo $data;
}
if(isset($_POST["action"]) && $_POST["action"]=="2") {
	$data=getstats();
echo $data;
}

function search($for,$from,$to) {
	require("config.php");
	include("locales/".$config["language"].".lang");
		$mysqli=new mysqli($config["mysql_host"],$config["mysql_user"],$config["mysql_pass"],$config["mysql_name"]);
			$for=$mysqli->real_escape_string($for);
			$from=$mysqli->real_escape_string($from);
			$to=$mysqli->real_escape_string($to);
				if($from=="" && $to=="") {
					$sql=$mysqli->query("SELECT fileid,filedate FROM archive WHERE filedata LIKE '%".$for."%' OR fileid LIKE '%".$for."%' ORDER BY filedate DESC");
				} elseif($from<>"" && $to=="") {
					$sql=$mysqli->query("SELECT fileid,filedate FROM archive WHERE (filedata LIKE '%".$for."%' OR fileid LIKE '%".$for."%') AND (filedate BETWEEN '".$from."' AND '".date("Y-m-d")."') ORDER BY filedate DESC");
				} elseif($from=="" && $to<>"") {
					$sql=$mysqli->query("SELECT fileid,filedate FROM archive WHERE (filedata LIKE '%".$for."%' OR fileid LIKE '%".$for."%') AND (filedate BETWEEN '".date("Y-m-d")."' AND '".$to."') ORDER BY filedate DESC");
				} elseif($from<>"" && $to<>"") {
					$sql=$mysqli->query("SELECT fileid,filedate FROM archive WHERE (filedata LIKE '%".$for."%' OR fileid LIKE '%".$for."%') AND (filedate BETWEEN '".$from."' AND '".$to."') ORDER BY filedate DESC");
				}
				$hits=$sql->num_rows;
				$data="<fieldset><legend>".$hits." ".$lang["hits"]."</legend><table class=\"table table-striped table-hover table-condensed\"><thead><tr><th>".$lang["invoice"]."</th><th>".$lang["date"]."</th><th>&nbsp;</th></tr></thead><tbody>";
					if($hits=="0") {
						$data.="<tr><td>".$lang["nohits"]."</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
					} else {
						while($res=$sql->fetch_array()) {
							$data.="<tr><td>".$res["fileid"]."</td><td>".$res["filedate"]."</td><td><span class=\"pull-right\"><a class=\"btn btn-success btn-xs\" target=\"_blank\" href=\"file.php?a=v&y=".date("Y", strtotime($res["filedate"]))."&m=".date("m", strtotime($res["filedate"]))."&f=".$res["fileid"]."\"><i class=\"fa fa-file-pdf-o\"></i>&nbsp; ".$lang["open"]."</a>&nbsp;&nbsp;<a class=\"btn btn-primary btn-xs\" target=\"_blank\" href=\"file.php?a=d&y=".date("Y", strtotime($res["filedate"]))."&m=".date("m", strtotime($res["filedate"]))."&f=".$res["fileid"]."\"><i class=\"fa fa-download\"></i>&nbsp; ".$lang["download"]."</a></span></td></tr>";
						}
					}
			mysqli_free_result($sql);
			$data.="</tbody></table></fieldset>";
			$mysqli->query("UPDATE stats SET numsearch=numsearch+1 WHERE id=1");
		mysqli_close($mysqli);
return($data);
}

function getstats() {
	require("config.php");
	include("locales/".$config["language"].".lang");
		$mysqli=new mysqli($config["mysql_host"],$config["mysql_user"],$config["mysql_pass"],$config["mysql_name"]);
			$sql_numsearch=$mysqli->query("SELECT numsearch FROM stats WHERE id=1");
			$sql_archive=$mysqli->query("SELECT fileid FROM archive");
				$res=$sql_numsearch->fetch_array();
				$archivefiles=$sql_archive->num_rows;
		mysqli_close($mysqli);
return("<legend>".$lang["statistics"]."</legend><table width=\"300\"><tr><td width=\"70%\">".$lang["archivedinvoices"].":</td><td width=\"30%\">".$archivefiles."</td></tr><tr><td>".$lang["numberofsearches"].":</td><td>".$res["numsearch"]."</td></tr></table>");
}
?>