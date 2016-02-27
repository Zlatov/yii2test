<?php

namespace common\models;


use Yii;
use common\components\helpers\Text;
use common\components\helpers\ToText;



/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $sid
 * @property string $header
 * @property string $text
 * @property string $updated_at
 * @property string $created_at
 * @property integer $sec
 *
 * @property SecNews $sec0
 */
class News extends \yii\db\ActiveRecord
{
    use ToText;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header', 'sec'], 'required'],
            [['text'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['sec'], 'integer'],
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
            'updated_at' => 'Обновлена',
            'created_at' => 'Создана',
            'sec' => 'Секция',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSec0()
    {
        return $this->hasOne(SecNews::className(), ['id' => 'sec']);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->sid = Text::sid($this->sid,$this->header);
            $this->updated_at = date('YmdHis');
            if($this->isNewRecord) {
                $this->created_at = date('YmdHis');
            }
            return true;
        } else {
            return false;
        }
    }
}
