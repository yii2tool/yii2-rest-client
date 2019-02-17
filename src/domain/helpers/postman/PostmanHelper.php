<?php

namespace yii2tool\restclient\domain\helpers\postman;

use yii\helpers\Json;
use yii\web\ServerErrorHttpException;
use yii2rails\extension\common\helpers\StringHelper;
use yii2rails\extension\yii\helpers\ArrayHelper;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\rest\domain\helpers\MiscHelper;
use yii2tool\restclient\domain\helpers\RouteHelper;

class PostmanHelper {
	
	const POSTMAN_VERSION = '2.1';
	
	public static function generateJson($apiVersion, $postmanVersion = self::POSTMAN_VERSION) {
		$collection = PostmanHelper::generate($apiVersion, $postmanVersion);
		$code = Json::encode($collection, JSON_PRETTY_PRINT);
		return $code;
	}
	
	public static function generate($apiVersion, $postmanVersion = self::POSTMAN_VERSION) {
		$all = RouteHelper::allFromRestClient($apiVersion);
		if($postmanVersion == self::POSTMAN_VERSION) {
			return PostmanHelper::genFromCollection($all, $apiVersion);
		}
		throw new ServerErrorHttpException("Postman version $postmanVersion not specified!");
	}
	
	private static function genFromCollection($groups, $apiVersion) {
		$groupCollection = [];
		foreach($groups as $groupName => $group) {
			/** @var requestEntity $requestEntity */
			$groupData = [
				'name' => $groupName,
				'description' => '',
			];
			$items = [];
			foreach($group as $name => $requestEntity) {
				$request = GeneratorHelper::genRequest($requestEntity);
				$items[] = [
					'name' => $requestEntity->uri . ($request['description'] ? " ({$request['description']})" : ''),
					'event' => GeneratorHelper::genEvent(),
					'request' => $request,
					'response' => [],
				];
			}
			$groupData['item'] = $items;
			$groupCollection[] = $groupData;
		}

        $initItems = [
            'name' => 'init',
            'description' => 'Initialize',
            'item' => InitHelper::genCollection(),
        ];

		$authItems = [
			'name' => 'auth by',
			'description' => '',
			'item' => AuthorizationHelper::genAuthCollection(),
		];

		$groupCollection = ArrayHelper::merge([$authItems], $groupCollection);
        $groupCollection = ArrayHelper::merge([$initItems], $groupCollection);
		
		return [
			'info' => [
				'_postman_id' => StringHelper::genUuid(),
				'name' => MiscHelper::collectionName($apiVersion),
				'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
			],
			'item' => $groupCollection,
		];
	}
	
}