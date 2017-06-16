<?php
namespace Libs;

class UploadLibs{
    private $error;     //保存错误信息
    private $path;      //上传的文件路径
    private $size;      //允许上传文件的大小
    private $type;      //上传文件的类别
    public function __construct($path,$size,$type){
        $this->initParam($path,$size,$type);
    }
    //初始化成员
    private function initParam($path,$size,$type){
        $this->path=$path;
        $this->size=$size;
        $this->type=$type;
    }
    //显示错误信息
    public function getError(){
        return $this->error;
    }
    /*
     * 文件上传的方法
     * @param $file $_FILES[]对象
     */
    public function upload($file){
        $error=$file['error'];
        if($error!=0){
            switch($error){
                case 1:
                    $this->error='文件大小超过了配置文件允许的最大值'.ini_get('upload_max_filesize');
                    break;
                case 2:
                    $this->error='超过了表单允许的最大值';
                    break;
                case 3:
                    $this->error='只有部分文件上传，文件没有上传完';
                    break;
                case 4:
                    $this->error='没有上传文件，上传文件为空';
                    break;
                case 6:
                    $this->error='找不到临时文件';
                    break;
                case 7:
                    $this->error='写入失败';
                    break;
                default:
                    $this->error='未知错误';
            }
            return false;
        }
        //验证文件格式
        $finfo=finfo_open(FILEINFO_MIME_TYPE);
        $mime=finfo_file($finfo,$file['tmp_name']);
        if(!in_array($mime,  $this->type)){
            $this->error='错误的文件类型,允许上传的文件有'.implode(',',$this->type);
            return false;
        }
        //验证大小
        if($file['size']>$this->size){
            $this->error='文件不能超过'.  number_format($this->size/1024/1024,2).'M';
            return false;
        }
//        //验证是否是http上传
//        if(!is_uploaded_file($_FILES['image']['tmp_name'])){
//            $this->error='文件必须是HTTP上传';
//            return false;
//        }
        //创建文件夹
        $foldername=date('Y-m-d');      //文件夹名
        $folderpath=$this->path.$foldername;   //文件夹路径
        if(!file_exists($folderpath))
            mkdir($folderpath);
        $filepath=$foldername.'/'.uniqid('',true).strrchr($file['name'],'.');   //文件路径，格式 2017-3-4/test.jpg
        $path=  $this->path.$filepath;
        //文件上传
        if(move_uploaded_file($file['tmp_name'],$path))
            return $filepath;
        $this->error='文件上传失败';
        return false;
    }
}
