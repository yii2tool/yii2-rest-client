<?php

namespace yii2tool\restclient\domain\repositories\ar;

use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;

class RestRepository extends BaseActiveArRepository {
	
	protected $modelClass = 'yii2tool\restclient\domain\models\Rest';
	
	public function uniqueFields() {
		return [
			['tag', 'module_id']
		];
	}
	
	public function allFavorite($apiVersion = null) {
		$query = $this->prepareQuery();
		if($apiVersion) {
			$query->where('module_id', "rest-v{$apiVersion}");
		}
		//$query->andWhere('favorited_at');
		$query->andWhere(['>', 'favorited_at', '0']);
		$collection = $this->all($query);
		return $this->forgeEntity($collection);
	}
	
	public function allHistory($apiVersion = null) {
		$query = $this->prepareQuery();
		if($apiVersion) {
			$query->where('module_id', "rest-v{$apiVersion}");
		}
		$query->andWhere(['favorited_at' => null]);
		$collection = $this->all($query);
		return $this->forgeEntity($collection);
	}
	
	public function clearHistory($moduleId) {
		$this->deleteAll([
			'module_id' => $moduleId,
			'favorited_at' => null
		]);
	}
	
}
