<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\models\db;

use Yii;
/**
 * @inheritdoc
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public function updateUsersMoney ($userId) {
		Yii::$app->comet->send(
			['item' => $this->getUserMoneyCount($userId)],
			'money_count', 
			'usermoney:' . $userId
		);
    }
    
    public static function getUserMoneyCount($userId) {

		$sqlSpent = <<<SQL
SELECT SUM(PR.cost) as sumcost FROM purchase PU
JOIN product PR ON PU.product_id = PR.id
WHERE PU.account_id = :USERID
SQL;

		$sqlEarned = <<<SQL
SELECT COUNT(*) as `count` FROM referral_account RA WHERE status = 1 AND account_id = :USERID
SQL;
		$spent = Yii::$app->getDb()->createCommand($sqlSpent, [':USERID' => $userId])->queryAll();
		$earned = Yii::$app->getDb()->createCommand($sqlEarned, [':USERID' => $userId])->queryAll();
		if (empty($spent) || empty($earned)) return false;
		$spent = (empty($spent[0]['sumcost'])) ? 0 : $spent[0]['sumcost'];
		$earned = (empty($earned[0]['count'])) ? 0 : $earned[0]['count'];
		$res = $earned - $spent;
		$res = ($res < 0) ? 0 : $res;
		return $res;
	}

}
