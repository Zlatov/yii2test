<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property string $sid
 * @property string $header
 * @property string $text
 * @property integer $order
 *
 * @property SecSer[] $secSers
 * @property SecService[] $secs
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header'], 'required'],
            [['text'], 'string'],
            [['order'], 'default', 'value'=>'100','when'=> function($model){ return $model->isNewRecord; }],
            [['order'], 'integer', 'min' => 0, 'max' => 65535,],
            [['sid'], 'string', 'max' => 80],
            [['header'], 'string', 'max' => 255],
            [['sid'], 'unique'],
            [['header'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид.',
            'sid' => 'Строковый ид.',
            'header' => 'Заголовок',
            'text' => 'Текст',
            'order' => 'Номер для упорядочивания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecSers()
    {
        return $this->hasMany(SecSer::className(), ['ser' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecs()
    {
        return $this->hasMany(SecService::className(), ['id' => 'sec'])->viaTable('sec_ser', ['ser' => 'id']);
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
}
