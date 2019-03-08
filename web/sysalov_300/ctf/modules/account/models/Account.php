<?php

namespace app\modules\account\models;

use yii\web\IdentityInterface;

class Account extends \nord\yii\account\models\Account implements IdentityInterface
{
	/**
	 * 
	 */
	public $verifyPassword;
	
	/**
	 * @var array
	 */
	public $roles = [
		'user' => 'Пользователь',
		'testuser' => 'Тестировщик',
		'partner' => 'Партнёр',
		'admin' => 'Администратор',
	];
	
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['status'], 'integer', 'integerOnly' => true],
            [['password', 'authKey', 'email'], 'string', 'max' => 255],
			['password', 'compare','compareAttribute'=>'verifyPassword', 'on'=>'update'],
            [['email'], 'unique'],
            [['createdAt', 'lastLoginAt'], 'safe'],
        ];
    }
	
	/**
	 * @param string $token
	 * @param string $type
	 * @return Account
	 */
	public static function findIdentityByAccessToken($token, $type = null)
    {
		if (empty($token)) {
			return null;
		}
		
        return static::find()->andWhere(['access_token' => $token])->one();
    }
	
	/**
	 * @return string
	 */
	public function attributeLabels()
    {
		$labels = parent::attributeLabels();
		$labels['verifyPassword'] = 'Подтвердите пароль';
		
		return $labels;
    }
	
	/**
	 * @return string
	 */
	public function getRoleTitle($role = null)
    {
		if ($role === null) {
			$role = $this->role;
		} 
		
		if (isset($this->roles[$role])) {
			return $this->roles[$role];
		}
		
		return $role;
    }
	
	/**
     * @return string
     */
    public function getTelegramKey()
    {
		return 'tcode:' . $this->id . ':' 
			. md5(
				$this->id . ':' . 
				$this->username . ':' . 
				$this->email . ':' . 
				$this->authKey . ':' . 
				$this->password
			);
    }
}