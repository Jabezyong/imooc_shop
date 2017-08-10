<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;
use \yii\web\Controller;
use Yii;
/**
 * Description of CommonController
 *
 * @author jabez
 */
class CommonController extends Controller {
    //put your code here
    
    public function init(){
        if(Yii::$app->session['admin']['isLogin']!=1){
            return $this->redirect(['/admin/public/login']);
        }
    }
}
