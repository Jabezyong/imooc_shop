<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\modules\models\Admin;
/**
 * Default controller for the `admin` module
 */
class PublicController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = false;
    public function actionLogin()
    {
//        $this->layout = "false";
        $model = new Admin;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->login($post)){
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
//            var_dump($post);
        }
        return $this->render('login',['model' => $model]);
    }
    
    public function actionLogout(){
        Yii::$app->session->removeAll();
        if(!isset(Yii::$app->session['admin']['isLogin'])){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }
    
    public function actionSeekpassword(){
//        $this->layout = false;
        $model = new Admin;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->seekPass($post))
                Yii::$app->session->setFlash('info', 'Email is sent, check your inbox.');
        }
        return $this->render('seekpassword',['model' =>$model]);
    }
}
