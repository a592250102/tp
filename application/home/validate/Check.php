<?php
namespace app\home\validate;
use think\Validate;

class Check extends Validate{
    protected $rule = [
        ['name', 'require', '姓名不能为空'],
        ['sn', 'require', '房号不能为空'],
        ['relation', 'require', '关系不能为空'],
        ['tel', 'require', '联系电话不能为空'],
        ['code', 'require', '身份证号码不能为空'],
    ];
}
