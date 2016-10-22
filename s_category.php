<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<?php

	
	include "../include/config.php";
	
	
	
	function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
{

	global $dbcon;
	
    static $res = NULL;

    if ($res === NULL)
    {
        $sql = "SELECT c.*, COUNT(s.cat_id) AS has_children ".
                "FROM ecs_category AS c ".
                "LEFT JOIN ecs_category AS s ON s.parent_id=c.cat_id ".
                "GROUP BY c.cat_id ".
                'ORDER BY parent_id, sort_order ASC';
				
				
        $res 	= $dbcon->execute($sql);
		$res	= $dbcon->getResultArray($res);
		

        $sql = "SELECT c.cat_id as cat_id, COUNT(g.goods_id) AS goods_num ".
                "FROM ecs_category AS c ".
                "LEFT JOIN ecs_category AS g ON g.cat_id=c.cat_id ".
                "GROUP BY c.cat_id ";
				
				
		$res2 	= $dbcon->execute($sql);
		$res2	= $dbcon->getResultArray($res2);

        $newres = array();
        foreach($res2 as $k=>$v)
        {
            $newres[$v['cat_id']] = $v['goods_num'];
        }

        foreach($res as $k=>$v)
        {
            $res[$k]['goods_num'] = $newres[$v['cat_id']];
        }
    }
	
	
	


    if (empty($res) == true)
    {
        return $re_type ? '' : array();
    }

    $options = cat_options($cat_id, $res); // 获得指定分类下的子分类的数组
	return $options;
	
}

/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 *
 * @access  private
 * @param   int     $cat_id     上级分类ID
 * @param   array   $arr        含有所有分类的数组
 * @param   int     $level      级别
 * @return  void
 */
function cat_options($spec_cat_id, $arr)
{
    static $cat_options = array();

    if (isset($cat_options[$spec_cat_id]))
    {
        return $cat_options[$spec_cat_id];
    }

    if (!isset($cat_options[0]))
    {
        $level = $last_cat_id = 0;
        $options = $cat_id_array = $level_array = array();
        while (!empty($arr))
        {
            foreach ($arr AS $key => $value)
            {
                $cat_id = $value['cat_id'];
                if ($level == 0 && $last_cat_id == 0)
                {
                    if ($value['parent_id'] > 0)
                    {
                        break;
                    }

                    $options[$cat_id]          = $value;
                    $options[$cat_id]['level'] = $level;
                    $options[$cat_id]['id']    = $cat_id;
                    $options[$cat_id]['name']  = $value['cat_name'];
                    unset($arr[$key]);

                    if ($value['has_children'] == 0)
                    {
                        continue;
                    }
                    $last_cat_id  = $cat_id;
                    $cat_id_array = array($cat_id);
                    $level_array[$last_cat_id] = ++$level;
                    continue;
                }

                if ($value['parent_id'] == $last_cat_id)
                {
                    $options[$cat_id]          = $value;
                    $options[$cat_id]['level'] = $level;
                    $options[$cat_id]['id']    = $cat_id;
                    $options[$cat_id]['name']  = $value['cat_name'];
                    unset($arr[$key]);

                    if ($value['has_children'] > 0)
                    {
                        if (end($cat_id_array) != $last_cat_id)
                        {
                            $cat_id_array[] = $last_cat_id;
                        }
                        $last_cat_id    = $cat_id;
                        $cat_id_array[] = $cat_id;
                        $level_array[$last_cat_id] = ++$level;
                    }
                }
                elseif ($value['parent_id'] > $last_cat_id)
                {
                    break;
                }
            }

            $count = count($cat_id_array);
            if ($count > 1)
            {
                $last_cat_id = array_pop($cat_id_array);
            }
            elseif ($count == 1)
            {
                if ($last_cat_id != end($cat_id_array))
                {
                    $last_cat_id = end($cat_id_array);
                }
                else
                {
                    $level = 0;
                    $last_cat_id = 0;
                    $cat_id_array = array();
                    continue;
                }
            }

            if ($last_cat_id && isset($level_array[$last_cat_id]))
            {
                $level = $level_array[$last_cat_id];
            }
            else
            {
                $level = 0;
            }
        }
        $cat_options[0] = $options;
    }
    else
    {
        $options = $cat_options[0];
    }

    if (!$spec_cat_id)
    {
        return $options;
    }
    else
    {
        if (empty($options[$spec_cat_id]))
        {
            return array();
        }

        $spec_cat_id_level = $options[$spec_cat_id]['level'];

        foreach ($options AS $key => $value)
        {
            if ($key != $spec_cat_id)
            {
                unset($options[$key]);
            }
            else
            {
                break;
            }
        }

        $spec_cat_id_array = array();
        foreach ($options AS $key => $value)
        {
            if (($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id) ||
                ($spec_cat_id_level > $value['level']))
            {
                break;
            }
            else
            {
                $spec_cat_id_array[$key] = $value;
            }
        }
        $cat_options[$spec_cat_id] = $spec_cat_id_array;

        return $spec_cat_id_array;
    }
}

