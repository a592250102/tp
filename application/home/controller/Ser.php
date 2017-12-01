<?php
namespace app\home\controller;

class Ser extends Home{
    public function Index(){
        return $this->fetch();
    }
}
