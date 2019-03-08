<?php

namespace app\models\db;

use Yii;

/**
 * @inheritdoc
 */
class ActiveRecordUndeletable extends \yii\db\ActiveRecord
{	
	/**
     * @inheritdoc
     */
    public static function deleteAll($condition = null, $params = [])
    {
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), ['not_deleted' => ActiveQueryUndeletable::DELETED], $condition, $params);

        return $command->execute();
    }
	
	/**
     * @inheritdoc
     */
	public static function find()
    {
       return Yii::createObject(ActiveQueryUndeletable::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     * @return static ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return static::findByCondition($condition)->one();
    }

    /**
     * @inheritdoc
     * @return static[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return static::findByCondition($condition)->all();
    }
	
    /**
     * @inheritdoc
     * @return ActiveQueryInterface the newly created [[ActiveQueryInterface|ActiveQuery]] instance.
     */	
	protected static function findByCondition($condition)
	{
		$query = parent::findByCondition($condition);
		return $query->andWhere(['`not_deleted`' => ActiveQueryUndeletable::NOT_DELETED]);
	}

}
