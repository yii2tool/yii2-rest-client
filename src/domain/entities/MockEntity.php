<?php

namespace yii2tool\restclient\domain\entities;

use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\rest\domain\entities\ResponseEntity;
use yii2rails\domain\BaseEntity;
use yii2rails\extension\web\enums\HttpMethodEnum;

/**
 * Class RequestEntity
 * @package yii2rails\domain\entities
 *
 * @property RequestEntity $request
 * @property ResponseEntity $response
 */
class MockEntity extends BaseEntity {

	protected $request;
    protected $response;

    public function fieldType() {
        return [
            'request' => [
                'type' => RequestEntity::class,
            ],
            'response' => [
                'type' => ResponseEntity::class,
            ],
        ];
    }
}