<?php
	/*On détruit la session (qui a été ouverte dans les autres pages)*/
	session_destroy();
	header("Location: ./index.php");
?>
