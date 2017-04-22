<?php
//in a library file export.php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Excel library for Code Igniter applications
 * Based on: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
 * Tweaked by: Moving.Paper June 2013
 */
class Common{
	function getNormalizedName($name){
		if(empty($name)){
			return '';
		}
		
		$url = $name;
		//$special = '/[!@\#\$%\^&\*\(\)\-\=\_\+\?\\\[\]/.{}<>~`;,"\']/g';
		$special = '/[^a-zA-Z0-9 ]/';
		// remove special charaters
		$url = preg_replace($special, '', $url);
		// remove spaces trailing and preceding
		$url = trim($url);
		// to lowercase
		$url = strtolower($url);
		// spaces to -
		$url = preg_replace('/ /', '-', $url);
		return $url;
	}
}