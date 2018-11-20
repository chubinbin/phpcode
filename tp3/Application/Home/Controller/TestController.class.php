<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\TestModel;


class TestController extends Controller {
	
	public function test(){
		$this->display('User/test');
    }
	
}