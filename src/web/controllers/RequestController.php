<?php

namespace yii2tool\restclient\web\controllers;

use Yii;
use yii\web\Controller;
use yii2lab\extension\yii\helpers\ArrayHelper;
use yii2tool\restclient\domain\entities\RestEntity;
use yii2tool\restclient\web\helpers\CollectionHelper;
use yii2tool\restclient\web\helpers\RestHelper;
use yii2tool\restclient\web\models\RequestForm;
use yii2tool\restclient\web\models\ResponseRecord;

/**
 * Class RequestController
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class RequestController extends Controller
{
    /**
     * @var \yii2tool\restclient\web\Module
     */
    public $module;
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';

    public function actionCreate($tag = null)
    {
        /** @var RequestForm $model */
        $model = Yii::createObject(RequestForm::class);
	    $record = new ResponseRecord();
        if($tag !== null) {
	        /** @var RestEntity $restEntity */
	        $restEntity = \App::$domain->rest->rest->oneByTag($tag);
	        $model->setAttributes($restEntity->request);
        } elseif(Yii::$app->request->isPost) {
	        $model->load(Yii::$app->request->post());
	        if($model->validate()) {
		        $record = RestHelper::sendRequest($model);
		        $data = [
			        'module_id' => $this->module->id,
			        'request' => $model->toArray(),
		        ];
		        $restEntity = \App::$domain->rest->rest->createOrUpdate($data);
		        $tag = $restEntity->tag;
	        }
        }
	
	    $model->addEmptyRows();
	    $history = \App::$domain->rest->rest->allHistory();
        $collection = \App::$domain->rest->rest->allFavorite();
	
	    $history = ArrayHelper::index($history, 'tag');
	    $collection = ArrayHelper::index($collection, 'tag');
	
	    $collection = CollectionHelper::prependCollection($collection);
	
	    $frame = null;
	    $contentDisposition = ArrayHelper::getValue($record->headers,  'Content-Disposition');
	    if($contentDisposition != null) {
	    	$ee = explode(';', $contentDisposition[0]);
	    	if($ee[0] == 'attachment') {
			    Yii::$app->response->headers->fromArray($record->headers);
			    return $record->content;
		    } /*elseif($ee[0] == 'inline') {
			    $requestEntity = AdapterHelper::createRequestEntityFromForm($model);
			    $requestEntity->headers['Authorization'] = ;
			    //prr($requestEntity,1,1);
			    $frame = $this->module->baseUrl . SL . $requestEntity->uri;
		    }*/
	    }
        return $this->render('create', [
            'tag' => $tag,
            'baseUrl' => rtrim($this->module->baseUrl, '/') . '/',
            'model' => $model,
            'record' => $record,
	        'frame' => $frame,
            'history' => $history,
            'collection' => $collection,
        ]);
    }

}