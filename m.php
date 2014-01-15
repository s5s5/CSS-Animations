<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <title>PPT控制器</title>
    <meta name="author" content="s5s5"/>
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
    $arr['demo'] = 0;
}
if (!empty($_POST['prev'])) {
    $arr['num']--;
    $arr['demo'] = 0;
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
<button type="button" id="demo">显示DEMO</button>
<script src="js/jquery-2.0.3.min.js"></script>
<script>
    $(function () {
        $('#next').click(function () {
            $.post('m.php', 'next=true');
        });
        $('#prev').click(function () {
            $.post('m.php', 'prev=true');
        });
        $('#demo').click(function () {
            $.post('m.php', 'demo=true');
        });
    });
</script>
</body>
</html>
