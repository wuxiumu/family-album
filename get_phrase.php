<?php
// get_phrase.php
$dir = __DIR__ . '/phrases';
$all = [];

// 支持多个 md 文件，每行一言（可自定义分隔符，这里用换行和“---”隔开都支持）
foreach (glob($dir.'/*.md') as $file) {
    $txt = file_get_contents($file);
    $lines = preg_split('/[\r\n]+/', $txt);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line && !preg_match('/^#|^---|^\*/', $line)) {
            $all[] = $line;
        }
    }
}
if (!$all) exit('No phrases');
shuffle($all);
echo $all[0];