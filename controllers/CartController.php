<?php
/**
 * Created by PhpStorm.
 * User: jabez
 * Date: 17/5/2017
 * Time: 1:23 PM
 */

namespace app\controllers;

use yii\web\Controller;

class CartController extends Controller{
    //to remove the header and footer which is from Yii framework
    public $layout = "layout";
    public function actionIndex(){
//        $this->layout = false;
        return $this->render("index");
    }
    
    public function actionDetail(){
//        $this->layout = false;
        return $this->render("detail");
    }
}

