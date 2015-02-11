<?php
	session_start();
	if( isset( $_SESSION[ 'user' ] ) ) {
		unset( $_SESSION[ 'user' ] );
	}

	if( isset( $_SESSION[ 'staff' ] ) ) {
		unset( $_SESSION[ 'staff' ] );
	}

	header( 'Location: http://cs.uky.edu/~lgya222/405G/index.php' );
	exit;

?>
