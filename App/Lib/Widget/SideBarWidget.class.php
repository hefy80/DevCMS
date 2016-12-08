<?php
class SideBarWidget extends Widget {
    private function initMenu()
    {
		//初始化固定菜单
        $menu = array(
			'常用链接' => array(
				'module' => 'Index',
				'icon' => 'icon-home',
				'url' => __APP__.'/Index'
			),
			'通讯录' => array(
				'module' => 'Team',
				'icon' => 'icon-user',
				'url' => __APP__.'/Team'
			),
			'KPI' => array(
				'module' => 'Kpi',
				'icon' => 'icon-pencil',
				'url' => '#',
				'subcount' => 5,
				'submenu' => array(
						'考核标准' => array(
						'func'=>'kpi',
						'param'=>'',
						'value'=>''
					),
						'内部bug' => array(
						'func'=>'bug',
						'param'=>'type',
						'value'=>'0'
					),
						'外部bug' => array(
						'func'=>'bug',
						'param'=>'type',
						'value'=>'1'
					),
						'非正常' => array(
						'func'=>'line',
						'param'=>'lid',
						'value'=>'2'
					),
						'二线统计' => array(
						'func'=>'line2',
						'param'=>'',
						'value'=>''
					),
						'三线统计' => array(
						'func'=>'line3',
						'param'=>'',
						'value'=>''
					)
				)
			)
		);

		//初始化项目菜单
		$menu['项目'] = array(
			'module' => 'Project',
			'icon' => 'icon-th-large',
			'url' => '#',
			'subcount' => 2,
			'submenu' => array(
					'需求' => array(
					'func'=>'products',
					'param'=>'',
					'value'=>''
				),
					'项目' => array(
					'func'=>'projects',
					'param'=>'',
					'value'=>''
				)
			)
		);

 		//初始化配置管理的目录（文档、软件、设备等）
		unset($res);
		$doc = D('Doc');
		$res = $doc->getDirTree("");

		unset($menuTmp);
		$menuTmp['module']='Doc';
		$menuTmp['icon']='icon-folder-close';
		$menuTmp['subcount']=count($res['children']);
		foreach($res['children'] as $k => $v) 
		{
			$menuTmp['submenu'][$k]['func']='index';
			$menuTmp['submenu'][$k]['param']='path';
			$menuTmp['submenu'][$k]['value']=urlencode(base64_encode($v['path']));
		}
		$menu['配置管理']=$menuTmp;
//dump($menu['配置管理']);exit();
		return $menu;
	}

	public function render($data){
		$data['menu']=$this->initMenu();

		return $this->renderFile('',$data);
	}
}
?>
