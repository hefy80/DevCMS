<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		//判断session中是否存在userinfo，没有则去登录
/*		if(empty(session('userinfo'))){ 
			if(!empty(cookie('userinfo'))){ 
				session('userinfo',cookie('userinfo'));
			}
			else
			{
				header("Location:".U('Home/Index/login'));
			}
listfilesin();}*/

		//初始化上传目录
        $webs = array(
				'万步网' => array(
				'url' => 'http://www.wanbu.com.cn',
				'img' => 'wanbu.jpg',
			),
				'禅道项目管理系统' => array(
				'url' => 'http://192.168.20.177/zentao',
				'img' => 'zentao.jpg',
			),
				'技术中心文库' => array(
				'url' => 'http://192.168.20.177/mtceo',
				'img' => 'mtceo.jpg',
			),
				'技术中心论坛' => array(
				'url' => 'http://192.168.20.177/x2',
				'img' => 'discuz.jpg',
			),
				'办公OA系统' => array(
				'url' => 'http://192.168.92.147:8000/seeyon',
				'img' => 'OA.jpg',
			),
				'培训考试系统' => array(
				'url' => 'http://192.168.20.177/ppf',
				'img' => 'ppf.jpg',
			)
		);
		$this->assign('webs',$webs);

		$this->display();
    }

	public function doLogout(){
		session('userinfo',null);
		cookie('userinfo',null);
		header("Location:".U('Home/Index/login'));
    }

	public function login(){
		$this->display();
    }

	public function doLogin(){
		session('userinfo',null);

		//去数据库中匹配账号和密码
	    $username = trim($_POST['username']);
	    $password = trim($_POST['password']);
	
		$user = D('User');
		$res = $user->loginVerify($username, $password);

		if ($res['code']==0)
		{
			//更新session、cookie
			$res['userinfo']['password']=null;
			session('userinfo',$res['userinfo']);
			cookie('userinfo',$res['userinfo'],60*60*24*30);

			header("Location:".U('Home/Index/index'));
		}
		trace('登录结果',$res);
		$this->assign('err_msg',$res['msg']);
		$this->display('login');
    }

	public function doRecover(){
		echo "recover";exit();
		$this->display();
    }

/*	public function listfilesin1 () {
		$node = array();
		$doc = D('Doc');
		$doc->createDirTree($node);
		dump($node); 
		foreach($node['children'] as $file) 
		{
			if ($file['children'])
			{
				foreach($file['children'] as $file1) 
				{
					if ($file1['children'])
						var_dump($file1);
				}
			}
		}
	}*/
	public function listfiles ($dir = ".", $depth=0) {
	   echo "Dir: ".$dir."<br/>";
	   foreach(new DirectoryIterator($dir) as $file) {
		   if (!$file->isDot()) {
			   if ($file->isDir()) {
				   $newdir = $file->getPathname();
				   $this->listfiles($newdir, $depth+1);
			   } else {
				   echo "($depth)".$file->getPathname() . "<br/>";
			   }
		   }
	   }
	}
}
