<?php

namespace backend\modules\viewer\controllers;

use Yii;
use common\models\Tool;
use common\models\ToolGroup;
use common\models\search\ToolGroup as ToolGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Html;
use yii\filters\VerbFilter;

/**
 * ToolGroupController implements the CRUD actions for ToolGroup model.
 */
class ToolGroupController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ToolGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ToolGroupSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new ToolGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ToolGroup;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ToolGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ToolGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ToolGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ToolGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ToolGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 * Functions to add/remove from Tool Group
	 */
	
	/**
	 * Build groups of items inside or outside of group supplied
	 */
	private function getGroups($group) {
		$outgroup = [];
		foreach(Tool::find()->each() as $item) {
			$outgroup[$item->id] = $item->name;
		}

        $ingroup = [];
        foreach ($group->getTools()->each() as $item) {
            $ingroup[$item->id] = $item->name;
            unset($outgroup[$item->id]);
        }
		return [$ingroup, $outgroup];
	}

    /**
     * Displays a single ToolGroup model and its Tools.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			list($ingroup, $outgroup) = $this->getGroups($model);
	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        } else {
			list($ingroup, $outgroup) = $this->getGroups($model);
	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        }
    }

    private function doAction($group_id, $action)
    {
        $post = Yii::$app->request->post();
        $tools = $post['items'];
		$group = $this->findModel($group_id);
        $error = [];

        foreach ($tools as $tool_id) {
			$tool = Tool::findOne($tool_id);
            try {
				if($action === 'add') {
					$group->add($tool);
				} else {
					$group->remove($tool);
				}
            } catch (\Exception $exc) {
                $error[] = $exc->getMessage();
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [$this->actionItemSearch($group_id, 'outgroup',  $post['search_outgroup']),
                $this->actionItemSearch($group_id, 'ingroup', $post['search_ingroup']),
                $error];
    }

    public function actionAdd($group_id)
    {
        return $this->doAction($group_id, 'add');
    }

    public function actionRemove($group_id)
    {
        return $this->doAction($group_id, 'remove');
    }

    public function actionItemSearch($id, $target, $term = '')
    {
		$model = $this->findModel($id);
		list($ingroup, $outgroup) = $this->getGroups($model);
        $result = [];
        if (!empty($term)) {
            foreach (${$target} as $tool) {
                if (strpos($tool, $term) !== false) {
					$model = Tool::findOne(['name' => $tool]);
                    $result[$model->id] = $tool;
                }
            }
        } else {
            $result = ${$target};
        }
        return Html::renderSelectOptions('', $result);
    }


}
