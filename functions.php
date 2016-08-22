<?php 

require __DIR__ . '/vendor/autoload.php';

/*	
* @return: Db Connetion
*/

function getDb() 
{
	$connection = new \MongoDB\Client(
		sprintf(
			'mongodb://%s:%d/%s', 
			'localhost', '27017',  
			'shorturl'
		));

    return $connection->shorturl->shorturl;
}

/*
* Insert data to database
* @return: data from database to api
*/

function requestDb($v_p_oUrl) 
{
	$oUrl = findDb($v_p_oUrl, 'full_url', 'short_url');
	$r_mUrl = ($oUrl === Null) ? insertDb($v_p_oUrl) : $oUrl;
	
	return $r_mUrl;		
}

/*
* Insert to db
*/

function insertDb($v_p_ourl) 
{

	$sString = UniqueValue(uniqid());
	
	getDb()->InsertOne([
		'full_url' => (string) $v_p_ourl,
		'short_url' => (string) $_SERVER['HTTP_REFERER'].$sString['sRandom']
	]);

	return findDb($_SERVER['HTTP_REFERER'].$sString['sRandom'], 'short_url');
}

/*
* Find values in db
*/

function findDb($v_p_oUrl, $v2_mVal = Null, $v3_mVal = Null) 
{
	return getDb()->findOne(['$or' => [
			[$v2_mVal => $v_p_oUrl], [$v3_mVal => $v_p_oUrl]
		] 
	]);
}

/*
* Check if the value exist
*/

function UniqueValue($v_sRand) 
{
	$oResults = getDb()->find(['shorturl' => $v_sRand]);
	$aUnique['sRandom'] = $v_sRand;
		
	while (list($v_s_oResult) = each($oResults)) {
	    
	    if ($v_s_oResult === $v_sRand) {
	        
	        $v_sRand = uniqid();
			$aUnique['sRandom'] = $v_sRand;
	        $oResults = getDb()->find(['shorturl' => $v_sRand]);
	        reset($oResults); 
	    
	    }

	}

	
	return $aUnique;
}

/*
* Redirect with get req
*/

function redirectUrl() 
{	
	$oResults = findDb(
		(string) 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 
		'short_url'
	);

	$r_oFinal = (empty($oResults->full_url)) ? 
	'error.php?Error=Url%20missing' : 
	$oResults->full_url;
	
	header('Location:'.$r_oFinal);
}




/*
* Error handler
*/

function dd($v_mData) 
{
	echo "<pre>";
		var_dump($v_mData);
	echo "</pre>";
	
	die;
}

function WopsHandler() 
{
	$whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
    $whoops->register();
}

/*
* @Desk: Show errors in public/error.php
* @param: takes in arg of url
* @return: Array of errors 
*/

function ErrorReport($v_mData = null) 
{
	$aData['Title'] = 'Error Reports';

	($v_mData === null) ? 
	$aData['Error'] = "No Errors" : 
	$aData['Error'] = $v_mData;

	return $aData; 
}

