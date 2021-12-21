<?php

namespace app\controllers;

use Yii;
use app\models\MapWarpWeaver;
use app\models\MapWarpWeaverSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\MapWarpWeaverInventory;
use app\models\MapWeaverLoom;
use yii\helpers\ArrayHelper;

/**
 * MapWarpWeaverController implements the CRUD actions for MapWarpWeaver model.
 */
class MapWarpWeaverController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MapWarpWeaver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapWarpWeaverSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MapWarpWeaver model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $data = MapWarpWeaver::find()->where(['id' => $id])->asArray()->one();
        if (!empty($data)) {
            if (!empty($data['date'])) {
                $data['date'] = date('d-m-Y', $data['date']);
            }
            if (
                !empty($data['weaver_loom_id'])
                && !empty($weaverLoomData = MapWeaverLoom::getWeaverLoomList($data['weaver_loom_id']))
            ) {
                $data['foreign_value_weaver_loom_id'] = $weaverLoomData[0]['name'];
            }
            if (!empty($data['saree_type_id'])) {
                $data['foreign_value_saree_type_id'] = MapWarpWeaver::findOne($id)->sareeType->name;
            }
            if (!empty($data['status'])) {
                $data['foreign_value_status'] = MapWarpWeaver::getWarpStatusList()[$data['status']];
            }
        }
        return json_encode(
            [
                'data' => $data,
                'displayFields' => [
                    'date', 'name', 'weaver_loom_id', 'saree_type_id', 'left_pettu_yelai',
                    'body_yelai', 'right_pettu_yelai', 'minimum_sarees', 'warp_roller_name', 'status'
                ],
                'label' => (new MapWarpWeaver)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new MapWarpWeaver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MapWarpWeaver();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return json_encode(['id' => $model->id]);
            }
            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MapWarpWeaver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return json_encode(['id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MapWarpWeaver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $isDeleted = $this->findModel($id)->delete();

        return $isDeleted;
    }

    /**
     * Finds the MapWarpWeaver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MapWarpWeaver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MapWarpWeaver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionPaymentCapture()
    {
        if ($this->request->isPost) {
            $postData = $this->request->post(); $warpRecords = null;
            if (!empty($postData['warpRecords'])) {
                $warpRecords = MapWarpWeaver::find()->where(['in', 'id', $postData['warpRecords']])->all();
            }
            return $this->renderAjax('/mapwarpweaver/warp_payment_records', [
                'warpRecords' => $warpRecords
            ]);
        }
    }

    public function actionMovableWarpList($currentWarpWeaverId)
    {
        $response = ['movableWarpList' => [], 'movableInventoryDetails' => []];
        $model = $this->findModel($currentWarpWeaverId);
        $tempMovableWarpList = MapWarpWeaver::find()->where(
            ['weaver_loom_id' => $model->weaver_loom_id]
        )->andWhere(['!=', 'status', MapWarpWeaver::WARP_FINISHED_STATUS])->andWhere(['!=', 'id', $currentWarpWeaverId])->asArray()->all();

        $mapWarpWeaverInventory = new MapWarpWeaverInventory;
        $remainingInventoryDetails = $mapWarpWeaverInventory->getWarpWeaverInventoryData($currentWarpWeaverId);
        $response['movableWarpList'][] = ['id' => '', 'text' => Yii::t('app', 'Select Warp')];
        if ($tempMovableWarpList) {
            foreach ($tempMovableWarpList as $eachWarp){
                $response['movableWarpList'][] = ['id' => $eachWarp['id'], 'text' => $eachWarp['name']];
            }
        }

        if ($remainingInventoryDetails) {
            $temp = $remainingInventoryDetails['manipulated_business_data']['sareeCountCalculation'];
            $response['movableInventoryDetails']['moving_given_yarn_weight'] = $temp['needed_yarn_weight'] < 0 ? -(number_format($temp['needed_yarn_weight'], 3, '.', '')) : 0;
            $response['movableInventoryDetails']['moving_given_jarigai_weight'] = $temp['needed_jarigai_weight'] < 0 ? -(number_format($temp['needed_jarigai_weight'], 3, '.', '')) : 0;
            $response['movableInventoryDetails']['moving_given_babeen_meter'] = $temp['needed_babeen_meter'] < 0 ? -(number_format($temp['needed_babeen_meter'], 3, '.', '')) : 0;
            $response['movableInventoryDetails']['moving_given_amount'] = $temp['total_weaver_advance_fee_inhand'] > 0 ? $temp['total_weaver_advance_fee_inhand'] : 0;
            $response['movableInventoryDetails']['moving_given_jarigai_quantity'] = $temp['needed_jarigai_quantity_to_return'];
        }

        return json_encode($response);
    }

    public function actionGetWeaverLoomWarp($weaverLoomId)
    {
        $finalList = [["id" => "", "text" => Yii::t('app', 'Select Weaver Warp')]];
        $warpWeaverList = MapWarpWeaver::getWarpWeaverList(null, $weaverLoomId);
        foreach ($warpWeaverList as $index => $value) {
            if ($value['status'] == MapWarpWeaver::WARP_FINISHED_STATUS) {
                $value['text'] = $value['name'];
                $finalList[] = $value;
            }
        }

        return json_encode($finalList);
    }
}
