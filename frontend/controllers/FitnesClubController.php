<?php

namespace frontend\controllers;

use Yii;
use Throwable;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use frontend\models\fitnes\FitnesClub;
use frontend\controllers\BaseController;
use frontend\models\search\FitnesClubSearch;

class FitnesClubController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();

        $searchModel = new FitnesClubSearch();
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionView(int $id)
    {
        /** @var FitnesClub */
        $fitnesClub = FitnesClub::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$fitnesClub) {
            throw new NotFoundHttpException('Материал не найден');
        }

        return $this->render('view', [
            'fitnesClub' => $fitnesClub,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $fitnesClub = new FitnesClub();

        return $this->proceed($fitnesClub);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionUpdate(int $id)
    {
        /** @var FitnesClub */
        $fitnesClub = FitnesClub::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$fitnesClub) {
            throw new NotFoundHttpException('Материал не найден');
        }

        return $this->proceed($fitnesClub);
    }

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionDelete(int $id)
    {
        /** @var FitnesClub */
        $model = FitnesClub::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Материал не найден');
        }

        if ($model->softDelete()) {
            $this->alertSuccess('Материал успешно удален');

            return $this->redirect(['fitnes-club/index']);
        }

        $this->alertWarning('Произошла ошибка при удалении материала');

        return $this->refresh();
    }

    /**
     * @param FitnesClub $model
     * @return string|Response
     */
    private function proceed(FitnesClub $model)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            $model->load($request->post());
            return $this->asJson(ActiveForm::validate($model));
        }

        if ($model->load($request->post()) && $model->validate()) {
            if ($model->save()) {
                $this->alertSuccess('Сохранение выполнено успешно');
                return $this->redirect(['fitnes-club/update', 'id' => $model->id]);
            }

            $this->alertDanger('Произошла ошибка при сохранении');
        }

        return $this->render('model', [
            'model' => $model,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
