<?php

namespace yii2tool\restclient\domain;

use yii2lab\domain\enums\Driver;
use yii2tool\restclient\domain\services\MockService;
use yii2tool\restclient\domain\services\RestService;

/**
 * Class Domain
 * 
 * @package yii2tool\restclient\domain
 * @property RestService $rest
 * @property MockService $mock
 * @property-read \yii2tool\restclient\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'rest' => Driver::ACTIVE_RECORD,
				'client' => Driver::REST,
			],
			'services' => [
				'rest',
				'client',
                'mock',
			],
		];
	}
	
}