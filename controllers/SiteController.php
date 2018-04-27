<?php
namespace app\controllers;


use app\models\Client;
use yii\web\Controller;

/**
 * Class SiteController
 *
 * @package app\controller
 */
class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $clients = Client::find()->asArray()->all();

        return $this->render('index', [
            'clients' => $clients
        ]);
    }
}
