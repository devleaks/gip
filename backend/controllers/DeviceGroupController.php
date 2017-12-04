<?php

namespace backend\controllers;

use Yii;
use common\models\Device;
use common\models\DeviceGroup;
use common\models\search\DeviceGroup as DeviceGroupSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * DeviceGroupController implements the CRUD actions for DeviceGroup model.
 */
class DeviceGroupController extends ActiveController
{
    public $modelClass = 'common\models\DeviceGroup';
}