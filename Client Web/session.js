$.ajaxSetup({async: false});
$.ajax({
	type: "GET",
	url: "http://perso.imerir.com/cpy/Seen/session.php?action=c",
	success:function(data){
				if (data != "0"){
					pseudo=data;
				}else{
					document.location.href="connexion.html";
				}
	}
});
$.ajaxSetup({async: true});