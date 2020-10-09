# ImageToText 
# 图像转像素代码类

安装：

composer require hahadu/image-to-text

使用：

```
use Hahadu\ImageToText\ImageToText;

$file_name = "test.jpg"; //图像路径
$chars = "01"; //设置转换字符
$toText = new ImageToText($chars);
$result = $toText->to_text($file_name);
var_dump($result);
```

* 2020.10.09：简化类库使用流程

