<?php
namespace frontend\models;

class BuyForm extends \yii\base\Model
{
    public $count;
    public $user_id;
    public $product_id;

    public function rules()
    {
        return [
            [['count', 'user_id', 'product_id'], 'required'],
			[['count', 'user_id', 'product_id'], 'integer'],
			[['count', 'user_id', 'product_id'], 'compare', 'compareValue' => 0, 'operator' => '>'],
			[['count'], 'compare', 'compareValue' => 99, 'operator' => '<='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'count' => 'Количество',
        ];
    }

}