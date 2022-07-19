<!-- Nav Bar-->
		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid thebar">
				<div class="navbar-header">
					<a href="#"><img style="height:35px; width:230px;" src="http://mms.businesswire.com/bwapps/mediaserver/ViewMedia?mgid=41869&vid=5"></a>  |
					<a href="http://localhost/project%20module%203/view/studclasspage/studclasspage.php" id="qwerty">School</a>  |
					<?php if($_SESSION["userrole"] == "owner" || $_SESSION["userrole"] == "manager"){echo '<a href="http://localhost/project%20module%203/view/adminpage/adminpage.php">Administration</a>  |';}?>
				</div>
				<div class="nav navbar-nav navbar-right">
					<div class="userimgbox">
						<?php echo "<img src='data:image;base64,".$_SESSION['userimage']."'>";?>
					</div>
					
					<div class="userinfobox">
						<span><?php echo $_SESSION["username"].', '.$_SESSION["userrole"];?></span></br>
						<a href="http://localhost/project%20module%203/controller/getlogin.php">Log Out</a>
					</div>
				</div>
			</div>
		</nav>