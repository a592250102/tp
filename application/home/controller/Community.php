<?php
namespace app\home\controller;
use think\Session;

class Community extends Home{
    public function index($page=1){
        $list = \think\Db::name('Document')->where(['status'=>1])->where(['category_id'=>44])->limit(2)->page($page)->select();
        if($this->request->isAjax()){
            return json_encode(['list'=>$list,'page'=>$page]);
        }else{
            $this->assign('list', $list);
            $this->assign('page', $page);
            $this->assign('meta_title' , '小区活动');
            return $this->fetch();
        }

    }
    public function path(){
        if ($this->request->isAjax()){
            $id = $this->request->post('cover_id');
            $time = $this->request->post('time');
            $time = date('Y-m-d H:i',$time);
            $data['path'] = get_cover($id)['path'];
            $data['time'] = $time;
            return $data;
        }
    }

    public function detail($id){
        \think\Db::name('document')->where('id',$id)->setInc('view');
        $list = \think\Db::name('Document')->where('id',$id)->find();
        $this->assign('list', $list);
        $lists = \think\Db::name('Document_article')->where('id',$id)->find();
        $this->assign('content', $lists['content']);
        $uid = \think\Db::name('member')->where('uid',$list['uid'])->field('nickname')->find();
        $this->assign('uid', $uid['nickname']);
        return $this->fetch('detail');
    }
    public function join($id){
        $result = \think\Db::name('H_user')->where('h_id',$id)->where('user_id',Session::get('user_auth')['uid'])->find();
        if($result){
            \think\Db::name('H_user')->where('h_id',$id)->where('user_id',Session::get('user_auth')['uid'])->delete();
            return '1';
        }else{
            $model = new \app\home\model\H_user();    //实例化模型
            $data['h_id'] = $id;
            $data['user_id'] = Session::get('user_auth')['uid'];
            $data = $model->create($data);  //保存数据库
            if($data){
                return '1';
            }
        }
    }
    public function check($id){
        $result = \think\Db::name('H_user')->where('h_id',$id)->where('user_id',Session::get('user_auth')['uid'])->find();
        if($result) {
            return "1";
        }else{
            return "0";
        }
    }
}