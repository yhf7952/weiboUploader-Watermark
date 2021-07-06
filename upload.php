<?php
//ini_set('display_errors',1);            //错误信息  
//ini_set('display_startup_errors',1);    //php启动错误信息  
//error_reporting(-1);                    //打印出所有的 错误信息
error_reporting(0);                    //不显示错误信息

// include composer autoload
require 'vendor/autoload.php';

$wbUser = "微博用户名";
$wbPwd = "微博密码";

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

// configure with favored image driver (gd by default)
Image::configure(array('driver' => 'gd'));

if(($_FILES["file"]["size"] > 20*1024*1024)){
    die('限制20M');
}

// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$allowedTypes = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg","image/x-png","image/png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if(!in_array($extension, $allowedExts) || !in_array($_FILES["file"]["type"], $allowedTypes)){
    die("非法的文件格式");
}

if ($_FILES["file"]["error"] > 0){
    die("错误：: " . $_FILES["file"]["error"]);
}

$img = Image::make($_FILES['file']['tmp_name']);

$WmWidth = $_COOKIE["WmWidth"] ?? 800;
$WmHeight = $_COOKIE["WmHeight"] ?? 0;
// resize image
$img->resize($WmWidth>0 ? $WmWidth : null , $WmHeight >0 ? $WmHeight : null, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
});

//启用水印时，插入水印
if ($_COOKIE["WmEnable"] == "on"){
    $postion = $_COOKIE["WmPostion"] ?? "bottom-right";
    $url = $_COOKIE["WmUrl"] ?? "https://yantuz.cn/wp-content/uploads/2018/03/logourl.png";
    $opacity = $_COOKIE["WmOpacity"] ?? 50;
    $WaterMark = Image::make($url)->opacity((int)$opacity);
    $img->insert($WaterMark,$postion,10,10);
}
// save image
//$WmImg = $img->response();
$dir = 'upload';//.Date('Y/m');
if(!is_dir($dir))
    mkdir($dir,0777,true);
$WmImg = $dir.'/'.uniqid().'.'.$extension;
//$img->save("upload/aa.jpg");
$img->save($WmImg);

//error_log($_POST["pin"],3,"upload/log.txt");
//开始上传微博
$weibo = new Consatan\Weibo\ImageUploader\Client();
//$url = $weibo->upload($WmImg, '微博帐号', '微博密码');

$url = $weibo->upload($WmImg, $wbUser, $wbPwd);
//删除文件
unlink($WmImg);

echo json_encode($url);

// try{
//     if($weibo->login($wbUser, $wbPwd, ($_POST["pin"] ?? true))){
//         $url = $weibo->upload($WmImg, $wbUser, $wbPwd);
//         echo json_encode($url);
//     }
// }catch (Consatan\Weibo\ImageUploader\Exception\RequirePinException $e) {
//     $img = Image::make($e->getMessage());
//     $img->save("upload/pin.png");
//     header("HTTP/1.1 503 error");
//     echo json_encode("pin");
// }

?>
