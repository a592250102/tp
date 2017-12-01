<?php
namespace app\home\controller;
use app\admin\model\Info;
use think\Session;

class Check extends Home{
    public function check(){
        if($this->request->isPost()){
            $check = new Info();
            $data=\think\Request::instance()->post();//接收数据
            $validate = validate('check'); //验证
            $data['uid'] = is_login();
            $data['status'] = 0;
            if(!$validate->check($data)){         //验证未通过
                return $this->error($validate->getError()); //报错
            }
            $data = $check->create($data);  //保存数据库
            if($data){
                $this->success('新增成功', url('index'));  //添加成功跳转
                action_log('update_service', 'service', $data->id, UID);//记录日志
            }else{
                $this->error($check->getError());  //报错
            }
        }
        return $this->fetch();
    }
}
