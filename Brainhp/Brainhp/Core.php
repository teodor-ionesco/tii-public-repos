<?php

namespace Brainhp;

use Exception;
use Brainhp\Dictionary;
use Brainhp\Instructions\Printf;

/*
*	The core class used to bind all methods
*/
class Core
{
	/*
	*	Data entered by user
	*/
	protected $data;

	/*
	*	Code resulted from parsing the data
	*/
	protected $code;

	/*
	*	Response of the executed code
	*/
	protected $result;

	/*
	*	Parse a set of data containing more instructions
	*/
	public static function parse(string $data) : Core
	{
		$TRIM = explode(PHP_EOL, $data);
		$session; $code;

		foreach($TRIM as $line => $string)
		{
			global $code;
			global $session;

			if(($tmp = Printf::parse($string)) || $session === 'Printf')
			{
				$code .= $tmp;

				if(Printf::is_finished())
					$session = null;
				else
					$session = 'Printf';
			}
			else
				throw new Exception('Syntax error at line: '. $line);
		}

		return new Core([
			'code' => $code,
			'data' => $data,
		]);
	}

	/*
	*	Used for self-instantiation
	*/
	public function __construct(array $params)
	{
		empty($params['data']) ?: $this -> data = $params['data'];
		empty($params['code']) ?: $this -> code = $params['code'];
		empty($params['executed']) ?: $this -> executed = $params['executed'];
	}

	/*
	*	Execute the code resulted from parsed data
	*/
	public function execute() : Core
	{
		ob_start();
			eval($this -> code);
			$this -> result = ob_get_contents();
		ob_end_clean();

		return $this;
	}

	/*
	*	Return the string resulted from executed code
	*/
	public function response() : string
	{
		return $this -> result;
	}
}
