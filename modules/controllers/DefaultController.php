<?php

namespace app\modules\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'layout';
    public function actionIndex()
    {
        return $this->render('index');
    }
}
