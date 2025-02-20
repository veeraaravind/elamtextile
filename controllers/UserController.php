<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserType;
use app\models\Bank;
use app\models\UserSearch;
use app\models\MapWarpWeaverSearch;
use app\controllers\BaseController;
use app\models\MapWarpWeaver;
use app\models\SareeType;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\MapWeaverLoom;
use app\models\MapWarpBabeenWeaverSearch;
use app\models\MapWarpWeaverInventorySearch;
use app\models\MapWarpWeaverInventory;
use app\models\Colour;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = $this->request->queryParams;
        if (isset($queryParams['UserSearch']['user_type_id']) === false) {
            return $this->goHome();
        }
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($queryParams);
        $bankList = Bank::find()->where(['status' => 1])->all();
        $sareeTypeList = ArrayHelper::map(SareeType::find()->all(), 'id', 'name');
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bankList' => $bankList,
            'sareeTypeList' => $sareeTypeList,
            'urlParam' => $queryParams
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return json_encode(
            [
                'data' => User::find()->where(['id' => $id])->asArray()->one(),
                'loomData' => MapWeaverLoom::find()->where(['weaver_id' => $id])->asArray()->all(),
                'label' => (new User)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $transaction = Yii::$app->db->beginTransaction();
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    $transaction->commit();
                    return json_encode(['id' => $model->id]);
                }
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $isDeleted = $this->findModel($id)->delete();

        return $isDeleted;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDetailedView($id)
    {
        $queryParams = $this->request->queryParams;
        $model = $this->findModel($id);

        $bankList = Bank::find()->where(['status' => 1])->all();
        $sareeTypeList = ArrayHelper::map(SareeType::find()->asArray()->all(), 'id', 'name');
        if (UserType::$weaver == $model->user_type_id) {
            $warpWeaverList = MapWarpWeaver::getWarpWeaverList($id);
            $babeenProviderList = ArrayHelper::map(
                User::find()->where(['user_type_id' => UserType::$babeenProvider])->asArray()->all(),
                'id',
                'name'
            );
            $finalWarpWeaverList = [];
            foreach ($warpWeaverList as $value) {
                if ($value['status'] != MapWarpWeaver::WARP_FINISHED_STATUS) {
                    $finalWarpWeaverList[$value['id']] = $value['name'];
                }
            }
            $mapWarpWeaverInventoryData = (new MapWarpWeaverInventorySearch)->getWarpWeaverInventoryData(0);
            
            return $this->render(
                'weaver_detailed_view',
                [
                    'model' => $model,
                    'warpWeaverList' => $finalWarpWeaverList,
                    'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData,
                    'bankList' => $bankList,
                    'sareeTypeList' => $sareeTypeList,
                    'babeenProviderList' => $babeenProviderList,
                    'initialValue' => Yii::t('app', 'Select Babeen Provider')
                ]
            );
        } elseif (UserType::$warpProvider == $model->user_type_id) {
            $queryParams['MapWarpWeaverSearch']['warp_provider_id'] = $id;
            $searchModel = new MapWarpWeaverSearch();
            $dataProvider = $searchModel->search($queryParams);
            $weaverList = ArrayHelper::map(
                MapWeaverLoom::getWeaverLoomList(),
                'id',
                'name'
            );

            $colourListArray = Colour::find()->where(['status' => 1])->asArray()->all();
            $colourList = [
                [
                    'id' => '-1', 
                    'text' => sprintf('<div>%s</div>',Yii::t('app', 'Select Colour')),
                    'html' => sprintf('<div>%s</div>',Yii::t('app', 'Select Colour'))
                ]
            ];
            foreach ($colourListArray as $value) {
                $tempOption = sprintf(
                    '<div class="palette-input-color">
                        <span>%s</span>
                        <div class="color-box" style="background-color: %s;"></div>
                    </div>',
                    $value['name'],
                    $value['code']
                );
                $colourList[] = [
                    'id' => $value['name'],
                    'text' => $tempOption,
                    'html' => $tempOption,
                ];
            }
            
            
            return $this->render(
                'warp_provider_view',
                [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'weaverList' => $weaverList,
                    'bankList' => $bankList,
                    'sareeTypeList' => $sareeTypeList,
                    'colourList' => $colourList
                ]
            );
        } elseif (UserType::$babeenProvider == $model->user_type_id) {
            $queryParams['MapWarpBabeenWeaverSearch']['babeen_provider_id'] = $id;
            $searchModel = new MapWarpBabeenWeaverSearch();
            $dataProvider = $searchModel->search($queryParams);
            $babeenProviderList = ArrayHelper::map(
                User::find()->where(['user_type_id' => UserType::$babeenProvider])->asArray()->all(),
                'id',
                'name'
            );

            $finalWarpWeaverList = [];
            $warpWeaverList = MapWarpWeaver::getWarpWeaverList();
            foreach ($warpWeaverList as $value) {
                if ($value['status'] != MapWarpWeaver::WARP_FINISHED_STATUS) {
                    $finalWarpWeaverList[$value['id']] = $value['name'];
                }
            }
            
            return $this->render(
                'babeen_provider_view',
                [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'warpWeaverList' => $finalWarpWeaverList,
                    'bankList' => $bankList,
                    'sareeTypeList' => $sareeTypeList,
                    'babeenProviderList' => $babeenProviderList,
                    'initialValue' => $id
                ]
            );
        }
    }

    public function actionUserDetailsView($id) {
        $model = $this->findModel($id);
        return $this->renderAjax('user_details_view', ['model' => $model]);
    }

    public function actionWarpDetails($warp_weaver_id) {

        $mapWarpWeaverInventoryData = (new MapWarpWeaverInventorySearch)->getWarpWeaverInventoryData($warp_weaver_id);

        return $this->renderAjax(
            'warp_weaver_inventory_grid',
            [
                "mapWarpWeaverInventoryData" => $mapWarpWeaverInventoryData
            ]
        );
    }

    public function actionFinishedWarpReport($warp_weaver_id = 0)
    {
        $mapWarpWeaverInventoryModel = new MapWarpWeaverInventory;
        $mapWarpWeaverInventoryData = $mapWarpWeaverInventoryModel->getWarpWeaverInventoryData($warp_weaver_id);
        $weaverLoomList = ArrayHelper::map(
            MapWeaverLoom::getWeaverLoomList(),
            'id',
            'name'
        );
        
        return $this->render(
            'finished_warp_report',
            [
                'weaverLoomList' => $weaverLoomList,
                'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData,
                'warpStatusList' => $mapWarpWeaverInventoryModel->getWarpStatusList()
            ]
        );
    }

    public function actionWeaverAmountReport($weaver_id = 0)
    {
        if ($this->request->isPost) {
            $weaverId = $_POST['weaver_id'];
            $startTime = strtotime(sprintf('%s 00:00:00', $_POST['start_date']));
            $endTime = strtotime(sprintf('%s 23:59:59', $_POST['end_date']));

            $sql = 'SELECT
                    wwi.*,
                    concat(
                        u.name, 
                        "[ ", wl.loom_name, " ]",
                        "[ ", ww.name, " ]",
                        "[ ", st.name, " ]"
                    ) as "weaver_name"
                FROM
                    map_warp_weaver_inventory as wwi
                    JOIN map_warp_weaver ww ON ww.id = wwi.warp_weaver_id
                    JOIN map_weaver_loom as wl ON ww.weaver_loom_id = wl.id
                    JOIN user u on u.id = wl.weaver_id AND u.user_type_id =:user_type_id
                    JOIN saree_type st on st.id = ww.saree_type_id
                WHERE
                    (wwi.given_amount > 0 || wwi.given_net_transfer_amount > 0 || wwi.mistake_amount > 0) 
                    AND ##CONDITION##
            ';

            $replacement = ['wwi.date >= :startDate AND wwi.date <= :endDate'];
            $params = [
                ':startDate' => $startTime, 
                ':endDate' => $endTime, 
                ':user_type_id' => UserType::$weaver
            ];
            if (!empty($weaverId)) {
                $replacement[] = 'u.id =:user_id';
                $params[':user_id'] = $weaverId;
            }
            $sql = str_replace('##CONDITION##', implode(' AND ', $replacement), $sql);
            $sqlQuery = Yii::$app->getDb()->createCommand($sql, $params);
            $weaverAmountRecord = $sqlQuery->queryAll();

            return $this->renderAjax(
                'weaver_amount_grid',
                [
                    'weaverAmountData' => $weaverAmountRecord
                ]
            );
        }
        $weaverList = ArrayHelper::map(
            User::find()->where(['user_type_id' => UserType::$weaver])->asArray()->all(),
            'id',
            'name'
        );
        
        return $this->render(
            'weaver_amount_details',
            [
                'weaverList' => $weaverList
            ]
        );
    }

    public function actionWeaverInventoryReport()
    {
        if ($this->request->isPost) {
            $weaverId = $_POST['weaver_id'];
            $startTime = strtotime(sprintf('%s 00:00:00', $_POST['start_date']));
            $endTime = strtotime(sprintf('%s 23:59:59', $_POST['end_date']));

            $sql = 'SELECT
                    wwi.*,
                    concat(
                        u.name, 
                        "[ ", wl.loom_name, " ]",
                        "[ ", ww.name, " ]",
                        "[ ", st.name, " ]"
                    ) as "weaver_name"
                FROM
                    map_warp_weaver_inventory as wwi
                    JOIN map_warp_weaver ww ON ww.id = wwi.warp_weaver_id
                    JOIN map_weaver_loom as wl ON ww.weaver_loom_id = wl.id
                    JOIN user u on u.id = wl.weaver_id AND u.user_type_id =:user_type_id
                    JOIN saree_type st on st.id = ww.saree_type_id
                WHERE
                    (
                        wwi.given_yarn_quantity > 0 
                        || wwi.given_yarn_weight > 0 
                        || wwi.given_jarigai_quantity > 0
                        || wwi.given_jarigai_weight > 0
                    ) 
                    AND ##CONDITION##
            ';

            $replacement = ['wwi.date >= :startDate AND wwi.date <= :endDate'];
            $params = [
                ':startDate' => $startTime, 
                ':endDate' => $endTime, 
                ':user_type_id' => UserType::$weaver
            ];
            if (!empty($weaverId)) {
                $replacement[] = 'u.id =:user_id';
                $params[':user_id'] = $weaverId;
            }
            $sql = str_replace('##CONDITION##', implode(' AND ', $replacement), $sql);
            $sqlQuery = Yii::$app->getDb()->createCommand($sql, $params);
            $weaverInventoryRecord = $sqlQuery->queryAll();

            return $this->renderAjax(
                'weaver_inventory_grid',
                [
                    'weaverInventoryData' => $weaverInventoryRecord
                ]
            );
        }
        $weaverList = ArrayHelper::map(
            User::find()->where(['user_type_id' => UserType::$weaver])->asArray()->all(),
            'id',
            'name'
        );
        
        return $this->render(
            'weaver_inventory_details',
            [
                'weaverList' => $weaverList
            ]
        );
    }
}
