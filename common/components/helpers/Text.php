<?php
namespace common\components\helpers;

class Text
{
	private static $months = [
		1 => 'января',
		2 => 'февраля',
		3 => 'марта',
		4 => 'апреля',
		5 => 'мая',
		6 => 'июня',
		7 => 'июля',
		8 => 'августа',
		9 => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря',
	];

	/* 
	* Возвращает:
	* "сегодня в 19:31" или
	* "14 апреля в 19:31" или
	* "14 апреля 2016 года в 19:31"
	*/
	public static function tsToStr($stringTimeStamp = null)
	{
		if (is_null($stringTimeStamp)) return '';
		$ts = strtotime($stringTimeStamp);
		foreach (str_split('YmdHis') as $e => $ch)
			if (date($ch,$ts)!==date($ch)) {
				switch ($e) {
					case 0:
						// Ничего не совпало
						// 16 декабря 2015 года, в 17:30:31
						return date('j') . ' ' . self::$months[date('n',$ts)] . ' ' . date('Y',$ts) . ' года, в ' . date('H:i:s',$ts);
					case 1:
						// Совпал только год
					case 2:
						// Совпали год месяц
						// 16 декабря, в 17:30:31
						return date('j') . ' ' . self::$months[date('n',$ts)] . ', в ' . date('H:i:s',$ts);
					case 3:
						// Совпали год месяц день
					case 4:
						// Совпали год месяц день час
						// сегодня в 17:30:31
						return 'сегодня в ' . date('H:i:s',$ts);
					case 5:
						// Совпали год месяц день час минута
						// 10 секунд назад
						return sprintf('%d %s назад',time()-$ts, self::declension(time()-$ts,'секунд секунда секунды'));
				}
				break;
			} else {
				continue;
			}
		return 'сейчас';

		$return = (($year===$thisYear)?'':$year) . ' ' . date('j',$ts) . ' ' . $this->ttMonth[date('n',$ts)];

		// $return = date('Y',)
		// $this->created_at;
		return $return;
	}

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
            return mb_substr(self::translit($header), 0, 80);
        }
        else {
            return mb_substr(self::translit($sid), 0, 80);
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