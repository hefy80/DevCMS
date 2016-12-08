<?php
/*
接口目录、分类
接口信息
	名字
	描述
	调用url
	参数
	返回值
	例子*/

class DeptModel extends Model{
	protected $connection = 'DB_ZT';
	protected $trueTableName = 'zt_dept'; 

	private $_deptList = array();
	private $_deptList_P = array();

	public function getDeptTree(){
		$res = S('depttree');
		if ($res && count($res)>0)
			return $res;

		$res = array();
		$this->getDeptList($fresh);
		$this->createDeptTree($res);

		S('depttree',$res,3600);
		return $res;
	}

	public function getDeptChilds($parentid=0){
		$res = S('deptlist_p');
		if (!$res || count($res)<=0)
			$res=$this->getDeptList();

		$res = $res[$parentid];
		return (!$res) ? false : $res;
	}

	public function getDeptPath($deptid){
		global $_deptList;

		$res = array();
		while ($deptid>0)
		{
			$res[] = $_deptList[$deptid];
			$deptid = $_deptList[$deptid]['parent'];
		}
		krsort($res);

		return (!$res) ? false : $res;
	}

	public function getDept($deptid){
		global $_deptList;

		$res = $_deptList[$deptid];

		return (!$res) ? false : $res;
	}

	private function getDeptList(){
		global $_deptList, $_deptList_P;
		$deptList = S('deptlist');
		$deptList_P = S('deptlist_p');
		if ($deptList && count($res)>0)
			return $res;

		if (count($_deptList)>0)
			return $_deptList;

//		unset($_deptList, $_deptList_P);
		$res = $this->
			field('`id`, `name`, `parent`, `grade`, `order`, `manager`')->
			order('`grade`, `order`')->select();

		if(is_array($res) && count($res)>0)
		{
			foreach ($res as $key=>$val)
			{
				$_deptList[$val['id']] = $val;
				$_deptList_P[$val['parent']][$val['id']] = $val;
			}
		}

		S('deptlist',$_deptList,3600);
		S('deptlist_p',$_deptList_P,3600);

		return $_deptList;
	}

	/**
	 * 创建树形结构（递归）
	 */
	private function createDeptTree(&$node){
		if (!is_array($node))
			return false;

		//根节点处理
		if (count($node)==0)
		{
			$node['id'] = 0;
			$node['name'] = '万步';
		}

		//查找当前节点的孩子
		$res = $this->getDeptChilds($node['id']);
		$node['childnum'] = count($res);
		if(is_array($res) && count($res)<=0)
		{
			return true;
		}

		//和孩子建立树形关系
		foreach ($res as $key=>$val)
		{
			$node['child'][$val['id']] = $this->createDeptTree($val);
		}

		return $node;
	}
}
?>