<?php
namespace app\admin\controller;
class Check extends Admin{
    public function index(){
        $list = \think\Db::name('Info')->select();
        $this->assign('list', $list);
        $this->assign('meta_title' , '维修管理');
        return $this->fetch();
    }
    //验证
    public function yes($uid,$id){
        \think\Db::name('ucenter_member')->where('id',$uid)->setField('is_check',1);
        \think\Db::name('info')->where('id',$id)->setField('status',1);
        $this->success('验证通过', url('index'));  //添加成功跳转
    }
    //拒绝
    public function no($uid,$id){
        \think\Db::name('ucenter_member')->where('id',$uid)->setField('is_check',-1);
        \think\Db::name('info')->where('id',$id)->setField('status',-1);
        $this->success('拒绝成功', url('index'));  //添加成功跳转
    }
}
