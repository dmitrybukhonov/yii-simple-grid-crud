<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use common\models\log\ActionLog;
use yii\data\ActiveDataProvider;

class ActionLogController extends BaseController
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ActionLog::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
