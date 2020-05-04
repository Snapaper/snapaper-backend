<?php

// 获取请求目的
switch ($_GET['cate']) {
	case 'igcse':
		$host = 'igcse';
		$title = '2019 F/M Series';
		break;

	case 'alevel':
		$host = 'alevel';
		$title = '2019 F/M Series';
		break;

	case 'ebooks':
		$host = 'ebooks';
		$title = 'Cambridge Textbooks (PDF)';
		break;

	case 'cdrom':
		$host = 'cdrom';
		$title = 'CD Resources';
		break;

	case 'sme':
		$host = 'sme';
		$title = 'SaveMyExams';
		break;
}

$sub = $_GET['sub'];
$hostdir = dirname(__FILE__).'/'.$host.'/'.$sub.'/';

// 要读取的文件夹
$url = '/case/'.$host.'/'.$sub.'/';

// 图片所存在的目录
$filesnames = scandir($hostdir);

// 得到所有的文件
$www = 'https://www.snapaper.com';

// 域名
$i = 0;

foreach ($filesnames as $name) {
	++$i;
	if ($i > 2) {
		if(strpos($name,'.pdf')){
			$type = 'PDF';
		}elseif(strpos($name,'.zip')){
			$type = 'ZIP';
		}elseif(strpos($name,'.rar')){
			$type = 'RAR';
		}else{
			$type = 'Unknown';
		}
		$array[] = array(
			'url' => $www.$url.$name,
			'name' => $name,
			'type' => $type
		);
	}
}

header('Access-Control-Allow-Origin:*');
header("Content-type: application/json");
header("Access-Control-Request-Methods:GET");
header('Access-Control-Allow-Headers:x-requested-with,content-type,test-token,test-sessid');

echo json_encode($array);
