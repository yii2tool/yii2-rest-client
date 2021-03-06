<?php

namespace yii2tool\restclient\web\formatters;

use yii\base\InvalidArgumentException;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class JsonFormatter
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class JsonFormatter extends RawFormatter
{
    /**
     * @inheritdoc
     */
    public function format($record)
    {
        try {
            $data = Json::decode($record->content);
        } catch (InvalidArgumentException $e) {
            return $this->warn($e) . parent::format($record);
        }
        $content = Json::encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return Html::tag('pre',
            Html::tag('code',
                Html::encode($content),
                ['id' => 'response-content', 'class' => 'json']
            )
        );
    }
}