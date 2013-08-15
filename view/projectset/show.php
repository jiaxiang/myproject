<?php
$data = $data['data'];
$site_config = $data['site_config'];
$list = $data['data']
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
    	<div class="prj_title prj_title_l">
        	<h1>项目集-<?php echo $list['pname']?>介绍</h1>
        </div>
        <div class="pro_detail">
        	<div class="prode_title">
            	<h2><?php echo $list['pname']?></h2>
            </div>
            <p>项目集描述：</p>
            <p><?php echo $list['pprofile']?></p>
            <ul>
            	<li>隶属年度：<?php echo $list['pyear']?></li>
                <li>项目类型：<?php echo $list['ptype']?></li>
                <li>创建时间：<?php echo $list['ptime']?></li>
            </ul>
            <p>项目集总结：</p>
            <p><?php echo $list['psummary']?></p>
        </div>
        <div class="pro_actoin pro_actoin_det">
            	<a href="<?php echo WEBPATH;?>projectset/plist" class="pro_btn">返回列表</a> 
            	<a href="<?php echo WEBPATH;?>project/plist?pid=<?php echo $list['pid']?>" class="pro_btn">查看项目</a> 
            	<a href="<?php echo WEBPATH;?>project/pcreat?pid=<?php echo $list['pid']?>" class="pro_btn">创建项目</a>
            </div>
    </div>
</body>
</html>