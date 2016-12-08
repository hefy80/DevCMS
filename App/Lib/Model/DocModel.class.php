<?php
class DocModel extends Model{
	/**
	 * 递归查看指定目录下的所有文件（可以指定类型）和目录
	 * @author heyu
	 * @param array $node		Upload下的相对路径下的目录结构
	 */
	public function createDirTree(&$node, $depth=1) 
	{
		if (!is_array($node))
			return false;

		if (!$node || count($node)<=0)
		{
			$node['path'] = '';
			$node['name'] = 'Documents';
			$node['depth'] = 0;
			$node['forefather'] = array();
		}
//		$path = mb_convert_encoding($node['path'],'gb2312','UTF-8');
		$path = '.'.APP_UPLOADPATH.'Documents'.$node['path'];
//		echo $node['path']; exit(0);
		foreach(new DirectoryIterator($path) as $file) 
		{
			if (!$file->isDot()) 
			{
				unset($child);
//				$filename = mb_convert_encoding($file->getFilename(),'UTF-8','gb2312');
				$filename = $file->getFilename();
				if (strpos($filename,'.')===false || strpos($filename,'.')>0)
				{
					$child['path']=$node['path']."/".$filename;
					$encode = mb_detect_encoding($filename, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
					if ($encode != "UTF-8")	//兼容windows下的中文目录
					{
						$filename = mb_convert_encoding($filename,"UTF-8",$encode);
					}
					$child['name']=$filename;
					$child['depth']=$depth;
					$forefather['name']=$child['name'];
					$forefather['path']=$child['path'];
					$child['forefather']=$node['forefather'];
					$child['forefather'][]=$forefather;
					if ($file->isDir()) 
					{
						$child['type']='dir';
						$this->createDirTree($child, $depth+1);
					} 
					else 
					{
						$child['type']='file';
					}
					$node['children'][$child['name']]=$child;
				}
			}
		}
	}
	
	/**
	 * 根据传入的路径，查找文件，返回该节点下的文件结构
	 * @author heyu
	 * @param string $path		Upload下的相对路径下的目录结构
	 */
	public function getDirTree($path) 
	{
		//获取完整的目录树
		$res = S('devcms:DocTree');
		if (!$res || count($res)<=0)
		{
			unset($res);
			$res = array();
			$this->createDirTree($res);

			if (count($res)>0)
			{
				S('devcms:DocTree',$res,60);
			}
		}
		$node = $res;

		//从目录树中找到子树
		$encode = mb_detect_encoding($path, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
		if ($encode != "UTF-8")	//兼容windows下的中文目录
		{
			$path = mb_convert_encoding($path,"UTF-8",$encode);
		}
//echo "path=".$path."<br/>";
		$pieces = explode("/", $path);
		foreach ($pieces as $k => $v) {
			if ($v != "" && $v != ".")
			{
				$node = $node['children'][$v];
			}
		}
//dump($node);
		return $node;
	}

}
?>