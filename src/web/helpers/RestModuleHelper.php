<?php

namespace yii2tool\restclient\web\helpers;

use yii\helpers\ArrayHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\web\helpers\Behavior;
use yii2tool\restclient\domain\enums\RestPermissionEnum;
use yii2lab\rest\domain\helpers\MiscHelper;

class RestModuleHelper {
	
	public static function getConfig() {
		$config = [];
		$apiVersionList = MiscHelper::getAllVersions();
		foreach($apiVersionList as $version) {
			$config[ 'rest-' . $version ] = [
				'class' => 'yii2tool\restclient\web\Module',
				'baseUrl' => EnvService::getUrl('api', $version),
				'as access' => Behavior::access(RestPermissionEnum::CLIENT_ALL),
			];
		}
		return $config;
	}
	
	public static function appendConfig($config) {
		$restClientConfig = RestModuleHelper::getConfig();
		$config = ArrayHelper::merge($config, $restClientConfig);
		return $config;
	}
	
}