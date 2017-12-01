<?php
namespace app\admin\controller;

class Service extends Admin{
    //列表
    public function index(){
        $list = \think\Db::name('Service')->paginate(1);
        $total= \think\Db::name('Service')->count();
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('_page', $page);
        $this->assign('_total', $total);
        $this->assign('meta_title' , '维修管理');
        return $this->fetch();
    }
    //添加
    public function add(){
        if(request()->isPost()){  //提交表单
            $Service = model('service');     //实例化模型
            $data=\think\Request::instance()->post();//接收数据
            $validate = validate('service'); //验证
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
            return $this->fetch('edit');
        }
    }
    //修改
    public function edit($id = 0){
        if(request()->isPost()) {  //提交表单
            $data = \think\Request::instance()->post();  //获取表达数据
            $Service = \think\Db::name("service"); //实例化模型
            $data = $Service->update($data);               //修改
            if($data !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        }else{
            $info = [];
            /* 获取数据 */
            $info = \think\Db::name('Service')->find($id); //获取回显数据
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);  //分配数据
            $this->meta_title = '修改维修信息';
            return $this->fetch();
            }
    }
    //删除
    public function del($id = 0){
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(\think\Db::name('service')->where($map)->delete()){
            action_log('update_service', 'service', $id, UID);//记录
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    //查看详情
    public function view($id=0){
        empty($id) && $this->error('参数错误！');
        $info = db('Service')->find($id);
        $this->assign('info', $info);
        $this->assign('meta_title', '查看行为日志');
        return $this->fetch();
    }
}