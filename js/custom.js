function setColorCookie(cls_name){
	var rgb = document.querySelector('.'+cls_name).style['background-color'];
	var color = '#' + rgb.substr(4, rgb.indexOf(')') - 4).split(',').map((color) => parseInt(color).toString(16)).join('');
	setCookie('ThemeColor', color, 1);
}

function getColorCookie(){
	return getCookie('ThemeColor');
}

function defineColors(){
	var thmColor = getCookie('ThemeColor');
	if(thmColor != '', thmColor != undefined){
		document.write('<style>.primary-color {background-color: ' + thmColor + ' !important;}</style>');
	}
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}