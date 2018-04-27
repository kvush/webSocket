<?php
namespace app\controllers;


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
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
