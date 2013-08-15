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
        	<h1><?php echo $list['name']?>-项目详细</h1>
        </div>
        <div class="pro_create">
        	<ul class="pro_c_ul">
            	<li>
                	<span class="pro_c_t">项目ID：</span>
                    <div class="pro_c_c">
                    <span class="pro_p_r fl"><?php echo $list['id']?></span>
                    <div class="clearfix"></div>
               
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目名称：</span>
                     <div class="pro_c_c">
                      <span class="pro_p_r fl"><?php echo $list['name']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目类型：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl"><?php echo $list['type']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目来源：</span>
                    <div class="pro_c_c">
                   <span class="pro_p_r fl"><?php echo $list['source']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目级别：</span>
                    <div class="pro_c_c">
                   <span class="pro_p_r fl"><?php echo $list['level']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">申报方式：</span>
                    <div class="pro_c_c">
                    <span class="pro_p_r fl"><?php echo $list['report_way']?></span>
                   
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目所属院系：</span>
                    <div class="pro_c_c">
                    <span class="pro_p_r fl"><?php echo $list['college']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                 <li>
                	<span class="pro_c_t">结题预期：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl"><?php echo $list['over_expect']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">负责人姓名：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl"><?php echo $list['realname']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">指导教师姓名：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl"><?php echo $list['teacher_name']?></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <!-- 
                 <li>
                	<span class="pro_c_t">经费预算：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl">35000</span>
                   
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">提交标志：</span>
                    <div class="pro_c_c">
                     <span class="pro_p_r fl">已提交</span>
                   
                    <div class="clearfix"></div>
                    </div>
                </li>
                 -->
            </ul>
            <div class="pro_actoin">
            	<a href="<?php echo WEBPATH;?>project/plist?pid=<?php echo $list['pid']?>" class="pro_btn_s1">返回列表</a>
            </div>
        </div>
    </div>
</body>
</html>