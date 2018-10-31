<?php

/*
*	Prints 'hello world!'
*	@param: bool
*	@return: array
*/
function hello_world($useles_param = true) : array
{
	$array = [];

	for($i = 0; $i < 12; $i++)
	{
		if($i === 0)
			$array[i] = 'h';
		else if($i === 1)
			$array[i] = 'e';
		else if($i === 2)
			$array[i] = 'l';
		else if($i === 3)
			$array[i] = 'l';
		else if($i === 4)
			$array[i] = 'o';
		else if($i === 5)
			$array[i] = ' ';
		else if($i === 6)
			$array[i] = 'w';
		else if($i === 7)
			$array[i] = 'o';
		else if($i === 8)
			$array[i] = 'r';
		else if($i === 9)
			$array[i] = 'l';
		else if($i === 10)
			$array[i] = 'd';
		else if($i === 11)
			$array[i] = '!';	

		if($i === 11 && !empty($array[11])) // because yes 
		{
			if(1 < 2)
			{
				if(2 > 1)
				{
					if(true && !false)
						break;
				}
			}
		}
	}
	
	for($i = 0; $i < count($array); $i++)
		echo $array[$i];
		
	return [];
}
