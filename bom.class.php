<?php
/**
 * 批量去除文件头bom.
 * Author: Simon
 * E-mail: vsiryxm@qq.com
 * Date: 2015-8-5
 */

class Bom {
    static public $total = 0; //文件数统计
    static public $count = 0; //替换数统计

    protected $config = array(
        'auto' => 1,    // 是否自动替换 1为自动替换
        'dir'  => '.',  // 遍历的目录 默认当前
        'r'    => 1,    // 1为递归
    );

    function __construct(){
        if(isset($_REQUEST['auto'])){
            $this->config['auto'] = $_REQUEST['auto'];
        }
        if(!empty($_REQUEST['dir'])){
            $this->config['dir'] = $_REQUEST['dir'];
        }
        if(isset($_REQUEST['r'])){
            $this->config['r'] = $_REQUEST['r'];
        }
    }

    // 设置
    public function set($key,$value=''){
        if(isset($this->config[$key])){
            $this->config[$key] = $value;
        }
    }

    // 遍历目录下的文件并替换bom
    public function remove($curr_dir=''){
        $dir = !empty($curr_dir)?$curr_dir:$this->config['dir'];
        if($files = opendir($dir)) {
            ob_end_flush(); // 直接输出缓冲区内容
            while(($file = readdir($files)) !== false) {
                if($file != '.' && $file != '..'){
                    // 是目录 递归
                    if(is_dir($dir.DIRECTORY_SEPARATOR.$file) && $this->config['r']==1){
                        $this->remove($dir.DIRECTORY_SEPARATOR.$file);
                    }
                    elseif(!is_dir($dir.DIRECTORY_SEPARATOR.$file)){
                        self::$total++;
                        if($content = $this->checkBOM($dir.DIRECTORY_SEPARATOR.$file)){
                            if ($this->config['auto']==1){
                                $content = substr($content, 3);
                                $this->rewrite($dir.DIRECTORY_SEPARATOR.$file,$content);
                                echo '<span style=\'color:red\'>'.$dir.DIRECTORY_SEPARATOR.$file.' 已经替换!</span><br>'.PHP_EOL;
                                self::$count++;
                            }
                            else{
                                echo '<span style=\'color:red\'>'.$dir.DIRECTORY_SEPARATOR.$file.' 存在Bom!</span><br>'.PHP_EOL;
                            }
                        }
                        else{
                            echo $dir.DIRECTORY_SEPARATOR.$file.' 没有Bom!<br>'.PHP_EOL;
                        }
                    }
                }
                flush();
                //sleep(1);
            }
            closedir($files);
        }
        else{
            echo '检查路径不存在！';
        }
    }

    // 检查Bom
    public function checkBOM($filename){
        $content = file_get_contents($filename);
        if(!empty($content)){
            $charset[1] = substr($content, 0, 1);
            $charset[2] = substr($content, 1, 1);
            $charset[3] = substr($content, 2, 1);
            if (ord($charset[1])==239 && ord($charset[2])==187 && ord($charset[3])==191){
                return $content;
            }
        }
        return false;
    }

    // 重写文件
    public function rewrite($filename, $data){
        $file = fopen($filename, "w");
        flock($file, LOCK_EX);
        fwrite($file, $data);
        fclose($file);
    }

}

////////////////////////////////////////////////
//执行
$bom = new Bom();
//$bom->set('auto',1);
//$bom->set('dir','./test');
//$bom->set('r',1);
echo <<<EOF
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="UTF-8" />
<title></title>
<meta name="author" content="Simon(QQ42564096)" />
<style>
body,h1,div{margin:0;padding:0;font:14px/1.5 'Microsoft Yahei',tahoma,arial;}
.process {width:800px;height:750px;padding:20px;border:1px solid #ddd;overflow:scroll;margin-left:20px;line-height:180%;}
h1{font-size:25px;text-indent:20px;margin:20px 0 10px 0;}
</style>
</head>
<body>
<h1 id='result'>开始检查Bom...</h1>
<div class='process'>
EOF;

$bom->remove();

echo '<script>document.getElementById(\'result\').innerHTML = \'检测完毕！共有'.Bom::$total.'个文件，替换了'.Bom::$count.'个文件\';</script>';
echo <<<EOF
</div>
</body>
</html>
EOF;
$bom = null;
?>

