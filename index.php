<?php

	session_start();
	
	if (isset($_SESSION['userIsLogged']) && $_SESSION['userIsLogged']==true)
	{
		header('Location: balance.php');
		exit();
	}
  else
  {
    header('Location: login.php');
    exit();
  }
?>
