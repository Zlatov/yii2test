<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sec_news".
 *
 * @property integer $id
 * @property string $sid
 * @property string $header
 *
 * @property News[] $news
 */
class SecNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sec_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'sid', 'header'], 'required'],
            [['header'], 'required'],
            [['id'], 'integer'],
            [['sid'], 'string', 'max' => 80],
            [['header'], 'string', 'max' => 255],
            [['sid'], 'unique'],
            [['header'], 'unique']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->sid === '') {
                $this->sid = $this->translit($this->header);
            }
            else {
                $this->sid = $this->translit($this->sid);
            }
            return true;
        } else {
            return false;
        }
    }
    public function translit($text) {
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'header' => 'Header',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['sec' => 'id']);
    }
}
