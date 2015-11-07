<?php
 
class Captcha
{
    public $checkcode;
    private $width;
    private $height;
    private $codeNum;
    private $code;
    private $im;
 
    function __construct($width=80, $height=20, $codeNum=4)
    {
        $this->width = $width;
        $this->height = $height;
        $this->codeNum = $codeNum;
    }
 
    function showImg()
    {
        //创建图片
        $this->createImg();
        //设置干扰元素
        $this->setDisturb();
        //设置验证码
        $this->setCaptcha();
        //输出图片
        $this->outputImg();
    }
 
 
    private function createImg()
    {
        $this->im = imagecreatetruecolor($this->width, $this->height);
        $bgColor = imagecolorallocate($this->im, 255, 255, 255);
        imagefill($this->im, 0, 0, $bgColor);
    }
 
    private function setDisturb()
    {
        $area = ($this->width * $this->height) / 20;
        $disturbNum = ($area > 80) ? 80 : $area;
        //加入点干扰
        for ($i = 0; $i < $disturbNum; $i++) {
            $color = imagecolorallocate($this->im, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($this->im, rand(1, $this->width - 2), rand(1, $this->height - 2), $color);
        }
        //加入弧线
        for ($i = 0; $i <= rand(4,6); $i++) {
            $color = imagecolorallocate($this->im, rand(150, 180), rand(150, 180), rand(150, 200));
            imagearc($this->im, rand(0, $this->width), rand(0, $this->height), rand(30, 300), rand(20, 200), 50, 30, $color);
        }
    }
 
    private function createCode()
    {
        $str = "0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";
       
        for ($i = 0; $i < $this->codeNum; $i++) {
            $this->code .= $str{rand(0, strlen($str) - 1)};
        }
		$this->checkcode=strtolower($this->code);
    }
 
    private function setCaptcha()
    {
        $this->createCode();
 
        for ($i = 0; $i < $this->codeNum; $i++) {
            $color = imagecolorallocate($this->im, rand(50, 150), rand(50, 150), rand(50, 150));
            $size = rand(14, 16);
            $x = floor($this->width / $this->codeNum) * $i + 8;
            $y = $size+($this->height-$size)/2+rand(-3, 3);
            imagettftext($this->im, $size,rand(-40,40), $x, $y,  $color,PATH_CMS.'/sys/fonts/font.ttf',$this->code{$i});
        }
    }
 
    private function outputImg()
    {
      //  if (imagetypes() & IMG_JPG) {
            header('Content-type:image/png');
            imagepng($this->im);
      //  } else {
      //      die("Don't support image type!");
      //  }
    }
 
}?>