<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sec_service".
 *
 * @property integer $id
 * @property string $sid
 * @property string $header
 * @property integer $order
 *
 * @property SecSer[] $secSers
 * @property Service[] $sers
 */
class SecService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sec_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'header'], 'required'],
            [['order'], 'integer'],
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
            'order' => 'Номер для сортировки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecSers()
    {
        return $this->hasMany(SecSer::className(), ['sec' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSers()
    {
        return $this->hasMany(Service::className(), ['id' => 'ser'])->viaTable('sec_ser', ['sec' => 'id']);
    }
}
