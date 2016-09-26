<!DOCTYPE html>
<?php
require("config.php");
require("includes/settings.php");
include("locales/".$config["language"].".lang");
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="author" content="Andreas Persson">
		<meta name="copyright" content=".DEAS Solutions">
		<title>SSFS</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/ssfs.css">
		<link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
		<link rel="icon" type="image/png" href="favicon.png">
		<!--[if lt IE 9]>
			<script src="js/html5shiv.min.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container-fluid">
			<div class="col-md-2 sidebar">
				<span>
					<center>
						<h2>SSFS</h2>
					</center>
				</span>
				<div id="searchfordiv" class="form-group">
					<label for="searchfor" class="control-label"><?php echo $lang["searchfor"]; ?></label>
					<input type="text" name="searchfor" id="searchfor" class="form-control" onkeypress="submitDosearch(event);" autofocus>
				</div>
				<div id="searchfromdiv" class="form-group">
					<label for="searchfrom" class="control-label"><?php echo $lang["searchfrom"]; ?></label>
					<div class="input-group date">
						<input type="text" name="searchfrom" id="searchfrom" class="form-control" onkeypress="submitDosearch(event);">
						<div id="selfromdiv" class="input-group-addon" onclick="$('#searchfrom').datepicker('show');"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
				<div id="searchtodiv" class="form-group">
					<label for="searchto" class="control-label"><?php echo $lang["searchto"]; ?></label>
						<div class="input-group date">
							<input type="text" name="searchto" id="searchto" class="form-control" onkeypress="submitDosearch(event);">
							<div id="seltodiv" class="input-group-addon" onclick="$('#searchto').datepicker('show');"><i class="fa fa-calendar"></i></div>
						</div>
				</div>
				<div class="form-group">
					<button type="submit" name="bsearch" id="bsearch" class="btn btn-primary form-control" value="<?php echo $lang["search"]; ?>" onclick="dosearch();"><i class="fa fa-search fa-fw"></i> <?php echo $lang["search"] ?></button>
				</div>
				<div id="loader"></div>
				<div class="footer">
					<small>
						Version 1.0-trunk / <a href="" onclick="showstats();return false;"><?php echo $lang["statistics"]; ?></a><br>
						&copy; .DEAS Solutions
					</small>
				</div>
			</div>
			<div id="results" class="col-md-10 col-md-offset-2 main"></div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="locales/bootstrap-datepicker.sv.min.js"></script>
		<script src="js/spin.min.js"></script>
		<script src="js/ssfs.js"></script>
		<script>
			$('#searchfrom').datepicker({
			    format: "yyyy-mm-dd",
			    weekStart: <?php echo $lang["weekstart"]; ?>,
			    language: "<?php echo $config["language"]; ?>",
				orientation: "bottom left",
				autoclose: true,
			    toggleActive: true,
				todayHighlight: true
			});
			$('#searchto').datepicker({
			    format: "yyyy-mm-dd",
			    weekStart: <?php echo $lang["weekstart"]; ?>,
			    language: "<?php echo $config["language"]; ?>",
			    orientation: "bottom left",
				autoclose: true,
			    toggleActive: true,
				todayHighlight: true
			});
			
			var $loading=$('#loader').hide();
				$(document)
				.ajaxStart(function () {
					$loading.show();
					if($('#searchfordiv').hasClass('has-error')) {
						$('#searchfordiv').removeClass('has-error');
					}
					$('input[name=searchfor]').prop('disabled', true);
					$('input[name=searchfrom]').prop('disabled', true);
					$('input[name=searchto]').prop('disabled', true);
					$('button[name=bsearch]').prop('disabled', true);
				})
				.ajaxStop(function () {
					$loading.hide();
					$('input[name=searchfor]').prop('disabled', false);
					$('input[name=searchfrom]').prop('disabled', false);
					$('input[name=searchto]').prop('disabled', false);
					$('button[name=bsearch]').prop('disabled', false);
					$('input[name=searchfor]').focus();
				});
				
			var opts = {
				lines: 13,
				length: 20,
				width: 5,
				radius: 15,
				corners: 1,
				rotate: 0,
				direction: 1,
				color: '#000',
				speed: 1,
				trail: 60,
				shadow: false,
				hwaccel: false,
				className: 'spinner',
				zIndex: 2e9,
				top: '60%',
				left: '50%'
			};
			var target = $('#loader').get(0);
			var spinner = new Spinner(opts).spin(target);
		</script>
	</body>
</html>