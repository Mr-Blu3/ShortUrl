<!DOCTYPE html>
<html>
<head>
	<title>Short Url</title>
	<script src="https://fb.me/react-15.2.1.js"></script>
	<script src="https://fb.me/react-dom-15.2.1.js"></script>
	<script src="js/libs/browser.min.js"></script>
 	<script type="text/babel" src="js/url.js"></script>
 
</head>
<body>
<div id="wrapper">

<?php include_Once "header.php"; ?>

	<div id="main">				
		<div id="RenderFields"></div>
		<center>
			<?php 
				if(@($_GET['Url'])) {
					
					include_Once __DIR__ . '/../functions.php';
					echo redirectUrl();

				}
			?>
		</center>
	</div>


	<?php include_Once "footer.php"; ?>

</div>
</body>
</html>