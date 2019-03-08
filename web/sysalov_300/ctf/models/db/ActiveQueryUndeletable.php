<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\models\db;

use yii\db\ActiveQuery;

/**
 * @inheritdoc
 */
class ActiveQueryUndeletable extends ActiveQuery
{
	const DELETED = NULL;
	const NOT_DELETED = 1;
	
	/**
     * @inheritdoc
     */
    public function where($condition, $params = [])
    {
        $this->where = $condition;
		$this->andWhere(['`not_deleted`' => self::NOT_DELETED]);
        $this->addParams($params);
        return $this;
    }
}
