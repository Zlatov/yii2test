<?php
namespace common\components\helpers;

class Text
{
	public static function translit($text)
	{
        $text = mb_strtolower($text, 'UTF-8');
        $replace = array(
            "а"=>"a", "б"=>"b", "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"e", "ж"=>"j", "з"=>"z", "и"=>"i",
            "й"=>"y", "к"=>"k", "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", "р"=>"r", "с"=>"s", "т"=>"t",
            "у"=>"u", "ф"=>"f", "х"=>"h", "ц"=>"c", "ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"", "ы"=>"y", "ь"=>"",
            "э"=>"e", "ю"=>"yu", "я"=>"ya", 
            " "=> "-"
        );
        $text = strtr($text,$replace);
        $text = preg_replace('/[^a-z0-9_-]/', '', $text);
        $text = preg_replace('/[-]{2,}/', '-', $text);
        $text = preg_replace('/[_]{2,}/', '_', $text);
        $text = trim($text, '-_');
        return $text;
    }
    
	public static function sid($sid,$header = null)
	{
        if ($sid === '') {
            return self::translit($header);
        }
        else {
            return self::translit($sid);
        }
        return '';
	}

	public static function declension($number,$words)
	{
		$return = false;
		if ( !is_array($words) ) {
			$words = explode(' ', trim(preg_replace('/\s+/',' ',$words)));
		}
		if ( empty($words[1]) ) {
			$words[1]=$words[0];
		}
		if ( empty($words[2]) ) {
			$words[2]=$words[1];
		}
		$number = abs($number) % 100;
		if ( $number>10 && $number<20 ) {
			$return = $words[0];
		} else {
			$i = $number % 10;
			switch ($i) {
				case (1): $return = $words[1]; break;
				case (2):
				case (3):
				case (4): $return = $words[2]; break;
				default: $return = $words[0];
			}
		}
		return $return;
	}
}