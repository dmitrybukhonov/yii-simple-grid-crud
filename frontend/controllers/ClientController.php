<?php

namespace frontend\controllers;

use Yii;
use Throwable;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use frontend\models\client\Client;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use frontend\models\search\ClientSearch;
use common\components\dropdown\FitnesClubDropDown;

class ClientController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();

        $searchModel = new ClientSearch();
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
        /** @var Client */
        $client = Client::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$client) {
            throw new NotFoundHttpException('Материал не найден');
        }

        return $this->render('view', [
            'client' => $client,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $client = new Client();

        return $this->proceed($client);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionUpdate(int $id)
    {
        /** @var Client */
        $client = Client::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$client) {
            throw new NotFoundHttpException('Материал не найден');
        }

        return $this->proceed($client);
    }

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionDelete(int $id)
    {
        /** @var Client */
        $model = Client::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Материал не найден');
        }

        if ($model->softDelete()) {
            $this->alertSuccess('Материал успешно удален');

            return $this->redirect(['client/index']);
        }

        $this->alertWarning('Произошла ошибка при удалении материала');

        return $this->refresh();
    }

    /**
     * @param Client $model
     * @return string|Response
     */
    private function proceed(Client $model)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            $model->load($request->post());
            return $this->asJson(ActiveForm::validate($model));
        }

        if ($model->load($request->post()) && $model->validate()) {
            if ($model->save()) {
                $this->alertSuccess('Сохранение выполнено успешно');
                return $this->redirect(['client/update', 'id' => $model->id]);
            }

            $this->alertDanger('Произошла ошибка при сохранении');
        }

        return $this->render('model', [
            'model' => $model,
            'clubList' => FitnesClubDropDown::getClubList(),
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
