<?php

namespace app\modules\app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\AppController;
use app\models\shop\Product;
use app\models\shop\Purchase;
use app\models\db\BaseModel;


/**
 * Default controller for the `app` module
 */
class ShopController extends AppController
{

	const flag = 'CTF{Sho@_Alchimic}';
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['get-product-items', 'init-user-money'],
						'allow' => true,
						'roles' => ['user'],
					],
					[
						'actions' => ['buy-product'],
						'allow' => true,
						'roles' => ['user'],
						'verbs' => ['POST']
					],
				],
			]
		];
	}


	/**
	 * @return string
	 */
	public function actionInitUserMoney()
	{
		(new BaseModel())->updateUsersMoney($this->user->id);
		return json_encode(['success' => true]);
	}
	/**
	 * @return string
	 */
	public function actionGetProductItems()
	{
		$items = Product::find()->where(['status' => Product::STATUS_ACTIVE])->asArray()->all();
		return json_encode(['success' => true, 'items' => $items]);
	}
	/**
	 * @return string
	 */
	public function actionBuyProduct()
	{
		$productId = Yii::$app->request->getBodyParam('id');

		$product = Product::find()->where(['id' => $productId])->one();
		if (empty($product)) {
			return json_encode(['success' => false, 'message' => 'Переданного товара не существует']);
		}
		$userMoney = BaseModel::getUserMoneyCount($this->user->id);

		if ($userMoney < $product->cost) {
			return json_encode(['success' => false, 'message' => 'У вас недостаточно средств']);
		}

		$outItem = '';
		if ($product->probability !== 0) {
			$outItem = $this->getFlag($product->probability);
		} else {
			$outItem = 'Успешная покупка, ваш товар уже в пути (нет)!';
		}

		$P = new Purchase();
		$P->product_id = $product->id;
		$P->account_id = $this->user->id;
		$P->flag = $outItem;
		if (!$P->save()) {
			return json_encode(['success' => false]);
		}

		return json_encode(['success' => true, 'item' => $outItem]);
	}


	private function getFlag($probability) {
		$flags = [];

		$probability *= 100; 
		$prFree = $probability;
		for ($i = $probability; $i<10000; $i++) {
			if (rand(0,1) === 1 && $prFree>0) {
				$flags[] = ['flag' => 'CTF{'.self::flag.'}', 'probability' => 1];
			}
			$flags[] = ['flag' => "Увы, сегодня вам не повезло, попробуйте повторить позже", 'probability' => 1];
		}

		for($a = 0; $a<$prFree;$a++) {
			$flags[] = ['flag' => 'CTF{'.self::flag.'}', 'probability' => 1];
		}

		$flagIndex = $this->getRandomIndex($flags);

		return $flags[$flagIndex]['flag'];
	}

	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	private function getRandomIndex($data, $column = 'probability') {
		$rand = mt_rand(1, array_sum(array_column($data, $column)));
		$cur = $prev = 0;
		for ($i = 0, $count = count($data); $i < $count; ++$i) {
		  $prev += $i != 0 ? $data[$i-1][$column] : 0;
		  $cur += $data[$i][$column];
		  if ($rand > $prev && $rand <= $cur) {
			return $i;
		  }
		}
		return -1;
	}
}
