<?php

namespace yii2tool\restclient\web\assets\account;

use yii\web\AssetBundle;

class AccountAsset extends AssetBundle
{
    public $sourcePath = '@yii2tool/restclient/web/assets/account/dist';
    public $js = [
        'js/domain.js',
        'js/services/auth.js',
        'js/services/token.js',
    ];
	public $depends = [
		//'yii2tool\restclient\web\assets\rest\RestAsset',
        'yii2tool\restclient\web\assets\storage\StorageAsset',
	];
}
