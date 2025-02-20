<?php

namespace app\controllers;

use app\models\UserType;
use app\models\UserTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\BaseController;

/**
 * UserTypeController implements the CRUD actions for UserType model.
 */
class UserTypeController extends BaseController
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
     * Lists all UserType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserTypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/usertype/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserType model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return json_encode(
            [
                'data' => UserType::find()->where(['id' => $id])->asArray()->one(),
                'label' => (new UserType)->attributeLabels()
            ]
        );
    }

    /**
     * Creates a new UserType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserType();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return json_encode(['id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/usertype/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserType model.
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

        return $this->render('/usertype/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserType model.
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
     * Finds the UserType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
