<?php
namespace Libs;

/**
 * 验证码类
 */
class Captcha
{
    private $len;   //验证码长度
    private $font;  //字号大小 1,2,3,4,5
    private $width; //验证码图片宽度
    private $height;//验证码图片高度

    public function __construct($width=0, $height=0, $len=4, $font=5)
    {
        $this->initParam($width, $height, $len, $font);
    }

    /**
     * 初始化成员属性
     * @param int $width  验证码图片宽度
     * @param int $height 验证码图片高度
     * @param int $len    验证码长度
     * @param int $font   字号大小 1,2,3,4,5
     */
    private function initParam($width, $height, $len, $font)
    {
        $this->width = $width;
        $this->height = $height;
        $this->len = $len;
        $this->font = $font;
    }

    /**
     * 生成随机字符串
     * @return string
     */
//    private function createCode()
//    {
//        $char_array = array_merge(range('a','z'),range('A','Z'),range(0,9));
//        $index_array = array_rand($char_array,4);
//        shuffle($index_array);
//        $str='';
//        foreach ($index_array as $index) {
//            $str .= $char_array[$index];
//        }
//        $_SESSION['captcha'] = $str;
//        return $str;
//    }

    /**
     * 生成验证码
     */
    public function generalVerify()
    {
        /**
         * //4位验证码登录
         */
        //获取随机字符串
//        $str =  $this->createCode();
//        $img = imagecreate($this->width,$this->height);
//        imagecolorallocate($img,255,0,0);                               //给图片分配背景色
//        $x = (imagesx($img)-imagefontwidth($this->font)*strlen($str))/2;//起始位置x
//        $y = (imagesy($img)-imagefontheight($this->font))/2;	        //起始位置y
//        $color = imagecolorallocate($img,255,255,255);	                //验证码上字的颜色
//        imagestring($img,$this->font,$x,$y,$str,$color);
//		ob_start();
//        ob_clean();                         //清空缓存
//        header('content-type:image/jpeg');	//告知浏览器用jpeg格式解析
//        imagejpeg($img);			        //将图片按jpeg格式显示
//        imagedestroy($img);			        //销毁图片资源


        /**
         * 算数登录
         */
        $im = imagecreate($this->width, $this->height);

        //imagecolorallocate($im, 14, 114, 180); // background color
        $red = imagecolorallocate($im, 255, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);

        $num1 = rand(1, 20);
        $num2 = rand(1, 20);

        $_SESSION['helloweba_math'] = $num1 + $num2;

        $gray = imagecolorallocate($im, 118, 151, 199);
        $black = imagecolorallocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

        //画背景
        imagefilledrectangle($im, 0, 0, $this->width, $this->height, $black);
        //在画布上随机生成大量点，起干扰作用;
        for ($i = 0; $i < 80; $i++) {
            imagesetpixel($im, rand(0, $this->width), rand(0, $this->height), $gray);
        }

        imagestring($im, $this->font, 5, 9, $num1, $red);
        imagestring($im, $this->font, 30, 8, "+", $red);
        imagestring($im, $this->font, 45, 9, $num2, $red);
        imagestring($im, $this->font, 70, 8, "=", $red);
        imagestring($im, $this->font, 80, 8, "?", $white);

        header("Content-type: image/png");
        imagepng($im);
        imagedestroy($im);

    }

    /**
     * 检测验证码
     * @param $code
     * @return bool
     */
    public static function checkVerify($code)
    {
        //4位验证码登录
  //      return strtoupper($code) == strtoupper($_SESSION['captcha']);
        //算数登录
        return strtoupper($code) == strtoupper($_SESSION['helloweba_math']);

    }
}
