$(document).ready(function(e){
	$("#loginform").on('submit', (function(e) {
		console.log("a");
		var emailorname = $("#username").val().trim();
		var pass = $("#userpassword").val().trim();
		if(emailorname == "" || pass == ""){
			e.preventDefault();
			$('.bodypartlogin > form > .logmsgbox').removeClass("hidden");
		}		
	}));
});