<?php
namespace app\home\controller;

use think\Session;

class Service extends Home{
    public function add(){
        if(!is_login()){
            $this->error( '您还没有登陆',url('User/login') );
        }
        $user = \think\Db::name('ucenter_member')->where('id',is_login())->find();
        if($user['is_check'] != 1){
            $this->error( '您还没有通过业主验证',url('home/check/check') );
        }
        if(request()->isPost()){  //提交表单
            $Service = new \app\admin\model\Service();    //实例化模型
            $data=\think\Request::instance()->post();//接收数据
            $validate = new \app\admin\validate\Service(); //验证
            if(!$validate->check($data)){         //验证未通过
                return $this->error($validate->getError()); //报错
            }
            $data['sn'] = date("YmdHis").uniqid();//维修单号
            $data = $Service->create($data);  //保存数据库
            if($data){
                $this->success('新增成功', url('index'));  //添加成功跳转
                action_log('update_service', 'service', $data->id, UID);//记录日志
            }else{
                $this->error($Service->getError());  //报错
            }
        }else{ //展示添加页面
            $this->assign('info',null);  //分配数据
            $this->assign('meta_title', '新增维修');
            return $this->fetch();
        }
    }
}