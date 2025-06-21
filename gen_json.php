<?php
// gen_json.php
$dir = __DIR__ . '/photos';
$web_prefix = '/photos/'; // 浏览器访问图片前缀

$list = [];
foreach (glob($dir.'/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE) as $file) {
    $basename = basename($file);
    $mtime = filemtime($file);
    // 获取图片名称.通过.分割取出文件名
    $img_name = explode('.', $basename);
    $img_name = $img_name[0];
    // 根据图片名称 生成url
    $url = './cache/'.$img_name . '.html';
    // 判断文件是否存在
    if (file_exists($url)) {
        $url = '/cache/'.$img_name . '.html';
    }else{
        $url = '/album/admin.html?cachename='.$img_name;
    }
    $list[] = [
        'src' => $web_prefix . $basename,
        'desc' => $img_name, // 你也可以用同名txt/md文件提取描述
        'date' => date('Y-m-d H:i:s', $mtime),
        'title' => $basename,
        'link'=> $url
    ];
}
usort($list, function($a,$b){ return strcmp($b['date'], $a['date']); }); // 按时间倒序
file_put_contents(__DIR__.'/photos.json', json_encode($list, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
echo "ok, 共生成 ".count($list)." 张照片";