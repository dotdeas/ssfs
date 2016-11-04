function submitDosearch(e) {
	if(window.event)
		var keyCode=window.event.keyCode;
	else
		var keyCode=e.which;
	if(keyCode==13) {
		dosearch();
	}
}

function dosearch() {
	var searchfor=$('input[name=searchfor]').val();
	var searchfrom=$('input[name=searchfrom]').val();
	var searchto=$('input[name=searchto]').val();
		if($('#searchfordiv').hasClass('has-error')) {
			$('#searchfordiv').removeClass('has-error');
		}
		if(searchfor=='') {
			$('#searchfordiv').addClass('has-error');
			$('input[name=searchfor]').focus();
		} else {
			jQuery.ajax({
				type: 'post',
				url: 'functions.php',
				data: 'action=1&for='+searchfor+'&from='+searchfrom+'&to='+searchto,
				cache: false,
				success: function(response) {
					if(response=='') {
						$('#results').html('Error 500/Internal server error');
						$('input[name=searchfor]').focus();
					} else {
						$('#results').html(response);
					}
				}
			});
		}
}

function showstats() {
	jQuery.ajax({
		type: 'post',
		url: 'functions.php',
		data: 'action=2',
		cache: false,
		success: function(response) {
			if(response=='') {
				$('#results').html('Error 500/Internal server error');
			} else {
				$('#results').html(response);
			}
		}
	});
}