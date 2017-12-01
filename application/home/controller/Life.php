<?php
namespace app\home\controller;
class Life extends Home{
    public function index($page=1){
        $list = \think\Db::name('Document')
            ->where('category_id', 2)->whereor('category_id', 43)->whereor('category_id',44)
            ->where(['status'=>1])
            ->limit(2)->page($page)->select();
        if($this->request->isAjax()){
            return json_encode(['list'=>$list,'page'=>$page]);
        }else{
            $this->assign('list', $list);
            $this->assign('page', $page);
            $this->assign('meta_title' , '生活贴士');
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
}
