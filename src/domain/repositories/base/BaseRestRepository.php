<?php

namespace yii2tool\restclient\domain\repositories\base;

use yii2lab\domain\repositories\BaseRepository;
use yii2tool\restclient\domain\traits\RestTrait;

abstract class BaseRestRepository extends BaseRepository {

	use RestTrait;
	
}
