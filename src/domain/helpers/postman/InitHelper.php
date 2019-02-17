<?php

namespace yii2tool\restclient\domain\helpers\postman;

use Yii;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2module\account\domain\v2\entities\TestEntity;

class InitHelper {

    public static function genCollection() {
        $items = [
            [
                'name' => 'init variables',
                'event' => [
                    [
                        'listen' => 'test',
                        'script' => [
                            'id' => '2c924f5b-ab54-40e2-a821-23545d57583a',
                            'type' => 'text/javascript',
                            'exec' => [
                                'pm.globals.set("' . GeneratorHelper::genPureVariable('timezone') . '", "Asia/Almaty");',
                                'pm.globals.set("' . GeneratorHelper::genPureVariable('language') . '", "ru");',
                            ],
                        ],
                    ],
                ],
                'request' => [
                    'method' => 'GET',
                    'header' => [],
                    'body' => [],
                    'url' => [
                        'raw' => 'http://google.com/',
                        'host' => [
                            'http://google.com/',
                        ],
                        'path' => [],
                    ],
                    'description' => 'init variables',
                ],
                'response' => [],
            ],
        ];
        return $items;
    }

}