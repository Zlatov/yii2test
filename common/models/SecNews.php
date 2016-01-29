<?php

namespace common\models;

use Yii;
use common\components\helpers\Text;

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
            $this->sid = Text::sid($this->sid,$this->header);
            return true;
        } else {
            return false;
        }
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