$cat_list = cat_list(0, 0, false);


		
		$type		= $_REQUEST['type'];
		if($type	== 'del'){
		
			
			$sn		= $_REQUEST['sn'];
			$ss		= "select * from ecs_category where parent_id='$sn'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			if(count($ss) == 0){
			
				
				$del	= "delete from ecs_category where cat_id='$sn'";
				if($dbcon->execute($del)){
			
					$status = "操作处理成功";
					
				}else{
					
					$status = "操作处理失败";
					
				}
			
			
			}
			
		
		
		
		}
		

	

	

	echo $status;
	
?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

	background-color: #F8F9FA;

}

-->

</style>



<link href="../images/skin.css" rel="stylesheet" type="text/css" />



<script language="javascript" type="text/javascript" src="../My97DatePicker/WdatePicker.js"></script>

<style type="text/css">

<!--

.STYLE1 {color: #CCCCCC}

-->

</style>

<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td class="left_txt">当前位置：产品分类管理&nbsp;&nbsp;
              
 :

              

              <input type="button" value="分类添加" onClick="location.href='s_categoryadd.php'">
              <input type="button" value="产品添加" onclick="location.href='productadd.php'" />
            <BR><?php echo $status;?></td>

          </tr>

          <tr>

            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

              <tr>

                <td></td>

              </tr>

            </table></td>

          </tr>

          

          <tr>

            <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0"  id="list-table">

              <tr class="left_bt2">

                <td class="left_bt2">分类名称</td>

                <td class="left_bt2">备注</td>

                <td class="left_bt2">产品个数</td>
                <td class="left_bt2">操作</td>
              </tr>

			<?php


				
				foreach ($cat_list as $val) {

					

					
					$cat_id						= $val['cat_id'];
					$cat_name					= $val['cat_name'];
					$level						= $val['level'];
					$cat_desc					= $val['cat_desc'];
					
				
					

			?>

			  

              <tr   >

                <td  class="left_bt2" >
               
      			<img src="menu_minus.gif" width="9" height="9" border="0" style="margin-left:<?php echo $level; ?>em" onclick="rowClicked(this)" />
      		<?php echo $cat_name;?></td>

                <td  class="left_bt2"><?php echo $cat_desc; ?>&nbsp;</td>

                <td  class="left_bt2">
                <?php
					
					$rr		= "select count(*) as cc from ebay_goods where goods_category='$cat_id'";
					$rr		= $dbcon->execute($rr);
					$rr		= $dbcon->getResultArray($rr);
					echo $rr[0]['cc'];
					
				
				
				?>
                <a href="productindex.php?catid=<?php echo $cat_id;?>">查看</a>
                &nbsp;</td>
                <td  class="left_bt2"><a href="s_categoryadd.php?id=<?php echo $cat_id;?>">修改</a> <a href="#" onclick="delsn('<?php echo $cat_id; ?>')">删除</a></td>
              </tr>

              

              <?php } ?>

			 

            </table></td>

          </tr>

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

			    <tr>

             </td>

              </tr>

            

            </table></td>

          </tr>

        </table>

          </td>

      </tr>

    </table></td>

    <td background="../images/mail_rightbg.gif">&nbsp;</td>

  </tr>


</table>

<?php $dbcon->close(); ?>

</body>

<script language="javascript">

function check_all(obj,cName)

{

    var checkboxs = document.getElementsByName(cName);

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == false){

			

			checkboxs[i].checked = true;

		}else{

			

			checkboxs[i].checked = false;

		}	

		

	}

}



function delsn(sn){



	

	if(confirm('确认删除此条记录')){

		

		location.href='s_category.php?type=del&sn='+sn;

		

		

	}



}






</script>