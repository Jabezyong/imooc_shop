<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use Yii;
use app\modules\controllers\CommonController;
/**
 * Description of UserController
 *
 * @author jabez
 */
class UserController extends CommonController{
    //put your code here
    public $layout = 'layout';
    
    public function actionUsers(){
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('users',['users'=>$users,'pager'=>$pager]);
    }
    public function actionReg(){
         $model = new User;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            
            if($model->reg($post)){
                Yii::$app->session->setFlash('info',"Added Successful");
            }else{
                Yii::$app->session->setFlash('info',"Add failed");
            }
        }
        return $this->render('reg',['model'=>$model]);
    }
    
    
    public function actionDel(){
        try{
            $userid = Yii::$app->request->get('userid');
            if(empty($userid)){
                throw new \Exception();
            }
            $trans =Yii::$app->db->beginTransaction();
            if($obj = Profile::find()->where('userid = :id', [':id' => $userid])->one()){
                $res = Profile::deleteAll('userid = :id',[':id'=>$userid]);
                if(empty($res)){
                    throw new \Exception();
                }
            }
            if(!User::deleteAll('userid = :id',[':id'=>$userid])){
                throw new \Exception();
            }
            $trans->commit();
        } catch (Exception $ex) {
            if (Yii::$app->db->getTransaction()) {
                //if delete faiiled then rollback to previous state.
                $trans->rollback();
            }
        }
        $this->redirect(['user/users']);
    }
}
