<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\Category;
use yii\web\Controller;

class CategoryController extends Controller{
    public $layout = "layout";
    public function actionList(){
        $model = new Category;
        $cates = $model->getTreeList();
        return $this->render("cates",['cates'=>$cates]);
    }
    
    public function actionAdd(){
        $model = new Category();
        $list = $model->getOptions();
        
//        $list = array_merge([0 => 'Add Top Category',$list]);
        $cates = $model->getData();
        $tree = $model->getTree($cates);
        $pre = $model->setPrefix($tree);
//        var_dump($pre);exit;
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->add($post)){
                Yii::$app->session->setFLash('info','Added Successful');
            }
        }
        return $this->render("add",['list'=>$list,'model'=>$model]);
    }
    
    public function actionMod(){
        $cateid = Yii::$app->request->get("cateid");
        $model = Category::find()->where('cateid=:id',[':id'=>$cateid])->one();
//        var_dump($model);exit;
        $list = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash('info','Added Successful');
            }
        }
        return $this->render("mod",['model'=>$model,'list'=>$list]);
    }
    
    public function actionDel(){
        try{
            $cateid = Yii::$app->request->get('cateid');
            if(empty($cateid)){
                throw new \Exception('Parameter Wrong');
            }
            $data = Category::find()->where('parentid = :pid',[":pid"=>$cateid])->one();
            if($data){
                //it has sub child
                throw new \Exception('It has sub category, thus not allow to delete this category');
            }
            if(!Category::deleteAll('cateid = :id',[":id"=>$cateid])){
                throw new Exception('Delete failed');   
            }
        } catch (\Exception $e){
            Yii::$app->session->setFlash('info',$e->getMessage());
        }
        return $this->redirect(['category/list']);
    }
}

