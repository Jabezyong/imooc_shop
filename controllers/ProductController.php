<?php
/**
 * Created by PhpStorm.
 * User: jabez
 * Date: 17/5/2017
 * Time: 1:23 PM
 */

namespace app\controllers;
use app\models\Product;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;
class ProductController extends Controller{
    //to remove the header and footer which is from Yii framework
//    public $layout = "false";
    public $layout = "index";
    public function actionIndex(){
//        $this->layout = false;
       $cid = Yii::$app->request->get("cateid");
       $where = "cateid = :cid and ison = '1'";
       $params = [':cid'=>$cid];
       $model = Product::find()->where($where,$params);
       $all = $model->asArray->all();
       $count = $model->count();
       $pageSize = Yii::$app->param['pageSize']['frontproduct'];
       $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
       $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();
       
       $tui = $model->Where($where . ' and istui = \'1\'',$params)->orderby('createtime desc')->limit(5)->asArray()->all();
       $hot =  $model->Where($where . ' and ishot = \'1\'',$params)->orderby('createtime desc')->limit(5)->asArray()->all();
       $sale =  $model->Where($where . ' and issale = \'1\'',$params)->orderby('createtime desc')->limit(5)->asArray()->all();
       return $this->render("index", ['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $all, 'pager' => $pager, 'count' => $count]);
    }
    
    public function actionDetail(){
//        $this->layout = false;
        return $this->render("detail");
    }
}

