<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\TestModel;


class IndexController extends Controller {
	
	public function index(){
		echo 'test';


    }
	
    public function index111(){

		//$mondel = new TestModel("test");  //这里传不传如表名都没关系
		$mondel = D("test");  //这里传不传如表名都没关系
		$data = array();
		$data['name'] = 'admin1234';
		$mondel->add($data);
        $message = $mondel->select(); //简单的查询一个数据
		
        dump($message); 

    }
	
	public function testRedis(){
		 
		//连接本地的 Redis 服务
	   $redis = new \Think\Cache\Driver\Redis();
	   $redis->connect();
	   $redis->set('test','hello world!');
	   $redis->set('test1','hello world1!');
		echo $redis->get("test")."<br>";
		echo $redis->get("test1")."<br>";
	   echo "Connection to server sucessfully<br>";
			 //查看服务是否运行
	   echo "Server is running: " . $redis->ping();
	}
	
	public function testMem(){
		
		$memcache = new \Think\Cache\Driver\Memcache();             //创建一个memcache对象
		$memcache->connect(); //连接Memcached服务器
		$memcache->set('key', 'test');        //设置一个变量到内存中，名称是key 值是test
		$get_value = $memcache->get('key');   //从内存中取出key的值
		echo $get_value;
	}
	
	public function mink2() {
        import("Lib.BehatMink.vendor.autoload", APP_PATH, '.php');

        // Choose a Mink driver. More about it in later chapters.
        //$driver = new \Behat\Mink\Driver\GoutteDriver();
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
		//$driver = new \Behat\Mink\Driver\Selenium2Driver('chrome');
        $session = new \Behat\Mink\Session($driver);

        // sart the session
        $session->start();

        $session->visit("https://www.northernwholesale.com/signin.html");
        $page = $session->getPage();

        $em = $page->findField('login');    //填写字段
        echo $em->getTagName();
        echo "===============";
        echo $em->isVisible();
        echo "|||||||||||||||||||||<br>\n";
        $em = $page->find('xpath', '//input[@id="login"]');    //填写字段
        echo $em->getTagName();
        echo "===============";
        echo $em->isVisible();
        $em->setValue('findimport12');
        echo $em->getValue();

        
        $em->setValue('findimport12');



        $em = $page->find('xpath', '//input[@id="password"]');    //填写字段
        $em->setValue('5837548');
        echo $em->getTagName();
        echo "===============";
        echo $em->isVisible();


        //$page->fillField('login', 'findimport12');    //填写字段
        //$page->fillField('password', '5837548');    //填写字段
        $em = $page->find('xpath', "//form[@id='nws-form']/div[3]/input[2]");    //填写字段
        $em->click();
        $result = $session->wait(
            5000, ""
        );  //如果是timeout会返回false

        $session->visit("https://www.northernwholesale.com/home");
        $page = $session->getPage();
        $html = $page->getHtml();
        echo $html;
		
		echo $session->getScreenshot();

    }
	
	public function mink3() {
        import("Lib.BehatMink.vendor.autoload", APP_PATH, '.php');

        // Choose a Mink driver. More about it in later chapters.
        //$driver = new \Behat\Mink\Driver\GoutteDriver();
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
		//$driver = new \Behat\Mink\Driver\Selenium2Driver('chrome');
        $session = new \Behat\Mink\Session($driver);

        // sart the session
        $session->start();

        $session->visit("https://www.athleticconnection.com/customer/account/login/");
        $page = $session->getPage();

        $page->fillField('email','0001564371');    //填写字段
        $page->fillField('pass','Welcome');    //填写字段

        $em = $page->find('xpath', '//button[@id="send2"]');    //填写字段
        $em->click();
        $result = $session->wait(
           5000, ""
        ); 
		$page = $session->getPage();
		
		$session->visit("https://www.athleticconnection.com/customer/account/");
		$a = $session->switchToIFrame('easyXDM_default5743_provider');
		echo $a;

        $html = $page->getHtml();
        echo $html;

    }
}