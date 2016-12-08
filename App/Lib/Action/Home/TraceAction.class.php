<?php
// 本类由系统自动生成，仅供测试用途
class TraceAction extends Action {
    public function index(){
		$TreePoints = $this->fillMap();
		$this->assign('PointList',$TreePoints);
		$this->display();
    }

    public function ad(){
		$this->display();
    }

	private function fillMap(){
		$MapBorder = array(
			array('L'=>150,'C'=>2),
			array('L'=>140,'C'=>7),
			array('L'=>120,'C'=>8),
			array('L'=>110,'C'=>8),
			array('L'=>100,'C'=>8),
			array('L'=>100,'C'=>8),
			array('L'=>113,'C'=>9),
			array('L'=>123,'C'=>14),
			array('L'=>123,'C'=>19),
			array('L'=>100,'C'=>22),
			array('L'=>60,'C'=>24),
			array('L'=>60,'C'=>25),
			array('L'=>100,'C'=>23),
			array('L'=>123,'C'=>19),
			array('L'=>123,'C'=>7)
		);

		//和孩子建立树形关系
		$res = array();
		foreach ($MapBorder as $key=>$val)
		{
			$i = 0;
			while ($i<$val['C'])
			{
				$point['x']=$val['L']+35*$i++;
				$point['y']=42*$key+35;
				$res[]=$point;
			}
		}
/*
		foreach ($res as $key=>$val)
		{
			echo $val['x'].','.$val['y'].'<br>';
		}
		dump($res);
		exit();
*/

		return $res;
	}
}
