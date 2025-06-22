<?php
// admin.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? "Family Album";
    $keywords = $_POST['keywords'] ?? "family, album, pictures, family pictures";
    $description = $_POST['description'] ?? "Family album is a collection of family pictures.";
    $prefix = $_POST['prefix'] ?? "https://jiatingshiguangxiangxiangce.oss-cn-beijing.aliyuncs.com/20230918%E5%A9%9A%E7%BA%B1%E7%85%A7/";
    $filePaths = $_POST['filePaths'] ?? "/Users/mac/Pictures/相册回忆/20230918婚纱 吴庆宝 精修/";
    $quality = $_POST['quality'] ?? "width_500_quality_60";

    $mockData = getMockData($filePaths, $prefix, 'all'); // Mock data for now

    $template = file_get_contents("./album_v2.htmll"); // 读取模板文件 首张图可用时秒显，后续图片分批加载，整个相册区域不会抖动、不会空白、体验顺滑
    $template = str_replace("{{title}}", $title, $template); // 替换标题
    $template = str_replace("{{keywords}}", $keywords, $template); // 替换关键字
    $template = str_replace("{{description}}", $description, $template); // 替换描述
    $template = str_replace("{{mockData}}", $mockData, $template); // 替换mock数据


    // 阿里云图片quality处理参数
    $x_oss_process_array = [
        'default' => [
            'label' => '默认',
            'value' => ''
        ],
        'width_900_quality_80' => [
            'label' => '标准（900宽/80质量）',
            'value' => '?x-oss-process=image/resize,w_900/quality,q_80'
        ],
        'width_500_quality_60' => [
            'label' => '快速（500宽/60质量）',
            'value' => '?x-oss-process=image/resize,w_500/quality,q_60'
        ],
        'width_1800_quality_100' => [
            'label' => '高清（1800宽/100质量）',
            'value' => '?x-oss-process=image/resize,w_1800/quality,q_100'
        ],
        'custom' => [
            'label' => '自定义',
            'value' => 'CUSTOM'
        ]
    ];
    if(isset($x_oss_process_array[$quality]['value'])){
          $x_oss_process = $x_oss_process_array[$quality]['value'];
    }else{
          $x_oss_process = $_POST['customOssParam'];
    }

    $template = str_replace("{{x_oss_process}}",  $x_oss_process, $template); // 替换x_oss_process数据

    // 输出模板 ../index.html
    $templatefile = $_POST['htmlFilePaths'];
    file_put_contents($templatefile, $template);

    echo "页面已更新";
}

// 获取模板数据替换
function getMockData($filePaths, $prefix, $type = 'all') {
    $data = array();
    $i = 1;
    $files = scandir($filePaths);

    foreach ($files as $file) {
        // 排除隐藏文件
        if ($file[0] == '.') {
            continue;
        }
        // 文件是图片，我想知道图片是横竖屏，所以用exif_read_data函数读取图片的属性
        if (is_file($filePaths . $file) && exif_imagetype($filePaths . $file)) {
            $imageInfo = getimagesize($filePaths . $file);
            if (isset($imageInfo[0]) && isset($imageInfo[1])) {
                $imageWidth = $imageInfo[0];
                $imageHeight = $imageInfo[1];
                $file =  rawurlencode($file);
                $imgUrl = $prefix . $file;
                $data_item = ["id" => $i++, "url" => $imgUrl, "img" => $imgUrl, "desc" => getRandomFamilyQuote()];
                $data['all'][] = $data_item;
                if ($imageWidth > $imageHeight) {
                    $data['width'][] = $data_item;
                } else {
                    $data['height'][] = $data_item;
                }
            }
        }
    }
    return json_encode($data[$type], true); // 返回json格式数据
}

// 随机获取一句家庭语录
function getRandomFamilyQuote() {
    $str = '餐桌的灯光下，唠嗑声把饭菜热了又热🍽️
    老相册里的褶皱，全是时光吻过的痕迹📸
    晚饭后的散步路，月光把我们的影子拉成了麻花💫
    哭鼻子时递来的纸巾，比任何礼物都珍贵🧻
    吵架后偷偷塞进我口袋的糖，甜到了心尖尖🍬
    那些没说出口的爱，都藏在睡前的 “晚安” 里🌙
    你的存在本身，就是我对抗世界的勇气💪
    就算全世界下雨，有你们在就是晴天🌦️→☀️
    把日子串成珍珠项链，每一颗都是 “今天” 💎
    成长是棵会结果的树，我们都是摘果子的人🍎
    日历撕到最后一页才发现，感动早把空白填满📅
    风会吹散落叶，但吹不散我们堆过的雪人⛄
    多年后再看今天，此刻正在发光呢✨
    你的酒窝里，盛着一整个春天的甜🍶
    牵手走过的路，连青苔都长得特别温柔🌿
    电话那头的 “没事”，是妈妈最暖的谎言👩❤️👧
    陪你长大的日子，我也偷偷变勇敢了✨
    生活偶尔会停电，但你们永远是我的备用电源⚡
    积木搭成的城堡里，住着不肯长大的童话🏰
    你画的全家福，太阳永远带着笑脸🌞
    冰箱里的剩菜饭，热一热还是家的味道🍚
    作业本上的红勾勾，是老师给的魔法印章✅
    夜空中最亮的星，正在听我们说悄悄话呢🌟';
    $arr = explode("\n", $str);
    // 去掉左右两边的空格
    $arr = array_map('trim', $arr);

    return $arr[array_rand($arr)];
}
?>
