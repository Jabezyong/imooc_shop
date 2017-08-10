<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use yii\web\Controller;
use app\models\Category;
use app\modules\models\Product;
use app\models\User;
use Yii;
/**
 * Description of CommonController
 *
 * @author jabez
 */
class CommonController extends Controller{
    //put your code here
//    public function ii
    
    public function init(){
        $menu = Category::getMenu();
        $this->view->params['menu'] = $menu;
        $data = [];
        $data['products'] = [];
        $total = 0;
        if(Yii::$app->session['isLogin']){
            $userid = User::find()->where('username = :name',[";name" =>Yii::$app->session['loginname']])->one();
            if(!empty($userodel) && !empty($usermodel->userid)){
                $userid = $usermodel->userid;
                $carts = Cart::find()->where('userid = :uid',[':uid'=>$userid])->asArray()->all();
                foreach($cart as $k->$pro){
                    $product = Product::find()->where('productid = :pid',[':pid'=>$pro['productid']])->one();
                    $data['products'][$k]['cover'] = $product->cover;
                    $data['products'][$k]['title'] = $product->title;
                    $data['products'][$k]['productnum'] = $pro['productnum'];
                    $data['products'][$k]['price'] = $pro['price'];
                    $data['products'][$k]['productid'] = $pro['productid'];
                    $data['products'][$k]['cartid'] = $pro['cartid'];
                    $total += $data['products'][$k]['price'] * $data['products'][$k]['productnum'];
                }
            }
        }
    }
}
