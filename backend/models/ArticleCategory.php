<?php
namespace backend\models;

use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord {

     //验证规则
    public function rules()
    {
        return [
            [["name","status","intro"],"required","message"=>"必须填写"],
            ["sort","safe"],
        ];


    }

    /**
     * 获取分页表数据
     */



}