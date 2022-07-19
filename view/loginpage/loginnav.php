		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid thebar">
				<div class="navbar-header">
					<a href="#"><img style="height:35px; width:230px;" src="http://mms.businesswire.com/bwapps/mediaserver/ViewMedia?mgid=41869&vid=5"></a>
				</div>
			</div>
		</nav>
		
		<!-- Login Box -->
		<div class="jumbotron bodypartlogin">
			<form id="loginform" action="http://localhost/project%20module%203/controller/getlogin.php" method="POST">
				<span>Username: <input type="text" id="username" name="emailorname" value=""></span></br>
				<span>Password: <input type="password" id="userpassword" name="pass"></span></br>
				<input type="submit" class="inputbutton" value="Log In"> <span class="logmsgbox hidden">Please enter valid username and password</span>
			</form>
		</div>