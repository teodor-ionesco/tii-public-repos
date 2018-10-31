<?php

namespace Brainhp;

/*
*	Contains most ASCII characters which are used in the system
*/
class Dictionary
{
	/*
	*	Alphabets
	*/
	protected static $alphabet = [
		' ', 'a', 'b', 'c', 'd',
		'e', 'f', 'g', 'h',
		'i', 'j', 'k', 'l',
		'm', 'n', 'o', 'p',
		'q', 'r', 's', 't',
		'u', 'v', 'w', 'x',
		'y', 'z',
	];

	/*
	*	Numbers
	*/
	protected static $numbers = [
		0, 1, 2, 3, 
		4, 5, 6, 7, 
		8, 9, 
	];

	/*
	*	Get characters. -1 for entire set, [0-26] for custom char
	*/
	public static function char(int $pos) {
		if($pos >= 0)
			return self::$alphabet[$pos-1];
		else
			return self::$alphabet;
	}

	/*
	*	Get numbers. -1 for entire set, [0-9] for custom nr
	*/
	public static function nr(int $pos) {
		if($pos >= 0)
			return self::$alphabet[$pos-1];
		else
			return self::$alphabet;
	}
}
