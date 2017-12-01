<?php
namespace app\home\controller;

class Notice extends Home{
    public function index($page=1){
        $list = \think\Db::name('Document')->where(['status'=>1])->where(['category_id'=>2])->limit(2)->page($page)->select();
        if($this->request->isAjax()){
            return json_encode(['list'=>$list,'page'=>$page]);
        }else{
            $this->assign('list', $list);
            $this->assign('page', $page);
            $this->assign('meta_title' , '小区公告');
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

    public function detail($id){//详情
        \think\Db::name('document')->where('id',$id)->setInc('view');
        $list = \think\Db::name('Document')->where('id',$id)->find();
        $this->assign('list', $list);
        $lists = \think\Db::name('Document_article')->where('id',$id)->find();
        $this->assign('content', $lists['content']);
        $uid = \think\Db::name('member')->where('uid',$list['uid'])->field('nickname')->find();
        $this->assign('uid', $uid['nickname']);
        return $this->fetch('detail');
    }
}
