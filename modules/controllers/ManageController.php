<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\modules\models\Admin;
use yii\data\Pagination;

/**
 * Default controller for the `admin` module
 */
class ManageController extends CommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    
    public $layout = 'layout';
    public function actionMailchangepass(){
        $this->layout = false;
        $time = Yii::$app->request->get("timestamp");
        $adminuser = Yii::$app->request->get("adminuser");
        $token = Yii::$app->request->get("token");
        $model= new Admin;
        
        $myToken = $model->createToken($adminuser, $time);
        if($token != $myToken){
            Yii::$app->session->setFlash('info',"Token incorrect");
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if(time() - $time > 60000){
            //if more than 5minutes
            Yii::$app->session->setFlash('info',"Link Expired");
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->mailChangePass($post)){
                Yii::$app->session->setFlash('info',"Password is updated.");
                $this->redirect(['public/login']);
            }else{
                var_dump($model->errors);
            }
        }
        $model->adminuser = $adminuser;
        
        return $this->render("mailchangepass",['model'=>$model]);
    }
    
    public function actionAdmins()
    {
        $model = Admin::find();
        $count = $model->count();
        //page size = how many data in one page
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $admins = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('admins',['admins'=>$admins,'pager'=>$pager]);
    }
    public function actionAdd()
    {
        $model = new Admin;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->add($post);
            if($model->add($post)){
                Yii::$app->session->setFlash('info',"Added Successful");
            }else{
                Yii::$app->session->setFlash('info',"Add failed");
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    
    public function actionDel(){
        $adminid =(int) Yii::$app->request->get("adminid");
        if(empty($adminid)){
            $this->redirect(['manage/admins']);
        }
        $model = new Admin;
        if($model->deleteAll('adminid = :id',[':id'=>$adminid])){
            Yii::$app->session->setFlash('info','Delete Successful');
            $this->redirect(['manage/admins']);
        }
    }
    
    public function actionChangeemail(){
        $model = Admin::find()->where('adminuser = :user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changeemail($post)){
                Yii::$app->session->setFlash('info','Changes are saved');
            }
        }
        $model->adminpass = '';
        return $this->render('changeemail',['model'=>$model]);
    }
    
    public function actionChangepass(){
        $model = Admin::find()->where('adminuser = :user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changepass($post)){
                Yii::$app->session->setFlash('info','Changes are saved');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass',['model'=>$model]);
    }
    
    
}