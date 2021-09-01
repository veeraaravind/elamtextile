<?php

namespace app\controllers;

use Yii;
use app\models\SareeType;
use app\models\SareeTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\BaseController;

/**
 * SareeTypeController implements the CRUD actions for SareeType model.
 */
class SareeTypeController extends BaseController
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
     * Lists all SareeType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SareeTypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/sareetype/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SareeType model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return json_encode(
            [
                'data' => SareeType::find()->where(['id' => $id])->asArray()->one(),
                'label' => (new SareeType)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new SareeType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SareeType();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return json_encode(['id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/sareetype/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SareeType model.
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

        return $this->render('/sareetype/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SareeType model.
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
     * Finds the SareeType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SareeType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SareeType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionSwitchLanguage() {
        if ($this->request->isPost) {
            Yii::$app->session->set('language', $_REQUEST['language']);
        }
    }
}
