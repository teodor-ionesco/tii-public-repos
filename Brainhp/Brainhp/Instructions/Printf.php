<?php

namespace Brainhp\Instructions;

use Exception;
use Brainhp\Dictionary;

/*
*	Contains methods used to check the script and parse it for echo
*/
class Printf
{
	/*
	*	Is this instruction declared or not?
	*/
	protected static $is_declared = null;

	/*
	*	Holds all matches
	*/
	protected static $matches = [];

	/*
	*	Holds the translated characters
	*/
	protected static $characters = null;

	/*
	*	Holds information regarding whether instruction is finished or not
	*/
	protected static $is_finished = null;

	/*
	*	Parse a single line
	*
	*	@return mixed
	*/
	public static function parse(string $line)
	{
		// Clear cache
		self::$characters = null;

		if(!self::$is_declared)
			self::is_declared($line) ? self::$characters = ' print("' : null; // Check if it is now declared and append ' print("'

		if(!self::$is_declared)	// If it's not declared return
			return;

		if(self::is_printable($line))
			self::translate();			// Translate the matches

		if(!self::$is_finished) // Check if instruction is finished
			self::is_end($line) ? self::$characters .= '"); ' : null; // If yes, append '"); ' to the end

		return self::$characters;
	}

	/*
	*	Returns the status of the instruction
	*/
	public static function is_finished() : bool
	{
		return (self::$is_finished === true) ? true : false;
	}

	/*
	*	Checks if instruction is declared on current line
	*/
	private static function is_declared(string &$line) : bool
	{
		if(preg_match('#([ ,\t]+|^)>([ ,-]+|$)#', $line) === 1)
			self::$is_declared = true;
		else
			self::$is_declared = false;

		return self::$is_declared;
	}

	/*
	*	Checks if there are any characters (-) which can be translated
	*/
	private static function is_printable(string &$line) : bool
	{
		if(preg_match_all('#(-+)#', $line, $matches) !== false)
			self::$matches = $matches[0];

		return self::$matches ? true : false;
	}

	/*
	*	Translate all dots/lines to real characters
	*/
	private static function translate() : string
	{
		foreach(self::$matches as $key => $value)
			self::$characters .= Dictionary::char(strlen($value));

		return self::$characters;
	}

	/*
	*	Check if line represents the end of the instruction
	*/
	private static function is_end(string &$line) : bool
	{
		if(preg_match('#([ ,\t,-]+|^)<([ ,\t]+|$)#', $line) === 1)
			self::$is_finished = true;
		else
			self::$is_finished = false;

		return self::$is_finished;
	}
}
