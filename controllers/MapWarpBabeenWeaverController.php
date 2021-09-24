<?php

namespace app\controllers;

use Yii;
use app\models\MapWarpBabeenWeaver;
use app\models\MapWarpBabeenWeaverSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\MapWarpWeaver;

/**
 * MapWarpBabeenWeaverController implements the CRUD actions for MapWarpBabeenWeaver model.
 */
class MapWarpBabeenWeaverController extends BaseController
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
     * Lists all MapWarpBabeenWeaver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapWarpBabeenWeaverSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MapWarpBabeenWeaver model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $data = MapWarpBabeenWeaver::find()->where(['id' => $id])->asArray()->one();
        if (!empty($data)) {
            if (!empty($data['date'])) {
                $data['date'] = date('d-m-Y', $data['date']);
            }
            if (!empty($data['status'])) {
                $data['foreign_value_status'] = MapWarpBabeenWeaver::getWarpStatusList()[$data['status']];
            }
            if (
                !empty($data['warp_weaver_id']) 
                && !empty($warpWeaver = MapWarpWeaver::getWarpWeaverList(null, null, $data['warp_weaver_id']))
            ) {
                $data['foreign_value_warp_weaver_id'] = $warpWeaver[0]['name'];
            }
        }

        return json_encode(
            [
                'data' => $data,
                'displayFields' => [
                    'date', 'name', 'warp_weaver_id', 'left_babeen_yelai', 'left_babeen_length',
                    'right_babeen_yelai', 'right_babeen_length', 'status'
                ],
                'label' => (new MapWarpBabeenWeaver)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new MapWarpBabeenWeaver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $model = new MapWarpBabeenWeaver();
        try{
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    $transaction->commit();
                    return json_encode(['id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
            $transaction->rollBack();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MapWarpBabeenWeaver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $transaction = Yii::$app->db->beginTransaction();
        $model = $this->findModel($id);
        try{
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    $transaction->commit();
                    return json_encode(['id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
            $transaction->rollBack();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MapWarpBabeenWeaver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $isDeleted = $this->findModel($id)->delete();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $isDeleted;
    }

    /**
     * Finds the MapWarpBabeenWeaver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MapWarpBabeenWeaver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MapWarpBabeenWeaver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
