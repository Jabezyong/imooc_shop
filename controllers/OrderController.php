<?php
/**
 * Created by PhpStorm.
 * User: jabez
 * Date: 17/5/2017
 * Time: 1:23 PM
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;

class OrderController extends Controller{
    public $layout = false;
     public function actionIndex(){
//        $this->layout = false;
        return $this->render("index");
    }
    public function actionCheck(){
//        $this->layout = false;
        return $this->render("check");
    }
}