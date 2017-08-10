<?php

namespace app\modules\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;
class Category extends ActiveRecord{
    public static function tableName(){
        return "{{%category}}";
    }
    
    public function attributeLabels() {
       return [
           'parentid' => 'Parent Category',
           'title' => 'Title of Category'
       ];
    }
    
    public function rules(){
        return [
            ['parentid','required','message'=>'Parent Category could not be blank'],
            ['title','required','message'=>'Title could not be blank'],
            ['createtime','safe'],
        ];
    }
    
    public function add($data){
        $data['Category']['createtime'] = time();
        if($this->load($data) && $this->save()){
            return true;
        }
        return false;
    }
    
    public function getData(){
        $cates = self::find()->all();
        //cast object to array
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }
    //display by levels
    //sort based on parentid;
    //parent find child
    //and then merge
    public function getTree($cates,$pid = 0){
        $tree = [];
        
        foreach($cates as $cate){
            if($cate['parentid'] == $pid){
                $tree[] = $cate;
                $tree = array_merge($tree,$this->getTree($cates,$cate['cateid']));
            }
        }
        return $tree;
    }
    
    /*
     * First level has one Prefix"|------"
     * second level has two Prefix"|-----" and so on;
     */
    public function setPrefix($data,$p="|----"){
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while($val = current($data)){
            $key = key($data);
            if($key > 0){
                if($data[$key-1]['parentid']!=$val['parentid']){
                    $num++;
                }
            }
            if(array_key_exists($val['parentid'], $prefix)){
                $num = $prefix[$val['parentid']];
            }
            $val['title'] = str_repeat($p, $num).$val['title'];
            $prefix[$val['parentid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }
    
    public function getOptions(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['Add new Categry'];
        foreach ($tree as $cate){
            $options[$cate['cateid']] = $cate['title'];
        }
        return $options;
    }
    
    public function getTreeList(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
        
    }
}

