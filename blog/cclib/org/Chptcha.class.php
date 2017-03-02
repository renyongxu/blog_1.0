<?php
header('content-type:text/html;charset=utf-8');
class Chptcha{
    //画布宽度
    private $width=60;
    //画布高度
    private $height=28;
    //验证码字符长度
    private $chars=4;
    //干扰线数目
    private $lines=1;
    //干扰点数目
    private $spots=200;

    public function generate(){
        //制作画布
        $img=imagecreatetruecolor($this->width,$this->height);
        //在画布资源下分配颜色，经验，画布颜色要明亮点
        $bg=imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        //给画布填充颜色
        imagefill($img,0,0,$bg);
        //增加验证码（获取验证码）
        $captcha=$this->getCaptcha();
        //将获取的验证码字符存放在session文件中，用作以后和登陆页面输入的验证码做比较
        $_SESSION["SafeCode"] = $captcha;
        //为验证码字符串设定为随机颜色
        $str=imagecolorallocate($img,mt_rand(50,100),mt_rand(50,100),mt_rand(50,100));
        //获取随机位置
        //宽度: 使用图片宽度减去文件宽度
        $e_width = $this->width - $this->chars * 10 - 5;
        $e_height = $this->height/3;
        //5，代表的是字体的大小
        imagestring($img,5,mt_rand(10,$e_width),mt_rand($e_height-1,$e_height),$captcha,$str);
        $this->getLines($img);
        $this->getPixels($img);
        header('content-type:image/png');
        imagepng($img);
        //释放资源
        imagedestroy($img);
    }
    private function getCaptcha(){
        //产生随机字符串
        $str = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';
        for($i = 0;$i < $this->chars;$i++){
            //每次循环产生一个字符， $captcha. 加"."号表示这几个字符是连接在一起的
            $captcha.= $str[mt_rand(0,strlen($str) - 1)];
        }
        //返回
        return $captcha;
    }
    private function getLines($img){
        //增加干扰线
        for($i = 0;$i < $this->lines;$i++){
            //分配颜色
            $line= imagecolorallocate($img,mt_rand(100,200),mt_rand(100,200),mt_rand(100,200));
            //制作线段
            imageline($img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$line);
        }
    }
    private function getPixels($img){
        //增加干扰点
        for($i = 0;$i < $this->spots;$i++){
            //分配颜色
            $pixel= imagecolorallocate($img,mt_rand(100,200),mt_rand(100,200),mt_rand(100,200));
            //制作
            imagesetpixel($img,mt_rand(0,$this->width),mt_rand(0,$this->height),$pixel);
        }
    }
}
?>