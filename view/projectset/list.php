<?php
$data = $data['data'];
$site_config = $data['site_config'];
$list = $data['data'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['title'];?></title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo Html::get_instance()->stylesheet(
array(
'media/css/base',
'media/css/style'
)); 
?>
<?php
echo Html::get_instance()->script(
array(
)); 
?>
</head>
<body>
	<div class="contanter">
    	<div class="prj_title">
        	<h1>项目集列表</h1>
        </div>
        <div class="table_list">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                <tr>
                	<th>项目ID</th><th>标题</th><th>隶属年份</th><th>项目分类</th><th>操作</th>
                </tr>
                </thead>
                <tbody>
<?php
for ($i = 0; $i < count($list); $i++) { 
?>
<tr>
<td><?php echo $list[$i]['pid']?></td><td><?php echo $list[$i]['pname']?></td><td><?php echo $list[$i]['pyear']?></td><td><?php echo $list[$i]['ptype']?></td><td><a href="<?php echo WEBPATH;?>projectset/pshow?id=<?php echo $list[$i]['pid']?>">详细</a>&nbsp;&nbsp;<a href="<?php echo WEBPATH;?>project/pcreat?pid=<?php echo $list[$i]['pid']?>">创建</a></td>
</tr>
<?php
} 
?>
                </tbody>
            </table>
            <!-- <div class="prj_pages">
           		 <a href="" class=" f12">上一页</a> <span class="f12">2/3</span> <a href="" class="f12">上一页</a>
            </div> -->
           
        </div>
    </div>
</body>
</html>