<?php
namespace common\components\helpers;

trait ToText {
	private $ttMonth = [
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

	public function ttTimeStamp($stringTimeStamp = null)
	{
		if (is_null($stringTimeStamp)) return '';
		$ts = strtotime($stringTimeStamp);
		$year = date('Y',$ts);
		$thisYear = date('Y');
		$return = (($year===$thisYear)?'':$year) . ' ' . date('j',$ts) . ' ' . $this->ttMonth[date('n',$ts)];

		// $return = date('Y',)
		// $this->created_at;
		return $return;
	}
}
