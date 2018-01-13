//模拟ts U函数

function U(url, params) {
	var website = _ROOT_ + '/index.php';
	url = url.split('/');
	if (!url[1])
		url[1] = 'Index';
	if (!url[2])
		url[2] = 'index';
	website = website + '?m=' + url[1] + '&a=' + url[2];
	if (params) {
		params = params.join('&');
		website = website + '&' + params;
	}

	return website;
}

function Submit(formname) {

	var formid = document.getElementById(formname);
	var isform = Validator.Validate(formid, 3);

	if (!isform) {
		return false;
	} else {
		
		formid.submit();
		return true;
		

	}
}
