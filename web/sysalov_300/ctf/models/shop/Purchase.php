<?php

namespace app\models\shop;

use Yii;
use app\models\db\BaseModel;

/**
 * This is the model class for table "account_log".
 *
 */
class Purchase extends BaseModel
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puttime', 'flag'], 'safe'],
            [['product_id', 'account_id'], 'required'],
            [['product_id', 'account_id'], 'integer'],
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
            'product_id' => 'product_id',
            'account_id' => 'account_id'
        ];
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $this->updateUsersMoney($this->account_id);
	}
}
