<?php

namespace app\models\referral;

use Yii;
use app\models\db\BaseModel;

/**
 * This is the model class for table "account_log".
 *
 */
class ReferralAccount extends BaseModel
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referral_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puttime'], 'safe'],
            [['account_id', 'referral_account_id'], 'required'],
            [['account_id', 'referral_account_id'], 'integer'],
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
            'account_id' => 'Пользователь',
            'referral_account_id' => 'Реферальный пользователь',
        ];
    }

    public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);
        $this->updateUsersMoney($this->account_id);
	}
}
