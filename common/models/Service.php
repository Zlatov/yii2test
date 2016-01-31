<?php

namespace common\models;

use Yii;
use common\components\helpers\Text;

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
            [['header'], 'unique'],
            // [['secSers'], 'safe'],
            // или
            [['secSers'], function ($attribute, $params) {
                if (!is_array($this->$attribute)||count($this->$attribute)===0) {
                    $this->addError($attribute, 'Должна быть указана хотя бы одна секция.');
                }
            }, 'skipOnEmpty' => false, 'skipOnError' => false],
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

    protected $secSers;
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

    protected function updateSecSers()
    {
        SecSer::deleteAll(['ser' => $this->id]);
        if (is_array($this->secSers))
            foreach ($this->secSers as $id) {
                $secSer = new SecSer();
                $secSer->ser = $this->id;
                $secSer->sec = $id;
                $secSer->save();
        }
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
    public function afterSave($insert, $changedAttributes)
    {
        $this->updateSecSers();
        parent::afterSave($insert, $changedAttributes);
    }
}
