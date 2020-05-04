<?php

	//Composer 依赖
	require 'xxx/autoload.php';
	use QL\QueryList;

	//判断用户名是否输入
	if( !empty($_GET['cate']) ) {

		/* 获取服务器源 */
		$com0 = 'https://papers.gceguide.com';
		$xyz1 = 'https://papers.gceguide.xyz';
		if(!isset($_COOKIE['snapaper_server'])){
			if(!empty($_GET['node'])){
				switch ($_GET['node']) {
					case '1':
						$source = $com0;
						break;
					case '2':
						$source = $xyz1;
						break;
					default:
						$source = $com0;
						break;
				}
			}else{
		    	$source = $com0;
			}
		}else{
			$source = $_COOKIE['snapaper_server'];
			if($source == '1'){
		    	$source = $com0;
			}elseif($source == '2'){
				$source = $xyz1;
			}else{
				$source = $com0;
			}
		}
		/* 结束获取服务器源 */
		
		$cate = $_GET['cate'];
		$url = $source.'/'.$cate;//生成查询页面
		$html = file_get_contents($url);
		$data = QueryList::html($html)->rules([
		'name' => ['tr>td>a','text']
		])->query()->getData();
		$user_data = array();
		$user_data['count'] = count($data->all());
		$user_data['cates'] = $data->all();
		
		header('Access-Control-Allow-Origin: *');
		header("Content-type: application/json");
		header("Access-Control-Request-Methods:GET");
		header('Access-Control-Allow-Headers:x-requested-with,content-type,test-token,test-sessid');
		
		echo json_encode($user_data);
		
}
?>