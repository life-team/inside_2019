<?php

namespace app\components;

use Yii;
use nord\yii\account\models\Account;

/**
 * @package components
 */
class Comet
{
	/**
	 * @var string
	 */
	public $queue = 'comet';
	
	/**
	 * @param mixed $data
	 * @param string $event
	 * @param array|string $rooms Строка, Массив строк и объектов UserBase
	 * @param integer $delay
	 * @return boolean
	 */
	public function send($data, $event, $rooms = null, $delay = null)
    {	
		$message = ['data' => $data, 'event' => $event];
		
		if ($rooms !== null) {
			$message['rooms'] = [];
			if (is_object($rooms) || is_array($rooms)) {
				$message['rooms'] = array_values($rooms);
			} elseif (is_string($rooms)) {
				$message['rooms'] = [$rooms];
			} else {
				return false;
			}
			
			foreach ($message['rooms'] AS &$room) {
				if (is_object($room) && ($room instanceof Account)) {
					$room = $this->generateRoomByUser($room) ? : 'user';
				}
			}
		}
		if ($delay) {
			$message['delay'] = $delay;
		}
		Yii::$app->queue->send($this->queue, $message);
		
		return true;
	}
	
	public function generateRoomByUser($user)
	{
		if ($user instanceof Account) {
			$params = [];
			$params[] = $user->id;
			$params[] = $user->authKey;
			$params[] = $user->createdAt;
			$hash = md5(implode(':', $params));
			return 'user' . substr($hash, 0, 24);
		}
		return false;
	}
}
