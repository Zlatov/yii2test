<?php

namespace common\models;

use Yii;
use common\components\helpers\Text;
use common\components\TreeBranch;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $header
 * @property string $sid
 * @property string $text
 * @property integer $order
 * @property string $title
 * @property string $desription
 * @property string $keywords
 *
 * @property Page $p
 * @property Page[] $pages
 */
class Page extends \yii\db\ActiveRecord
{
	use TreeBranch;
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'page';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['pid'], 'integer'],
			[['header'], 'required'],
			[['text'], 'string'],
			[['order'], 'default', 'value'=>'100','when'=> function($model){ return $model->isNewRecord; }],
			[['order'], 'integer', 'min' => 0, 'max' => 65535,],
			[['header', 'desription', 'keywords'], 'string', 'max' => 255],
			[['sid'], 'string', 'max' => 80],
			[['title'], 'string', 'max' => 160],
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
			'id' => 'Ид. номер',
			'pid' => 'Родительская страница',
			'header' => 'Заголовок',
			'sid' => 'Строковый ид.',
			'text' => 'Текст',
			'order' => 'Для сортировки',
			'title' => 'Title',
			'desription' => 'Description',
			'keywords' => 'Keywords',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getP()
	{
		return $this->hasOne(Page::className(), ['id' => 'pid']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPages()
	{
		return $this->hasMany(Page::className(), ['pid' => 'id']);
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->pid==='0') {
				$this->pid = null;
			}
			$this->sid = Text::sid($this->sid,$this->header);
			if ($this->sid === '') {
				$this->addError('sid', 'Строковый идентификатор не смог создасться из заголовка, измените заголовок.');
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			if ((int)($this->getPages()->count())>0) {
				$this->addError('id', 'У данной страницы есть потомки — сначало удалите потомков.');
                return false;
			}
			return true;
		} else {
			return false;
		}
	}
}
