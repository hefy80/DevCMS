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

		if (!$node)
		{
			$node['path'] = './'.APP_UPLOADPATH.'Documents';
			$node['name'] = 'Documents';
			$node['depth'] = 0;
		}
		$path = mb_convert_encoding($node['path'],'gb2312','UTF-8');
		foreach(new DirectoryIterator($path) as $file) 
		{
			if (!$file->isDot()) 
			{
				unset($child);
				$filename = mb_convert_encoding($file->getFilename(),'UTF-8','gb2312');
				$child['path']=$node['path']."/".$filename;
				$child['name']=$filename;
				$child['depth']=$depth;
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
?>