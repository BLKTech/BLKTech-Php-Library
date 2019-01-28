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
);

$ok = true;
foreach($clasess as $class)
{
    $url = $server . '/' . $class . '.php';
    $file = $libsPath . '/' . $class . '.php';
    $dir = dirname($file);

    error_log("================================ Install Class ================================");
    error_log(" DIR:\t\t$dir");           
    error_log("FILE:\t\t$file");
    error_log(" URL:\t\t$url");

    if(!(is_dir($dir) || mkdir($dir, 0777, true)))
    {
        error_log("Create Directory ERROR");
        $ok = FALSE;        
        continue;
    }    
    
    $data = file_get_contents($url . '?time=' . time());
    if($data===FALSE)
    {
        error_log("Download ERROR");
        $ok = FALSE;
        continue;
    }
    
    if(file_put_contents($file, $data)===FALSE)
    {
        error_log("Write ERROR");
        $ok = FALSE;        
        continue;
    }            
    
    require_once $file;
    error_log('OK');
}
error_log("================================ Install Finished ================================");
if($ok)
{
    error_log("OK");
    $loader = BLKTech\Loader\Loader::getInstance();
    $loader->register();
    \BLKTech\Logger\Console::getInstance()->info('Core Ready');
}
else
    error_log("ERROR");