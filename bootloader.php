<?php

$server = 'https://psr0.blktech.org';
$libsPath = __DIR__;

$clasess = array(
         'BLKTech/DesignPattern/Singleton',
         'BLKTech/DataType/Path',
         'BLKTech/DataType/HashTable',
         'BLKTech/DataType/Query',
         'BLKTech/DataType/Service',
         'BLKTech/DataType/URL',
         'BLKTech/Loader/Library',
         'BLKTech/Loader/Loader',
         'BLKTech/Loader/PreLoader'
);

$ok = true;
foreach($clasess as $class) {
    $url = $server . '/' . $class . '.php';
    $file = $libsPath . '/' . $class . '.php';
    $dir = dirname($file);

    if(!file_exists($file) || time() - filemtime($file) > 3600) {

        error_log("================================ Install Class ================================");
        error_log(" DIR:\t\t$dir");
        error_log("FILE:\t\t$file");
        error_log(" URL:\t\t$url");

        if(!(is_dir($dir) || mkdir($dir, 0777, true))) {
            error_log("Create Directory ERROR");
            $ok = false;
            continue;
        }

        $data = file_get_contents($url . '?time=' . time());
        if($data === false) {
            error_log("Download ERROR");
            $ok = false;
            continue;
        }

        if(file_put_contents($file, $data) === false) {
            error_log("Write ERROR");
            $ok = false;
            continue;
        }

        error_log('OK');
    }


}

if($ok) {
    require_once $libsPath . '/BLKTech/Loader/PreLoader.php';
    \BLKTech\Logger::getInstance()->debug("================================ BootLoader Finished ================================");
} else {
    error_log('BootLoader Failed');
}
