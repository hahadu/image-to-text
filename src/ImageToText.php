<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/9 下午2:28
 *  +----------------------------------------------------------------------
 *  | Description:   图片转代码类
 *  +----------------------------------------------------------------------
 **/
namespace Hahadu\ImageToText;
class ImageToText{
    private $chars = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";
    public function __construct($chars=''){
        if(!empty($chars)){
            $this->chars = $chars;
        }
    }

    /****
     * @param string $file_name 图像路径
     * @return string
     */
    public function to_text($file_name , $flage=true){
        $image_data = $this->resize_img($file_name,$flage);
        $width =imagesx($image_data); //获取图像宽度
        $height=imagesy($image_data); //获取图像高度

        $result="";
        for($i=1;$i<=$height;$i++){
            for($j=1;$j<=$width;$j++){
                $color_index = imagecolorat($image_data, $j-1, $i-1);     //获取单个像素偏移量色值
                $color_tran = imagecolorsforindex($image_data, $color_index);  //获取像素颜色
                $result.=$this->color_img($color_tran);
            }
            $result.="<br/>";
        }
        return $result;
    }
    function getimgchars($color_tran){
          $length = strlen($this->chars);
          $alpha=$color_tran['alpha'];
          $r=$color_tran['red'];
          $g=$color_tran['green'];
          $b=$color_tran['blue'];
          $gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b);

          if($gray==0){
              return '.';
          }

          if($gray<196){
               $unit = (256.0 + 1)/$length;
              return $this->chars[intval($gray/$unit)];
          }
         return " ";
    }
    function color_img($color_tran){
          $length = strlen($this->chars);
          $alpha=$color_tran['alpha'];

          $r=$color_tran['red'];
          $g=$color_tran['green'];
          $b=$color_tran['blue'];
          $gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b); //变量转换成整型
          $rand=rand (0,  $length-1);
          $color="rgb(".$r.",".$g.",".$b.")";
          $char = substr($this->chars, $rand,1);
          return '<span style="color:'.$color.'" >'.$char."</span>";;

    }
    function resize_img($file_name,$flage=true){
          //header('Content-Type: image/jpeg');
          list($width, $height,$type) = getimagesize($file_name); //获取图片的长宽
          $fun='imagecreatefrom' . image_type_to_extension($type, false); //获取图片后缀
          if($type==3){
              $flage=false;
          }
          $fun($file_name);
          $new_height =40;
          $percent=$height/$new_height;
          $new_width=$width/$percent*2;
          $image_p = imagecreatetruecolor($new_width, $new_height); //创建图像标示符
          $image = $fun($file_name);
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);//压缩图像
          if($flage){
              return $image_p;
          }else{
              return $image;
          }
    }
}
