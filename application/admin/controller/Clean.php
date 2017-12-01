<?php
namespace app\admin\controller;

use app\admin\model\Modelmodel;
use app\home\model\Document;
use think\Controller;
use think\Db;

class Clean extends Controller {
    public function fn(){
        set_time_limit(0);
        echo 'ok';
        while(1){
            $time = time();
            $sql = 'update `twothink_document` set `status` = -1 where `status` != -1 and '.$time.' > `deadline`';
//            $model = new Document();
//            $model->execute($sql);
            Db::name('Document')->execute($sql);
            sleep(1);
            echo 'ok';
        }
    }
}
