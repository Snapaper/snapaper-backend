<?php

// 动态获取图片
if (!empty($_GET['place'])) {
    
    switch ($_GET['place']) {
        case 'index_1':
            $image = file_get_contents("images/teacher.png");
            break;
        case 'index_2':
            $image = file_get_contents("images/ribbon.png");
            break;
        case 'index_3':
            $image = file_get_contents("images/school.png");
            break;
        case 'index_4':
            $image = file_get_contents("images/library.png");
            break;
        case 'index_5':
            $image = file_get_contents("images/shapes.png");
            break;
        case 'index_6':
            $image = file_get_contents("images/money.png");
            break;
    }

    header('Content-type: image/jpg');
    echo $image;

}
