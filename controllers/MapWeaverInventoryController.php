<?php

namespace app\controllers;

use Yii;
use app\models\MapWeaverInventory;
use app\models\MapWeaverInventorySearch;
use app\controllers\BaseController;
use app\models\InventoryType;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MapWeaverInventoryController implements the CRUD actions for MapWeaverInventory model.
 */
class MapWeaverInventoryController extends BaseController
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
     * Lists all MapWeaverInventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapWeaverInventorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MapWeaverInventory model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return json_encode(
            [
                'data' => MapWeaverInventory::find()->where(['id' => $id])->asArray()->one(),
                'label' => (new MapWeaverInventory)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new MapWeaverInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MapWeaverInventory();

        $transaction = Yii::$app->db->beginTransaction();
        try{
            if ($this->request->isPost) {
                $postData = $this->request->post(); $basicLoadArray = $finalArray = $temp = [];

                $basicFields = ['user_id', 'date', 'warp_weaver_id', 'status', 'amount'];
                foreach ($basicFields as $value) {
                    $basicLoadArray[$value] = $postData['MapWeaverInventory'][$value];
                }
                $basicLoadArray['quantity'] = 1;
                if (!empty($postData['MapWeaverInventory']['yelai']['left'])
                    && !empty($postData['MapWeaverInventory']['length']['left'])) {
                        $temp['MapWeaverInventory'] = $basicLoadArray;
                        $temp['MapWeaverInventory']['inventory_type_id'] = InventoryType::$leftBabeen;
                        $temp['MapWeaverInventory']['yelai'] = $postData['MapWeaverInventory']['yelai']['left'];
                        $temp['MapWeaverInventory']['length'] = $postData['MapWeaverInventory']['length']['left'];

                        $finalArray[] = $temp;
                }
                if (!empty($postData['MapWeaverInventory']['yelai']['right'])
                    && !empty($postData['MapWeaverInventory']['length']['right'])) {
                        $temp['MapWeaverInventory'] = $basicLoadArray;
                        $temp['MapWeaverInventory']['inventory_type_id'] = InventoryType::$rightBabeen;
                        $temp['MapWeaverInventory']['yelai'] = $postData['MapWeaverInventory']['yelai']['right'];
                        $temp['MapWeaverInventory']['length'] = $postData['MapWeaverInventory']['length']['right'];

                        $finalArray[] = $temp;
                }
                foreach ($finalArray as $eachBabeen) {
                    if (!$model->load($eachBabeen) || !$model->save()) {
                        throw new \Exception(Yii::t('app', 'Error in saving babeen'));
                    }
                }
                $transaction->commit();
                return json_encode(['id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
            $transaction->rollBack();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        
        var_dump($model->getErrors()); exit;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MapWeaverInventory model.
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
     * Deletes an existing MapWeaverInventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MapWeaverInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MapWeaverInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MapWeaverInventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
