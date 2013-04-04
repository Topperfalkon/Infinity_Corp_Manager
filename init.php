<?php
/**
 * Setup the ICM environment
 * 
 * @package Infinity_Corp_Manager
 * @license Creative Commons Attribution-NonCommercial-ShareAlike (http://creativecommons.org/licenses/by-nc-sa/3.0/)
 * @author Hamish Robertson (http://github.com/hrobertson/)
 */

define( 'ABSPATH', dirname(__FILE__) . '/' );

error_reporting( E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'config.php') ) {
	require_once( ABSPATH . 'config.php' );
} elseif ( file_exists( dirname(ABSPATH) . 'install.php' )) {
	// The install script has not yet been run.
	exit( header( 'install.php' ));

}



?>