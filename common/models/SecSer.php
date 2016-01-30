<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sec_ser".
 *
 * @property integer $ser
 * @property integer $sec
 *
 * @property SecService $sec0
 * @property Service $ser0
 */
class SecSer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sec_ser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ser', 'sec'], 'required'],
            [['ser', 'sec'], 'integer'],
            [['ser', 'sec'], 'unique', 'targetAttribute' => ['ser', 'sec'], 'message' => 'The combination of Ser and Sec has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ser' => 'Ser',
            'sec' => 'Sec',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSec0()
    {
        return $this->hasOne(SecService::className(), ['id' => 'sec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSer0()
    {
        return $this->hasOne(Service::className(), ['id' => 'ser']);
    }
}
