<?php

namespace yii2tool\restclient\web\assets\rest;

use yii\web\AssetBundle;

class RestAsset extends AssetBundle
{
    public $sourcePath = '@yii2tool/restclient/web/assets/rest/dist';
    public $js = [
        'js/domain.js',
        'js/services/http.js',
        'js/services/request.js',
        'js/services/router.js',
    ];
	public $depends = [
		'yii2lab\applicationTemplate\common\assets\main\MainAsset',
        'yii2tool\restclient\web\assets\account\AccountAsset',
	];
}
