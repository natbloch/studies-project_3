	//-----------------------------------Administration--------------------------------------------------------------

	$(document).ready(function(){
		getAllEmployees();
	});
	function getAllEmployees(){
		connectToServer('getemployeeinfo.php', null, 'PUT');
	}
	

	$(document).ready(function(e){
		$("#fileadminupload").on('submit', (function(e) {
			e.preventDefault();
			var _this = this;
			var name = $("#adminname").val().trim();
			var phone = $("#adminphone").val().trim();
			var email = $("#adminemail").val().trim();
			var role = $("#adminrole").val();
			if(name == "" || phone == "" || email == "" || role == ""){
				window.alert("Please Enter Valid Information Where Needed");
			}else{
				$.ajax({
					url: "http://localhost/project%20module%203/controller/getemployeeinfo.php",
					type: "POST",             
					data: new FormData(_this), 
					contentType: false,       
					cache: false,             
					processData:false,        
					success: function(data){console.log(data);}
				});                                                                   
			}                                                                               
		
		}));
	});	
	
	
	function connectToServer(url, val, method){
		$.ajax({
			url:'http://localhost/project%20module%203/controller/' + url,
			data: val,
			method: method
		 }).done(function(data){
			console.log("success from server");
			if(method == "DELETE"){
				$(".bodypartadminmain .adminctr").empty();
			}else if(url == 'getemployeeinfo.php'){
				var f = JSON.parse(data);
				displayEmployeeCol(f);	
			}else{
				console.log(data);
			}
		 }).fail(function(reqObj, textStatus){  
			console.log("error server call");
		 });
	};
	
	function displayEmployeeCol(d){
		$(".bodypartadminmain .admincol ul").empty();
		for(var k in d){
			$(".bodypartadminmain .admincol ul").append("<li adminid='"+d[k]['EmployeeId']+"'><div class='imgbox'><img src='data:image;base64,"+d[k]['ImageLink']+"'></div><div class='infobox'><span>"+d[k]['Name']+", "+d[k]['Role']+"</span></br><span>"+d[k]['Phone']+"</span></br><span>"+d[k]['Email']+"</span></div></li>");
		}
		$(".bodypartadminmain .admincol ul > li").click(function(){
			var myid = $(this).attr('adminid');
			var myimage = $(this).children("div:eq(0)").children("img").attr('src');
			var myname = $(this).children("div:eq(1)").children("span:eq(0)").html().split(", ")[0];
			var myrole = $(this).children("div:eq(1)").children("span:eq(0)").html().split(", ")[1];
			var myphone = $(this).children("div:eq(1)").children("span:eq(1)").html();
			var myemail = $(this).children("div:eq(1)").children("span:eq(2)").html();
			showSelectEmployee(myid, myimage, myname, myrole, myphone, myemail);
		}); 
		$(".bodypartadminmain .admincol .colcat i").click(function(){
			addEditEmployee();
		});
	}
	
	
	function showSelectEmployee(id, img, name, role, phone, email){
		$(".bodypartadminmain .adminctr").empty();
		$(".bodypartadminmain .adminctr").append("<div class='displaytitleshow clearfix'><span style='font-weight:bold; font-size:24px;'>Employee: "+name+"</span><button style='position:relative; float:right; right:20px; background-color:red; color:white; font-weight:bold;	padding:5px 20px; margin:0 10px 15px 20px;'>Edit</button></div><div class='displaycontshow clearfix' style='width:90%; padding:10px;'><img style='position:relative; float:left; width:80px; height:80px;' src='"+img+"'><div class='continfo' style='position:relative; float:left; top:-10px; margin-left:20px; max-width:300px;'><h3>"+name+" ,"+role+"</h3><h6>"+phone+"</h6><h6>"+email+"</h6></div></div>");
		
		$(".bodypartadminmain .adminctr .displaytitleshow button").click(function(){
			addEditEmployee(id, img, name, role, phone, email);
		});
	}
	
	function addEditEmployee(id, img, name, role, phone, email){
		$(".bodypartadminmain .adminctr").empty();
		if(id){
			var userrolearr = $(".userinfobox span").html().split(', ');
			var userole = userrolearr[1];
			if(userole == "owner"){
				var ownerright = '<option value="owner" id="owneropt"> Owner </option>';
				var ownerright2 = '<span>Password: <input type="password" name="adminpass" id="adminpass"></span></br>';
				var deletebutton = '<input type="button" style="background-color:red;" id="deleteadmin" value="Delete">';
			}else{
				var ownerright ="";
				var ownerright2 ="";
				var deletebutton ="";
			}
			var imgprev = img.replace('data:image;base64,','');
			var titlestring = "Edit Employee: "+name;
			
		}else{
			var ownerright2 ="";
			var ownerright = "";
			var imgprev ="";
			var id = "";
			var titlestring = "Add a New Employee";
			var deletebutton = "";
			img = name = role = phone = email = "";
		}
		$(".bodypartadminmain .adminctr").append('<div class="displaytitle"><span>'+titlestring+'</span></div><form class="adminnewedit" action="http://localhost/project%20module%203/controller/getemployeeinfo.php" id="fileadminupload" method="POST" enctype="multipart/form-data"><div class="buttonarea clearfix">'+deletebutton+'<input type="submit" style="float:left;" class="submitnewadmin" value="Save"></div><div class="formctr"><span>Name: <input type="text" value="'+name+'" name="name" id="adminname"></span></br><span>Phone: <input type="text" value="'+phone+'" name="phone" id="adminphone"></span></br><span>E-mail: <input type="text" value="'+email+'" name="email" id="adminemail"></span></br>'+ownerright2+'<span>Role: <select name="role" id="adminrole"><option value="" disabled>     </option><option value="sales" id="salesopt"> Sales </option><option value="manager" id="manageropt"> Manager </option>'+ownerright+'</select></span></br><span>Image: <input type="file" name="adminimg" id="adminimg"><input class="hidden" type="text" value="'+imgprev+'" name="adminimgprev" id="adminimgprev"></span></br><input class="hidden" type="text" value="'+id+'" name="adminid" id="adminid"><img src="'+img+'"></br></div></form>');
		if(role == "sales"){
			$(".bodypartadminmain .adminctr .formctr #salesopt").attr("selected","selected");
		}else if(role == "manager"){
			$(".bodypartadminmain .adminctr .formctr #manageropt").attr("selected","selected");
		}else if(role == "owner"){
			$(".bodypartadminmain .adminctr .formctr #owneropt").attr("selected","selected");			
		}
		$(".bodypartadminmain #adminimg").on("change keyup paste", function(event){
			var thatImg = URL.createObjectURL(event.target.files[0]);
			$(".bodypartadminmain .adminnewedit img").attr('src', thatImg);
		});
		$("#deleteadmin").on('click', (function() {
			var id={};
			id['req'] = "delete";
			id['adminid'] = $("#adminid").attr('value');
			connectToServer('getemployeeinfo.php', id, 'POST');
		}));
		
	}