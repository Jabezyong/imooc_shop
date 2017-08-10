<?php
/**
 * Created by PhpStorm.
 * User: jabez
 * Date: 17/5/2017
 * Time: 1:23 PM
 */

namespace app\controllers;

use yii\web\Controller;

class MemberController extends Controller{
    //to remove the header and footer which is from Yii framework
    public $layout = "layout";
    public function actionAuth(){
//        $this->layout = false;
        return $this->render("auth");
    }
    
    public function actionDetail(){
//        $this->layout = false;
        return $this->render("detail");
    }
}

