<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>PPT控制器</title>
    <meta name="author" content="s5s5">
    <style>
        html,body{margin:0; padding:0;}
        body{background-color:#000; color:#fff; text-align:center;}
        #next{width:300px; height:220px; background-color:#fff; color:#000; border:#0E0 dashed 3px; font-size:50px; margin:10px auto; display:block;}
        #prev,
        #demo{width:140px; height:100px; background-color:#eee; color:#000; border:#666 dashed 2px; font-size:20px; overflow:hidden;}
    </style>
</head>

<body>
<?php
function object_array($array) //对象转数组函数
{
    if(is_object($array))
    {
        $array = (array)$array;
    }
    if(is_array($array))
    {
        foreach($array as $key=>$value)
        {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

if (!@$f = fopen("control.json", "r")) { //无文件时创建
    echo "文件不存在！";
    $arr = array('num' => 9999, 'demo' => 0);
} else { // 打开文件
    $num = fgets($f);
    fclose($f);
    $arrO = json_decode($num); //json对象转PHP对象
    $arr = object_array($arrO); //对象转数组
}

if (!empty($_POST['next'])) {
    $arr['num']++;
}
if (!empty($_POST['prev'])) {
    $arr['num']--;
}
if (!empty($_POST['demo'])) {
    $arr['demo']++;
}

$num = json_encode($arr);
$ff = fopen("control.json", "w"); //写进json
fwrite($ff, $num);
fclose($ff);
?>
<button type="button" id="next">下一页</button>
<button type="button" id="prev">上一页</button>
<button type="button" id="demo">DEMO</button>
<script src="js/jquery-3.6.4.min.js"></script>
<script>
    $(function () {
        var sound = new Audio('piano.mp3');
        sound.play();
        $('#next').click(function () {
            $.post('m.php', 'next=true');
            sound.currentTime = 0;
            sound.play();
        });
        $('#prev').click(function () {
            $.post('m.php', 'prev=true');
            sound.currentTime = 0;
            sound.play();
        });
        $('#demo').click(function () {
            $.post('m.php', 'demo=true');
            sound.currentTime = 0;
            sound.play();
        });
    });
</script>
</body>
</html>
