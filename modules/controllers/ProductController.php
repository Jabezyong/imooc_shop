<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\models\Product;
use app\modules\models\Category;
use yii\web\UploadedFile;

class ProductController extends Controller{
    public $layout = "layout";
    
    public function actionList(){
        $model = Product::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['product'];
        $pager = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);
        
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("products",['pager'=>$pager,'products'=>$products]);
    }
    
    
    public function actionAdd(){
        $model = new Product;
        $cate = new Category;
        $list = $cate->getOptions();
        unset($list[0]);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            $model->cover = UploadedFile::getInstance($model, 'cover');
            $model->pics = UploadedFile::getInstances($model, 'pics');
            $pics = $model->upload();
            if($_FILES['Product']['error']['cover'] > 0){
                $model->addError('cover','Must have cover photo');
            }else{
                $post['Product']['cover'] = $pics['cover'];
                $post['Product']['pics'] = $pics['pics'];
            }
            if ($pics && $model->add($post)) {
                //rename the tempFolder
               $model->renameFolder($pics['tempPath']);
                Yii::$app->session->setFlash('info', 'Added Successful');
            } else {
                var_dump($model->getErrors());exit;
                Yii::$app->session->setFlash('info', 'Something wrong');
            }
        }
        return $this->render("add",['opts'=>$list,'model'=>$model]);
    }

    public function actionMod(){
        $productid = Yii::$app->request->get("productid");
        $model = Product::find()->where('productid=:id',[':id'=>$productid])->one();
        $picsInArray = json_decode($model->pics, true);
        $cate = new Category;
        $list = $cate->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            $model->pics = UploadedFile::getInstances($model, 'pics');
            $path = $model->generatePath();
            if ($_FILES['Product']['error']['cover'] == 0) {
                $model->cover = UploadedFile::getInstance($model, 'cover');
                $post['Product']['cover'] = $model->uploadCover($path);;
            }else{
                $post['Product']['cover'] = $model->cover;
            }
            $pics =[];
            foreach($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                if ($_FILES['Product']['error']['pics'][$k] > 0) {
                    continue;
                }
                $pics = $model->uploadPics($path);
            }
            //merge with the new filename then save into database.
            $post['Product']['pics'] = json_encode(array_merge((array)$picsInArray, $pics)); 
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', 'Modify Successful');
            } else {
                var_dump($model->getErrors());exit;
                Yii::$app->session->setFlash('info', 'Something wrong');
            }
        }
        return $this->render("mod",['model'=>$model,'opts'=>$list]);
    }
    
    public function actionRemovepic(){
        $key = Yii::$app->request->get("key");
        $productid = Yii::$app->request->get("productid");
        $model = Product::find()->where('productid = :pid',[':pid' =>$productid])->one();
        $pics = json_decode($model->pics,true);
        //remove file;
        $model->removeFile($pics[$key]);
        //remove the key of the image from the product.
        unset($pics[$key]);
        Product::updateAll(['pics'=>json_encode($pics)],'productid = :pid',[':pid'=>$productid]);
        return $this->redirect(['product/mod','productid'=>$productid]);
    }
    
    public function actionDel(){
        $productid = Yii::$app->request->get("productid");
        $model = Product::find()->where('productid = :pid',[':pid'=>$productid]);
        //remove folder
        $dir = Yii::$app->basePath . '\web\pics\\'.$productid.'\\';
        //Get a list of all of the file names in the folder.
        $files = glob($dir . '/*');
 
        //Loop through the file list.
        foreach($files as $file){
            //Make sure that this is a file and not a directory.
            if(is_file($file)){
            //Use the unlink function to delete the file.
            unlink($file);
            }
        }
        rmdir($dir);
        Product::deleteAll('productid = :pid',[':pid'=>$productid]);
        return $this->redirect(['product/list']);
    }
    
    public function actionOn(){
        $productid = Yii::$app->request->get("productid");
        Product::updateAll(['ison'=>'1'],'productid = :pid',['pid'=>$productid]);
        return $this->redirect(['product/list']);
    }
     public function actionOff(){
        $productid = Yii::$app->request->get("productid");
        Product::updateAll(['ison'=>'0'],'productid = :pid',['pid'=>$productid]);
        return $this->redirect(['product/list']);
    }
}

