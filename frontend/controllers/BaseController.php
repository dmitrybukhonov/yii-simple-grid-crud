<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param string $message
     */
    public function alertDanger(string $message)
    {
        Yii::$app->session->setFlash('error', $message);
    }

    /**
     * @param string $message
     */
    public function alertSuccess(string $message)
    {
        Yii::$app->session->setFlash('success', $message);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
