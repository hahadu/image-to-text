# Img2Txt

图像转像素代码类:

$file_name = "test.jpg";
$chars = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";

$img2txt = new img2txt;
$img2txt->resize_img($file_name,$chars);
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
