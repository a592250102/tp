<?php
namespace app\admin\validate;
use think\Validate;

class Service extends Validate{

    protected $rule = [
        ['name', 'require', '姓名不能为空'],
        ['tel', 'require', '电话不能为空'],
        ['address', 'require', '地址不能为空'],
        ['question', 'require', '标题不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
}
