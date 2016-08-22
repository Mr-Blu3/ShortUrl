<?php

include_Once __DIR__ . '/../functions.php';

$aRequest = [];

switch ($_POST['Url']) {
	default:
		$aRequest['service'] = requestDb($_POST['Url']);
		break;
}

echo json_encode($aRequest);
die;
