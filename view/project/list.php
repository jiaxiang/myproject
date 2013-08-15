<?php
$data = $data['data'];
$site_config = $data['site_config'];
$list = $data['data']['data'];
$page = $data['data']['page'];
$projectset = $data['projectset'];
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
        	<h1><?php echo $projectset['pname']?>项目集中的项目列表</h1>
        </div>
        <div class="table_list">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                <tr>
                	<th>项目ID</th><th>项目名称</th><th>项目类型</th><th>项目级别</th><th>所属院系</th><th>负责人姓名</th><th>操作</th>
                </tr>
                </thead>
                <tbody>
<?php
for ($i = 0; $i < count($list); $i++) { 
?>
<tr>
<td><?php echo $list[$i]['id']?></td><td><?php echo $list[$i]['name']?></td><td><?php echo $list[$i]['type']?></td><td><?php echo $list[$i]['level']?></td><td><?php echo $list[$i]['college']?></td><td><?php echo $list[$i]['realname']?></td><td><a href="<?php echo WEBPATH;?>project/pshow?id=<?php echo $list[$i]['id']?>">查看详细</a></td>
</tr>
<?php 
}
?>
                </tbody>
            </table>
           <div class="prj_pages">
           <?php echo $page;?>
           		 <!-- <a href="" class=" f12">上一页</a> <span class="f12">2/3</span> <a href="" class="f12">上一页</a> -->
            </div>
        </div>
        <div class="pro_actoin">
            	<a href="<?php echo WEBPATH;?>projectset/pshow?id=<?php echo $projectset['pid']?>" class="pro_btn_s1">返回项目集</a>
            </div>
    </div>
</body>
</html>