<?php 


function show_input(){
	foreach ($_GET as $key => $value){
		print "$key = $value<br>";
	}
	foreach ($_POST as $key => $value){
		print "$key = $value<br>";
	}
}

function in($n){
//  print_r($n);
  if (array_key_exists($n, $_GET)) return $_GET[$n];
  elseif (array_key_exists($n, $_COOKIE)) return $_COOKIE[$n];
  elseif (array_key_exists($n, $_POST)) return $_POST[$n];
}

?>