<script>
		// apply dynamic padding at the top of the body according to the fixed navbar height
			var onResize = function() {
				$("body").css("padding-top", $(".navbar-fixed-top").height());
			};
			$(window).resize(onResize);
			$(function() {
			  onResize();
			});
		</script>
	</body>
</html>