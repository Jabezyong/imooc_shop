<?php

namespace app\modules\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
class Product extends ActiveRecord{
    public static function tableName() {
       return "{{%product}}";
    }
    public function rules() {
        return [
            ['title','required','message'=>'Title couldn\'t be blank'],
            ['descr','required','message'=>'Description couldn\'t be blank'],
            ['cateid','required','message'=>'Select one category'],
            ['price','required','message'=>'Enter Price'],
            [['price','saleprice'],'number','min'=>0.01,'message'=>"Price of product must more than 0"],
            ['num','integer','min'=>0,'message'=>'Number of Product available must more than 0'],
            [['issale','ishot','pics','istui'],'safe'],
            [['issale','ishot','pics','istui'],'safe'],
            [['cover'],'required'],
            [['cover'],'file','skipOnEmpty'=>true,'extensions'=>'png,jpg,jpeg'],
            [['pics'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function attributeLabels() {
        return [
            'cateid' => 'Category Name',
            'title' => 'Product Name',
            'descr' => 'Description',
            'price' => 'Price',
            'ishot' => 'Is Hot Item?',
            'issale' => 'Is On Sale?',
            'saleprice' => 'Sales Price',
            'num' => 'Quantity On Hand',
            'cover' => 'Cover Photo',
            'pics' => 'Product Picture',
            'ison' => 'Is On Shelf',
            'istui' => 'Recommeneded?'
        ];
    }
    public function add($data)
    {

        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }
    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    public function uploadCover($path){
        if($_FILES['Product']['error']['cover'] > 0){
             return false;
        }
        else if($_FILES['Product']['error']['cover'] == 0){
            $this->cover->saveAs($path . $this->cover->baseName . '.' . $this->cover->extension);
            return $this->cover->baseName . '.' . $this->cover->extension;
        }
    }
    public function uploadPics($path){
        $s = [];
        foreach ($this->pics as $file) {
                $s[$file->baseName] = $file->baseName . '.' . $file->extension;
                $file->saveAs($path . $file->baseName . '.' . $file->extension);
        }
        return $s;
    }
   
    public function upload(){
//        //there is error in the cover image
//        if($this->cover->error > 0){
//             return false;
//         }
         $s = [];
         $path = $this->generatePath();
         $this->uploadCover($path);
         $s = $this->uploadPics($path);
         
         return ['cover' => $this->cover->baseName . '.' . $this->cover->extension, 'pics' => json_encode($s),'tempPath'=>$path];

    }
    public function generatePath(){
        if($this->productid == NULL){
            $randomString = $this->generateRandomString();
         }
         else{
              $randomString  = $this->productid;
         }
         $path = Yii::$app->basePath . '\web\pics\\'.$randomString.'\\';
         FileHelper::createDirectory($path);
         return $path;
    }
    
    public function renameFolder($tempPath){
        $newName = Yii::$app->basePath . '\web\pics\\'.$this->productid.'\\';
        //add and mod are using the same method.
        //if same folder name then no need rename.
        if(strcmp($tempPath, $newName)!=0)
            rename($tempPath, $newName);
    }
    
    public function removeFile($fileName){
        $file = Yii::$app->basePath . '\web\pics\\'.$this->productid.'\\'.$fileName;
        return unlink($file);
    }
    
}

