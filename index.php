<?php
	
	include __DIR__ . '/vendor/autoload.php';
	include __DIR__ . '/_config.php';
	
	$twitter = new TwitterAPIExchange($settings);
	
	$statusEndpoint 	= "https://api.twitter.com/1.1/statuses/update.json";
	$mediaEndpoint 		= "https://upload.twitter.com/1.1/media/upload.json";
	
	$mediaPostFields 	= [
		'media_data'	=> base64_encode(file_get_contents(__DIR__ . '/uploads/onedoesnot.jpg')),
		'name'			=> 'One does not simply'
	];
	
	$dataPicture = $twitter->buildOauth($mediaEndpoint, 'POST')
    	->setPostfields($mediaPostFields)
		->performRequest();
		
	if( !empty($dataPicture) ) {
		$dataPicture = json_decode($dataPicture);
		
		$statusPostfields = [
			'status'	=> 'One does not simply walk into Twitter',
			'media_ids'	=> $dataPicture->media_id
		];
		
		echo $twitter->buildOauth($statusEndpoint, 'POST')
	    	->setPostfields($statusPostfields)
			->performRequest();
			
		echo "\n";
		
	}
	
	