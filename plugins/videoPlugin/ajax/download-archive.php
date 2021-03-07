<?php

	@session_start();

	require_once("../../../includes/db.php");
	require_once("../../../vendor/autoload.php");

	use OpenTok\Role;
	use OpenTok\MediaMode;
	use OpenTok\OutputMode;

	$archiveId = $input->post("archiveId");

	$opentok_api_key = $row_general_settings->opentok_api_key;
	$opentok_api_secret = $row_general_settings->opentok_api_secret;

	$opentok = new OpenTok\OpenTok($opentok_api_key,$opentok_api_secret);
   $archive = $opentok->getArchive($archiveId);

   echo $archive->url;
