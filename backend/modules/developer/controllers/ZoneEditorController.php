<?php

namespace backend\modules\developer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ZoneEditor draw zones on a leaflet map and save them.
 */
class ZoneEditorController extends Controller
{
    /**
     * Lists all Attribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }


}
