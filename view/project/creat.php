<?php
$data = $data['data'];
$site_config = $data['site_config'];
$projectset_info = $data['projectset'];
$college_list = $data['college'];
$prompt = $data['prompt'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['title'];?>-创建项目</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo Html::get_instance()->stylesheet(
array(
'media/css/base',
'media/css/style',
'media/css/ui-lightness/jquery-ui'
)); 
?>
<?php
echo Html::get_instance()->script(
array(
'media/js/jquery',
'media/js/jquery-ui'
)); 
?>
</head>
<body>
<form action="<?php echo WEBPATH;?>project/pcreat?pid=<?php echo $projectset_info['pid'];?>" method="post" id="creat_project_form">
	<div class="contanter">
    	<div class="prj_title prj_title_l">
        	<h1>创建项目申报表单</h1>
<?php
if ($prompt != '') {
?>
<div class="pro_tip f12"><?php echo $prompt;?></div>
<?php
} 
?>
        </div>
        <div class="pro_create">
        	<ul class="pro_c_ul">
        		<li>
                	<span class="pro_c_t">所属项目集</span>
                    <div class="pro_c_c">
                    <?php echo $projectset_info['pname'];?>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <!-- 
            	<li>
                	<span class="pro_c_t">项目ID：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200" />
                    <span class="pro_p_r fl"><em class="pro_t_num">(0/50)</em></span>
                    <div class="clearfix"></div>
                    </div>
                </li>
                 -->
                <li>
                	<span class="pro_c_t">项目名称：</span>
                     <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" name="name" />
                    <div class="clearfix"></div>
                     <div class="pro_tip f12">此名称将用于学校公告的标题，如"本学期全校课题申报项目正式启动"</div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目类型：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" name="type" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目来源：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" name="source" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目级别：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" name="level" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">申报方式：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" name="report_way" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">项目所属院系：</span>
                    <div class="pro_c_c">
                    <select class="fl mr20 w160" name="college">
<?php
foreach ($college_list as $key => $val) { 
?>
<option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
<?php 
}
?>
                    </select>
                    <!-- <span class="pro_p_r fl"><a href="" class="f12">添加分类</a></span> -->
                    <div class="clearfix"></div>
                    </div>
                </li>
                 <li>
                	<span class="pro_c_t">结题预期：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl mr20 w200 pro_in_txt" id="over_expect" name="over_expect" />
                    <script type="text/javascript">$(function() { $("#over_expect").datepicker({ currentText: 'Now',dateFormat: "yy-mm-dd" }); });</script>
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">负责人姓名：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl w200 mr20" name="realname" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">指导教师姓名：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl w200" name="teacher_name" />
                    <div class="clearfix"></div>
                    </div>
                </li>
                <!-- 
                 <li>
                	<span class="pro_c_t">经费预算：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl w200" />
                   
                    <div class="clearfix"></div>
                    </div>
                </li>
                <li>
                	<span class="pro_c_t">提交标志：</span>
                    <div class="pro_c_c">
                    <input type="text" class="fl w200" />
                   
                    <div class="clearfix"></div>
                    </div>
                </li>
                 -->
            </ul>
            <div class="pro_actoin">
            	<a href="javascript:;" class="pro_btn_s1" onclick="$('#creat_project_form').submit();">正式发布</a>
            	<a href="<?php echo WEBPATH;?>projectset/pshow?id=<?php echo $projectset_info['pid']?>" class="pro_btn_s2">返回项目集</a> 
            	<!-- <a href="" class="pro_btn_s2">暂时保存</a> -->
            </div>
        </div>
    </div>
</form>
</body>
</html>