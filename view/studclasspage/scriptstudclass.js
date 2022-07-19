//------------------Student Class Page---------------	
	$(document).ready(function(){
		getAllStudentsAndClasses();
	});
	
	function getAllStudentsAndClasses(){
			connectToServer('getstudinfo.php', null, 'PUT');
	}
	

	

	
	

//------------------ New / Edit Class or Student----------------------------------



$(document).ready(function(e){
	$("#fileclassupload").on('submit', (function(e) {
		e.preventDefault();
		var _this = this;
		var name = $("#classname").val().trim();
		var description = $("#classdescription").val().trim();
		if(name == "" || description == ""){
			window.alert("Please Enter Valid Information Where Needed");
		}else{
			$.ajax({
				url: "http://localhost/project%20module%203/controller/getclassinfo.php",
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
		
	$(document).ready(function(e){
		$("#filestoupload").on('submit', (function(e){
			e.preventDefault();
			var _this = this;
			var name = $("#studname").val().trim();
			var phone = $("#studphone").val().trim();
			var email = $("#studemail").val().trim();
			if(name == "" || phone == "" || email == ""){
				window.alert("Please Enter Valid Information Where Needed");
			}else{
				$.ajax({
					url: "http://localhost/project%20module%203/controller/getstudinfo.php",
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
			if(method == "DELETE"){
				$(".bodypartclassmain .mainboxdisplay").empty();
			}else if(url == 'getstudinfo.php' || url == 'getclassinfo.php'){
				
				var a = JSON.parse(data);
				var bclass = a['class'];
				var bstud = a['stud'];				
				displayStudCol(bstud,bclass);				
				displayClassCol(bclass,bstud);
			
			}
		 }).fail(function( reqObj, textStatus ) {  
			console.log("error server call");
		 });
	};
	
	//---------Build student column and windows
	function displayStudCol(d,e){
		$(".bodypartclassmain .studentcol .listed").empty();
		for(var k in d){
			$(".bodypartclassmain .studentcol .listed").append("<li studid='"+d[k]['StudentId']+"' studemail='"+d[k]['Email']+"' studclasses='"+d[k]['ClassesTaken']+"'><div class='imgbox'><img src='data:image;base64,"+d[k]['ImageLink']+"'></div><div class='infobox'><span>"+d[k]['Name']+"</span></br><span>"+d[k]['Phone']+"</span></div></li>");
		} 
		$(".bodypartclassmain .studentcol .listed li").click(function(){
			var myid = $(this).attr('studid');
			var myemail = $(this).attr('studemail');
			var myclasses = $(this).attr('studclasses');
			var myimage = $(this).children("div:eq(0)").children("img").attr('src');
			var myname = $(this).children("div:eq(1)").children("span:eq(0)").html();
			var myphone = $(this).children("div:eq(1)").children("span:eq(1)").html();
			showSelectStud(myid, myemail, myclasses, e, myimage, myname, myphone);
		});
		$(".bodypartclassmain .studentcol .colcat i").click(function(){
			addEditStud(e);
		});
	}
	
	function showSelectStud(id, email, classes, allclasses, img, name, phone){
		var classarray = classes.split(',').map(function(item) {
			return parseInt(item, 10);
		});
		var listofclasses = "";
		for (var k in classarray){
			
			for (var i in allclasses){
				
				if(classarray[k] == allclasses[i]['ClassId']){
					
					listofclasses += ("<li><img src='data:image;base64,"+allclasses[i]['ImageLink']+"'><span>"+allclasses[i]['Name']+"</span></li>");
				}
			}
		}
		$(".bodypartclassmain .mainboxdisplay").empty();
		$(".bodypartclassmain .mainboxdisplay").append("<div class='studclassdisplay'><div class='displaytitle clearfix'><span>Student</span><button>Edit</button></div><div class='displaycont clearfix'><img src='"+img+"'><div class='continfo'><h3>"+name+"</h3><h5>"+phone+"</h5><h5>"+email+"</h5></div></div><ul>"+listofclasses+"</ul></div>");
		
		$(".bodypartclassmain .mainboxdisplay .studclassdisplay .displaytitle button").click(function(){
			addEditStud(allclasses, id, email, classarray, img, name, phone);
		});
	}
	
	function addEditStud(e, id, email, classarray, img, name, phone){
		$(".bodypartclassmain .mainboxdisplay").empty();
		if(id){
			var imgprev = img.replace('data:image;base64,','');
			var listofclasses="";
			var titlestring = "Edit Student: "+name;
			var deletebutton = '<input type="button" style="background-color:red;" id="deletestud" value="Delete">';
			for (var i in e){
				var flag = 0;
				for (var k in classarray){
					if(classarray[k] == e[i]['ClassId']){
						listofclasses += ("<li><input type='checkbox' name='course["+e[i]['ClassId']+"]' checked> "+e[i]['Name']+"</li>");
						flag = 1;
					}
				}
				if(flag == 0){
					listofclasses += ("<li><input type='checkbox' name='course["+e[i]['ClassId']+"]'> "+e[i]['Name']+"</li>");
				}
			}
		}else{
			var imgprev = "";
			var id = "";
			var titlestring = "Add a New Student";
			var deletebutton = "";
			email = classes = img = name = phone = "";
			var listofclasses="";
			for (var i in e){
				listofclasses += ("<li><input type='checkbox' name='course["+e[i]['ClassId']+"]'> "+e[i]['Name']+"</li>");
			}
		}
		$(".bodypartclassmain .mainboxdisplay").append('<div class="studclassedit"><div class="displaytitle"><span>'+titlestring+'</span></div><form class="studentnewedit" action="http://localhost/project%20module%203/controller/getstudinfo.php" id="filestoupload" method="POST" enctype="multipart/form-data"><div class="buttonarea clearfix">'+deletebutton+'<input type="submit" style="float:left;" class="submitnewstud" value="Save"></div><div class="formctr"><span>Name: <input type="text" value="'+name+'" name="name" id="studname"></span><span>Phone: <input type="text" value="'+phone+'" name="phone" id="studphone"></span><span>E-mail: <input type="text" value="'+email+'" name="email" id="studemail"></span><span>Image: <input id="studimg" type="file" name="studimg" accept="image/*"></span><input class="hidden" type="text" value="'+imgprev+'" name="studimgprev" id="studimgprev"><input class="hidden" type="text" value="'+id+'" name="studid" id="studid"><img src="'+img+'"></br>Courses: <ul>'+listofclasses+'</ul></div></form></div>');
		
		$(".mainboxdisplay #studimg").on("change keyup paste", function(event){
			var thatImg = URL.createObjectURL(event.target.files[0]);
			$(".mainboxdisplay .studentnewedit img").attr('src', thatImg);
		});
		$("#deletestud").on('click', (function() {
			var id={};
			id['req'] = "delete";
			id['studid'] = $("#studid").attr('value');
			connectToServer('getstudinfo.php', id, 'POST');
		}));
		
	}
	
	//---------Build Class column and windows
	
	
	function displayClassCol(d,e){
		$(".bodypartclassmain .coursecol .listed").empty();
		for(var k in d){
			$(".bodypartclassmain .coursecol .listed").append("<li classid='"+d[k]['ClassId']+"' description='"+d[k]['Description']+"'><div class='imgbox'><img src='data:image;base64,"+d[k]['ImageLink']+"'></div><div class='infobox'><span>"+d[k]['Name']+"</span></br></div></li>");
		}
		$(".bodypartclassmain .coursecol .listed > li").click(function(){
			var myid = $(this).attr('classid');
			var listofstudents="";
			var countstudents=0;
			for(var k in e){
				var classarray = e[k]['ClassesTaken'].split(',').map(function(item) {
					return parseInt(item, 10);
				});
				for(var l in classarray){
					if(classarray[l] == myid){
						listofstudents += ("<li><img src='data:image;base64,"+e[k]['ImageLink']+"'><span>"+e[k]['Name']+"</span></li>");
						countstudents++;
					}
				}
			}		
			var mydescription = $(this).attr('description');
			var myimage = $(this).children("div:eq(0)").children("img").attr('src');
			var myname = $(this).children("div:eq(1)").children("span").html();
			showSelectClass(myid, listofstudents, countstudents, mydescription, myimage, myname);
		});
		$(".bodypartclassmain .coursecol .colcat i").click(function(){
			addEditClass();
		});
	}
	
	function showSelectClass(id, listofstudents, countstudents, description, img, name){
		$(".bodypartclassmain .mainboxdisplay").empty();

		$(".bodypartclassmain .mainboxdisplay").append("<div class='studclassdisplay'><div class='displaytitle clearfix'><span>Class: "+name+", "+countstudents+" Students</span><button>Edit</button></div><div class='displaycont clearfix'><img src='"+img+"'><div class='continfo'><h3>"+name+"</h3><p>"+description+"</p></div></div><ul>"+listofstudents+"</ul></div>");
		
		$(".bodypartclassmain .mainboxdisplay .studclassdisplay .displaytitle button").click(function(){
			addEditClass(id, countstudents, description, img, name);
		});
	}
	
	function addEditClass(id, countstudents, description, img, name){
		$(".bodypartclassmain .mainboxdisplay").empty();
		if(id){
			var imgprev = img.replace('data:image;base64,','');
			var titlestring = "Edit Class: "+name;
			var deletebutton = '<input type="button" style="background-color:red;" id="deleteclass" value="Delete">';
		}else{
			var imgprev = "";
			var id = "";
			var titlestring = "Add a New Class";
			var deletebutton = "";
			countstudents = description = img = name = "";
		}
		$(".bodypartclassmain .mainboxdisplay").append('<div class="studclassedit"><div class="displaytitle"><span>'+titlestring+'</span></div><form class="classnewedit" action="http://localhost/project%20module%203/controller/getclassinfo.php" id="fileclassupload" method="POST" enctype="multipart/form-data"><div class="buttonarea clearfix">'+deletebutton+'<input type="submit" style="float:left;" class="submitnewclass" value="Save"></div><div class="formctr"><span>Name: <input type="text" value="'+name+'" name="name" id="classname"></span></br><span>Description: </span></br><textarea class="classdescript" name="description" id="classdescription"></textarea></br><span>Image: <input type="file" name="classimg" id="classimg"></span><input class="hidden" type="text" value="'+imgprev+'" name="classimgprev" id="classimgprev"><input class="hidden" type="text" value="'+id+'" name="classid" id="classid"><img src="'+img+'"></br><h4>Total: '+countstudents+' Students taking this course</h4></div></form></div>');
		$(".bodypartclassmain .mainboxdisplay .classnewedit .formctr textarea").append(description);
		$(".mainboxdisplay #classimg").on("change keyup paste", function(event){
			var thatImg = URL.createObjectURL(event.target.files[0]);
			$(".mainboxdisplay .classnewedit img").attr('src', thatImg);
		});
		$("#deleteclass").on('click', (function() {
			var id={};
			id['req'] = "delete";
			id['classid'] = $("#classid").attr('value');
			connectToServer('getclassinfo.php', id, 'POST');
			
		}));
		
	}