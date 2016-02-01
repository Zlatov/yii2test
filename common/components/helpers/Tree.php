<?php

namespace common\components\helpers;

class Tree
{
	public static function level($array)
	{
		$result = [];
		$level = 0;
		$pid[$level] = null;
		while ($level >= 0)
		{
			if ( $e = each($array) )
			{
				if ($e[1]['pid'] === $pid[$level])
				{
					$e[1]['level'] = $level;
					$result[] = $e[1];
					unset($array[$e[0]]);
					foreach ($t = $array as $val)
					{
						if ( $val['pid'] === $e[1]['id'] )
						{
							$pid[++$level] = $e[1]['id'];
							reset($array);
							break;
						}
					}
				}
			}
			else
			{
				$level--;
				reset($array);
			}
		}
		return $result;
	}
	public static function header($array)
	{
		$array = self::level($array);
		foreach ($array as $key => $val)
		{
			$separator = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$val['level']);
			if ($val['level'] !== 0)
			{
				if ((isset($array[$key + 1])) && ($val['level'] == $array[$key + 1]['level']))
				{
					$separator.= '&#9500;&nbsp;';
				}
				else
				{
					$separator.= '&#9492;&nbsp;';
				}
			}
			else
			{
				$separator.= '';
			}
			$array[$key]["header"] = $separator.$val["header"];
		}
		return $array;
	}
}