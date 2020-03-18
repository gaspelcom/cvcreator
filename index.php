<?php
session_start();
include_once('autoloader.php');

include_once('css/main.php');

if (empty($_POST)) {
	include_once('lib/choose.php');
} else {
	switch($_POST['step']) {
		case "1":
			include_once('lib/form.php');
		break;
		case "2":
			if ($_POST['action'] == "Lebenslauf erstellen") {
					$document = new cv\Document\Document();
					$document->create($_POST);
					$document->open('docx');
			} else {
				include_once('lib/form.php');
			}
		break;
		default:
			include_once('lib/choose.php');
		break;
	}
	
}

include_once('css/footer.php');