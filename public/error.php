<?php 
include_Once __DIR__ . '/../functions.php';

if (!@($_GET['Error'])) { $_GET['Error'] = 'No Errors'; } ?>

<!DOCTYPE html>
<html>
<head>
	<title><?= ErrorReport()['Title'] ?></title>
</head>
<body>
<div id="wrapper">
<?php include_Once 'header.php'; ?>

<div id="main">
	<center>
		<div class="Errors">
			<h2> <?= ErrorReport((string) $_GET['Error'])['Error'] ?> </h2>
			<a href="./"><h3>Go Back</h3></a>
		</div>
	</center>
</div>

<?php include_Once 'footer.php'; ?>
</div>
</body>
</html>