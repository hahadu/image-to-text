<?php
/****
 *图片转代码类
 *CSDN @jiay2
 *github @ hahadu
 *QQ 582167246
 */
namespace Hahadu\img2txt; 
class img2txt{
  function getimgchars($color_tran,$chars){
	  $length = strlen($chars);
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
		  return $chars[intval($gray/$unit)];
	  }
	   
	 return " ";
   
  }
   
  function color_img($color_tran,$chars){
	  $length = strlen($chars);
	  $alpha=$color_tran['alpha'];
	   
	  $r=$color_tran['red'];
	  $g=$color_tran['green'];
	  $b=$color_tran['blue'];
	  $gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b); //变量转换成整型
	  $rand=rand (0,  $length-1);
	  $color="rgb(".$r.",".$g.",".$b.")";
	  $char = substr($chars, $rand,1);
	  return '<span style="color:'.$color.'" >'.$char."</span>";;
	   
  }
   
   
   
  function resize_img($file_name,$chars,$flage=true){
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

/*
 *demo
 *
 */
 /*
            $file_name = "test.jpg";
			$chars = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";
 		  $im=$img2txt->resize_img($file_name,$chars); //获取图像信息
		   
		  $width=imagesx($im); //获取图像宽度
		  $height=imagesy($im); //获取图像高度
		   
		  $back_text="";
		  for($i=1;$i<=$height;$i++){
			  for($j=1;$j<=$width;$j++){
				  $color_index = imagecolorat($im, $j-1, $i-1);     //获取单个像素偏移量色值
				  $color_tran = imagecolorsforindex($im, $color_index); //获取像素颜色
				  $back_text.=$img2txt->color_img($color_tran,$chars,false);
			  }
			  $back_text.="<br/>";
		  }
        var_dump($back_text);
*/
