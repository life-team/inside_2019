<?php

namespace app\models\shop;

use Yii;

/**
 * This is the model class for table "account_log".
 *
 */
class Product extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puttime', 'title', 'description', 'image'], 'safe'],
            [['cost', 'status'], 'required'],
            [['cost', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puttime' => 'Время добавления',
            'title' => 'title',
            'description' => 'description',
            'image' => 'image',
            'cost' => 'cost',
            'status' => 'status',
        ];
    }
}
