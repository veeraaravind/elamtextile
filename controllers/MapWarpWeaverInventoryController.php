<?php

namespace app\controllers;

use Yii;
use app\models\MapWarpWeaverInventory;
use app\models\MapWarpWeaverInventorySearch;
use app\controllers\BaseController;
use app\models\Company;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Exception;
use app\models\MapWarpWeaver;
use app\models\MapWarpBabeenWeaver;
use app\models\SubWarpBabeenWeaver;
use kartik\mpdf\Pdf;

/**
 * MapWarpWeaverInventoryController implements the CRUD actions for MapWarpWeaverInventory model.
 */
class MapWarpWeaverInventoryController extends BaseController
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
     * Lists all MapWarpWeaverInventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapWarpWeaverInventorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MapWarpWeaverInventory model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $data = MapWarpWeaverInventory::find()->where(['id' => $id])->asArray()->one();
        if (!empty($data['date'])) {
            $data['date'] = date('d-m-Y', $data['date']);
        }
        if (!empty($data['payment_mode'])) {
            $data['foreign_value_payment_mode'] = MapWarpWeaverInventory::getPaymentMode()[$data['payment_mode']];
        }
        if (
            !empty($data['from_warp_weaver_id']) 
            && !empty($warpWeaver = MapWarpWeaver::getWarpWeaverList($data['warp_weaver_id']))
        ) {
            $data['foreign_value_from_warp_weaver_id'] = $warpWeaver[0]['name'];
        }
        return json_encode(
            [
                'data' => $data,
                'displayFields' => [
                    'date', 'from_warp_weaver_id', 'given_jarigai_quantity', 'given_jarigai_weight',
                    'return_jarigai_quantity', 'return_jarigai_weight', 'given_yarn_weight',
                    'return_yarn_weight', 'produced_sarees', 'production_return_sarees', 
                    'actual_amount', 'given_amount', 'given_net_transfer_amount', 'mistake_amount', 
                    'payment_mode'
                ],
                'label' => (new MapWarpWeaverInventory)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new MapWarpWeaverInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MapWarpWeaverInventory();

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
     * Updates an existing MapWarpWeaverInventory model.
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
     * Deletes an existing MapWarpWeaverInventory model.
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
     * Finds the MapWarpWeaverInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MapWarpWeaverInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MapWarpWeaverInventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionMoveWarpWeaverInventory($currentWarpWeaverId)
    {
        $transaction  = Yii::$app->db->beginTransaction();
        try {
            if ($this->request->isPost) {
                $postData = $this->request->post();
                if (isset($postData['MapWarpWeaver']['status'])) {
                    $mapWarpWeaver = MapWarpWeaver::findOne($currentWarpWeaverId);
                    $mapWarpWeaver->status = $postData['MapWarpWeaver']['status'];
                    if ($mapWarpWeaver->save()) {
                        if ($mapWarpWeaver->status == 6 && isset($postData['MapWarpWeaverInventory'])) {
                            $mapWarpWeaverInventory = new MapWarpWeaverInventory;
                            $tempArray['MapWarpWeaverInventory'] = [
                                'from_warp_weaver_id' => $currentWarpWeaverId, 
                                'date' => date('d-m-Y')
                            ];
                            foreach ($postData['MapWarpWeaverInventory'] as $key => $value) {
                                $tempArray['MapWarpWeaverInventory'][str_replace('moving_', '', $key)] = $value;
                            }
                            $babeenMeter = $tempArray['MapWarpWeaverInventory']['given_babeen_meter'];
                            unset($tempArray['MapWarpWeaverInventory']['given_babeen_meter']);
                            if (!$mapWarpWeaverInventory->load($tempArray) || !$mapWarpWeaverInventory->save()) {
                                throw new Exception($mapWarpWeaverInventory->getErrors());
                            }
                            if ($babeenMeter > 0) {
                                $mapWarpBabeenWeaver = new MapWarpBabeenWeaver;
                                $warpBabeenList = $mapWarpBabeenWeaver->getwarpBabeenDetails($currentWarpWeaverId);
                                $babeenUpdateDetails = $newWarpBabeenDetails = [];
                                for ($i = (count($warpBabeenList)-1); $i >= 0; $i--) {
                                    $consolidatedBabeenMeter = $warpBabeenList[$i]['consolidated_given_babeen_length'];
                                    if (($babeenMeter-$consolidatedBabeenMeter) > 0) {
                                        $babeenUpdateDetails[] = [
                                            'id' => $warpBabeenList[$i]['sub_warp_babeen_weaver_id'],
                                            'utilized_babeen_length' => 0
                                        ];
                                        $newWarpBabeenDetails[] = [
                                            'given_babeen_length' => $consolidatedBabeenMeter,
                                            'warp_babeen_weaver_id' => $warpBabeenList[$i]['id'],
                                            'warp_weaver_id' => $tempArray['MapWarpWeaverInventory']['warp_weaver_id'],
                                            'from_warp_weaver_id' => $currentWarpWeaverId
                                        ];
                                        $babeenMeter = $babeenMeter-$consolidatedBabeenMeter;
                                        
                                    } elseif (($babeenMeter-$consolidatedBabeenMeter) <= 0) {
                                        $babeenUpdateDetails[] = [
                                            'id' => $warpBabeenList[$i]['sub_warp_babeen_weaver_id'],
                                            'utilized_babeen_length' => $consolidatedBabeenMeter-$babeenMeter
                                        ];
                                        $newWarpBabeenDetails[] = [
                                            'given_babeen_length' => $babeenMeter,
                                            'warp_babeen_weaver_id' => $warpBabeenList[$i]['id'],
                                            'warp_weaver_id' => $tempArray['MapWarpWeaverInventory']['warp_weaver_id'],
                                            'from_warp_weaver_id' => $currentWarpWeaverId
                                        ];
                                        $babeenMeter = 0;
                                    }
                                }
                                foreach ($babeenUpdateDetails as $eachBabeen) {
                                    $model = SubWarpBabeenWeaver::findOne($eachBabeen['id']);
                                    if (!$model) {
                                        throw new \Exception(Yii::t('app', 'Error in babeen update1.'));
                                    }
                                    $model->utilized_babeen_length = $eachBabeen['utilized_babeen_length'];
                                    if (!$model->save()) {
                                        throw new \Exception(json_encode($model->getErrors()));
                                    }
                                }
                                foreach ($newWarpBabeenDetails as $eachBabeen) {
                                    $model = new SubWarpBabeenWeaver;
                                    if (!$model->load(['SubWarpBabeenWeaver' => $eachBabeen]) || !$model->save()) {
                                        throw new \Exception(Yii::t('app', 'Error in babeen update3.'));
                                    }
                                }
                            }
                        } else {
                            $inventoryDeleted = MapWarpWeaverInventory::deleteAll(['from_warp_weaver_id' => $currentWarpWeaverId]);
                            $babeenDeleted = SubWarpBabeenWeaver::deleteAll(['from_warp_weaver_id' => $currentWarpWeaverId]);
                        }
                    } else {
                        throw new Exception(Yii::t('app', 'Error in changing status'));
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionPrintInventoryRecord($id)
    {
        $company = Company::find()->asArray()->one();
        $mapWarpWeaverInventoryData = (new MapWarpWeaverInventorySearch)->getWarpWeaverInventoryData($id);
        $content = $this->renderPartial(
            '/mapwarpweaverinventory/weaver_inventory_details',
            [
                'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData,
                'company' => $company
            ]
        );
        $pdf = Yii::$app->pdf;
        $pdf->content = $content;
        return $pdf->render();
    }
}
