<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//we make create this models folder in the modules folder to make it only access by adminstrative
//but not open to public
namespace app\modules\models;

use Yii;
use yii\db\ActiveRecord;

require '..\mail\PHPMailerAutoload.php';
class Admin extends ActiveRecord{
    public $rememberMe = true;
    public $repass = '';
    public $currentpass = '';
    public static function tableName(){
        //return tableName, prefix is predefined in db.php
        return "{{%admin}}";
    }
    public function attributeLabels(){
        return [
            'adminuser'=> 'Admin account',
            'adminemail'=> 'Email',
            'adminpass'=>'Password',
            'repass'=>'Confirm Password',
            'currentpass'=>'Current Password',
        ];
    }
    public function rules(){
        return [
            ['adminuser','required','message'=> 'ID Could not be blank','on'=>['login','seekpass','adminadd','changeemail','changepass','mailchangepass']],
            ['adminpass','required','message'=> 'Password Could not be blank','on'=>['login','adminadd','changeemail','changepass','mailchangepass']],
            ['rememberMe', 'boolean','on'=>'login'],
            ['adminpass','validatePass','on'=>['login','changeemail']],
            ['adminemail','required','message'=>'Email could not be blank','on'=>['seekpass','adminadd','changeemail']],
            ['adminemail','email','message'=>'Email format is wrong','on'=>['seekpass','adminadd','changeemail']],
            ['adminuser','unique','message'=>'Account has been used by others','on'=>'adminadd'],
            ['adminemail','unique','message'=>'Email has been used by others','on'=>['adminadd','changeemail']],
            ['adminpass','validateEmail','on'=>['seekpass']],
            ['repass','required','message'=>'Confirm Password could not be blank','on'=>['adminadd','changepass','mailchangepass']],
            ['repass','compare','compareAttribute'=>'adminpass','message'=>'Password and Confirm Password Do not match','on'=>['adminadd','changepass','mailchangepass']],
            ['currentpass','required','message'=>'Current Password could not be blank','on'=>['changepass']],
            ['currentpass','validateCurrentPass','on'=>'changepass'],
        ];
    }
    
    public function validatePass(){
        if(!$this->hasErrors()){
            //if there is no error before this condition check
            $data = self::find()->where('adminuser =:user and adminpass = :pass',  [":user"=> $this->adminuser, ":pass"=> md5($this->adminpass)])->one();
                if(is_null($data)){
                    $this->addError("adminpass","Username or password is wrong");
                }
        }
    }
     public function validateCurrentPass(){
        if(!$this->hasErrors()){
            //if there is no error before this condition check
            $data = self::find()->where('adminuser =:user and adminpass = :pass',  [":user"=> $this->adminuser, ":pass"=> md5($this->currentpass)])->one();
            if(is_null($data)){
                    $this->addError("currentpass","Wrong Current Password");
            }
        }
    }
    public function validateEmail(){
        if(!$this->hasErrors()){
            $data = self::find()->where('adminuser =:user and adminpass = :email',  [":user"=> $this->adminuser, ":pass"=> $this->adminemail])->one();
        }
        if(is_null($data)){
                $this->addError("adminemail","Wrong Email");
        }
    }

    public function login($data){
        $this->scenario = "login";
        if($this->load($data) && $this->validate()){
            //login if without error
            // Session for one day
            $lifetime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $session['admin'] =[
                'adminuser' => $this->adminuser,
                'isLogin' => 1,
            ];
            //update ip and logintime
//            $this->updateAll(['logintime'=> time(),'loginip'=> ip2long(Yii::$app->request->userIP)],'adminuser = :user', [':user'=> $this->adminuser]);
            $this->updateAll(['logintime'=> time(),'loginip'=> 0],'adminuser = :user', [':user'=> $this->adminuser]);
            return (bool) $session['admin']['isLogin'];
        }
        return false;
    }
    
    public function seekPass($data){
        $this->scenario = "seekpass";
        if($this->load($data) && $this->validate()){
            //Send Reset Password to user's email
            $time = time();
            $token = $this->createToken($data['Admin']['adminuser'],$time);
            $mailer = Yii::$app->mailer->compose('seekpass',['adminuser'=>$data['Admin']['adminuser'],'time'=>$time,'token'=>$token]);
            $mailer->setFrom("jabez.yong1215@outlook.com");
//            $mailer->setTo($data['Admin']['adminemail']);
            $mailer->setTo("jabez.yong1215@gmail.com");
            $mailer->setSubject("Reset Password");
            if($mailer->send()){
                return true;
            }
        }

    }
     public function createToken($adminuser, $time)
    {
        return md5(md5($adminuser).base64_encode(Yii::$app->request->userIP).md5($time));
    }
    
    public function add($data){
        $this->scenario = 'adminadd';

        if($this->load($data) && $this->validate()){
            $data['Admin']['adminpass'] = md5($data['Admin']['adminpass']);
            if($this->save(false)){
                return true;
            }
            return false; 
        }
        return false;
    }
    
    public function changeEmail($data){
        $this->scenario = "changeemail";
        if($this->load($data) && $this->validate()){
            return (bool) $this->updateAll(['adminemail'=>$this->adminemail], 'adminuser = :user',[':user' => $this->adminuser]);
//            return (bool) $this->updateAll(['adminemail'=>$this->adminemail],'adminuser = :user',[':user '=>$this->adminuser]);
        }
        return false;
    }
    public function mailChangePass($data){
        $this->scenario = "mailchangepass";
        if($this->load($data) && $this->validate()){
            return (bool) $this->updateAll(['adminpass'=>md5($this->adminpass)], 'adminuser = :user',[':user' => $this->adminuser]);

        }
        return false;
    }
    public function changePass($data){
        $this->scenario = "changepass";
        if($this->load($data) && $this->validate()){
            return (bool) $this->updateAll(['adminpass'=>md5($data['Admin']['adminpass'])], 'adminuser = :user',[':user' => $data['Admin']['adminuser']]);

        }
        return false;
    }
}