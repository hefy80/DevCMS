<?php
include 'Public/parsedown-master/Parsedown.php';

// 本类由系统自动生成，仅供测试用途
class DocAction extends Action {
    public function index(){
		//根据传入的path，获取当前节点的类型并区分展示
		$path = base64_decode($_REQUEST['path']);

		unset($node);
		$doc = D('Doc');
		$node = $doc->getDirTree($path);

		$path = '.'.APP_UPLOADPATH.'Documents'.$path;
		if (is_dir($path))
		{
			$this->assign('node',$node);
			$this->display();
		}
		else if (is_file($path))
		{
			$pathinfo = pathinfo($path);
			$txt=file_get_contents($path);
			if ($pathinfo['extension']=='md')
			{
				$Parsedown = new Parsedown();
				$txt=$Parsedown->text($txt);
			}
			$this->assign('txt',$txt);
			$this->assign('node',$node);
			$this->display('detail');
		}
		else
		{
		}
    }
}

