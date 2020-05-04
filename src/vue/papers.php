<?php

//Composer 依赖
require 'xxx/autoload.php';
use QL\QueryList;

/* 获取服务器源 */
$com0 = 'https://papers.gceguide.com';
$xyz1 = 'https://papers.gceguide.xyz';
if (!isset($_COOKIE['snapaper_server'])) {
	if (!empty($_GET['node'])) {
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
	} else {
		$source = $com0;
	}
} else {
	$source = $_COOKIE['snapaper_server'];
	if ($source == '1') {
		$source = $com0;
	} elseif ($source == '2') {
		$source = $xyz1;
	} else {
		$source = $com0;
	}
}
/* 结束获取服务器源 */

//判断参数是否输入
if (!empty($_GET['cate']) && !empty($_GET['sub'])) {

	$cate = $_GET['cate'];
	$sub = $_GET['sub'];

	if ($cate == 'A Levels' && $sub == 'Business Studies (9707)') {
		$url = $com0 . '/A%20Levels/Business%20Studies%20%20(9707)'; //生成商业查询页面(下方格式爬取失败)
	} elseif ($cate == 'A Levels' && $sub == 'English - Language AS and A Level (9093)') {
		$url = $com0 . '/A%20Levels/English%20-%20Language%20AS%20and%20A%20Level%20%20(9093)/'; //生成商业查询页面(下方格式爬取失败)
	} else {
		$url = $source . '/' . $cate . '/' . $sub; //生成查询页面
	}

	$html = file_get_contents($url);
	$data = QueryList::html($html)->rules([
		'name' => ['tr>td>a', 'text'],
		'url' => ['tr>td>a', 'href']
	])->query()->getData();
	$user_data = array();
	$user_data['count'] = count($data->all());
	$i = 0;

	foreach ($data->all() as $item) {
		if ($item['name'] !== 'error_log') {
			$i += 1;

			// Key 字段
			$item['key'] = $i;

			// Info 字段
			if (strpos($item['name'], 'ms')) {
				$item['info'] = ['Mark Scheme'];
			} elseif (strpos($item['name'], 'qp')) {
				$item['info'] = ['Question Paper'];
			} elseif (strpos($item['name'], 'er')) {
				$item['info'] = ['Examiner Report'];
			} elseif (strpos($item['name'], 'ir') || strpos($item['name'], 'ci')) {
				$item['info'] = ['Confidential Instruction'];
			} elseif (strpos($item['name'], 'gt')) {
				$item['info'] = ['Grade thresholds'];
			} elseif (strpos($item['name'], 'Data_Booklet')) {
				$item['info'] = ['Data Booklet'];
			} elseif (strpos($item['name'], 'sci')) {
				$item['info'] = ['Specimen Confidential Instruction'];
			} elseif (strpos($item['name'], 'sp') || strpos($item['name'], 'sm')) {
				$item['info'] = ['Specimen Paper'];
			} elseif (strpos($item['name'], 'in')) {
				$item['info'] = ['Insert'];
			} else {
				$item['info'] = ['Unknown'];
			}


			// Type 字段
			if (strpos($item['name'], '.pdf')) {
				$item['type'] = 'PDF';
			} elseif (strpos($item['name'], '.mp3')) {
				$item['type'] = 'MP3';
			} elseif (strpos($item['name'], '.docx')) {
				$item['type'] = 'DOC';
			} else {
				$item['type'] = 'Unknown';
			}

			// Url 字段
			if (!strpos($item['url'], 'Levels') && !strpos($item['url'], 'IGCSE')) {
				if ($source == $xyz1) {
					$item['url'] = $url . $item['url'];
				} else {
					$item['url'] = $url . '/' . $item['url'];
				}
			} else {
				$item['url'] = $source . $item['url'];
			}

			$paperArray[] = $item;
		}
	}
	$user_data['papers'] = $paperArray;
	
	header('Access-Control-Allow-Origin:*');
	header("Content-type: application/json");
	header("Access-Control-Request-Methods:GET");
	header('Access-Control-Allow-Headers:x-requested-with,content-type,test-token,test-sessid');

	echo json_encode($user_data);

} ?>