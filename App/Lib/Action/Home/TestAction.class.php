<?php
// 本类由系统自动生成，仅供测试用途
class TestAction extends Action {
    public function index(){
		$this->display();
    }

    public function register(){
		$this->assign('SN',$_REQUEST['sn']);
		$this->display();
    }

    public function regsucc(){
		$this->assign('REG',$_POST);
		$this->display();
    }
}
