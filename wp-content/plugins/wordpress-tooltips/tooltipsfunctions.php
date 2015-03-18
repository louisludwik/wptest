<?php

function tooltipGlobalSettings()
{
	if (isset($_POST['onlyFirstKeywordsetting']))
	{
		if (isset($_POST['onlyFirstKeyword']))
		{
			update_option("onlyFirstKeyword",$_POST['onlyFirstKeyword']);
		}
		// version 3.4.9 tooltipsMessage("Changes saved."); //!!!
		$tooltipsMessageString =  __( 'Changes saved.', 'wordpress-tooltips' );
		tooltipsMessage($tooltipsMessageString);
	}
	
	
	$onlyFirstKeyword = get_option("onlyFirstKeyword");
	
	if (isset($_POST['enableTooltipsForImageSubmit']))
	{
		if (isset($_POST['enableTooltipsForImage']))
		{
			update_option("enableTooltipsForImage",$_POST['enableTooltipsForImage']);
		}
		// version 3.4.9
		//tooltipsMessage("Changes saved."); //!!!
		$tooltipsMessageString =  __( 'Changes saved.', 'wordpress-tooltips' );
		tooltipsMessage($tooltipsMessageString);		
	}

	$enableTooltipsForImage = get_option("enableTooltipsForImage");
	// 2014-03 3.3.9
	if (isset($_POST['enableTooltipsForExcerptSubmit']))
	{
		if (isset($_POST['enableTooltipsForExcerpt']))
		{
			update_option("enableTooltipsForExcerpt",$_POST['enableTooltipsForExcerpt']);
		}
		// version 3.4.9
		//tooltipsMessage("Changes saved.");
		$tooltipsMessageString =  __( 'Changes saved.', 'wordpress-tooltips' );
		tooltipsMessage($tooltipsMessageString);		
	}
	$enableTooltipsForExcerpt = get_option("enableTooltipsForExcerpt");
	if (empty($enableTooltipsForExcerpt)) $enableTooltipsForExcerpt = 'NO';

	// 2014-03 3.3.9
	if (isset($_POST['enableTooltipsForTagSubmit']))
	{
		if (isset($_POST['enableTooltipsForTag']))
		{
			update_option("enableTooltipsForTags",$_POST['enableTooltipsForTag']);
		}
		// version 3.4.9
		//tooltipsMessage("Changes saved."); //!!!
		$tooltipsMessageString =  __( 'Changes saved.', 'wordpress-tooltips' );
		tooltipsMessage($tooltipsMessageString);
	}
	$enableTooltipsForTag = get_option("enableTooltipsForTags");
	if (empty($enableTooltipsForTag)) $enableTooltipsForTag = 'NO';
	
?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<?php
// version 3.4.9
//<h2>Tooltips Global Settings</h2>
echo '<h2>' . __( 'Tooltips Global Settings', 'wordpress-tooltips' ) . '</h2>';
?>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
										<?php 
										// version 3.4.9
										// Tooltip Keyword Matching Mode
										echo __( 'Tooltip Keyword Matching Mode', 'wordpress-tooltips' );
										 ?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr style="text-align:left;">
										
										<td width="25%"  style="text-align:left;">
										<script type="text/javascript"> 
										jQuery(document).ready(function () {
										  jQuery("span.question").hover(function () {
										    jQuery(this).append('<div class="tooltip"><p>The option --  "Add tooltips to all matching keyword in the same page" means if you have many matched words which have tooltip content, all these words will show related tooltip in the same page.</p><p>The option --  " Add tooltips to the first matching keyword in the same page" means if you have many matched words which have tooltip content, only the first matching word will show related tooltip in the same page.</p></div>');
										  }, function () {
										    jQuery("div.tooltip").remove();
										  });
										});
										</script>
										<?php
										// version 3.4.9
										// Keyword Matching Mode: <span class="question">?</span>
										echo __( 'Keyword Matching Mode:', 'wordpress-tooltips' ).' <span class="question">?</span>';
										?>
										</td>
										<td width="50%"  style="text-align:left;">
										<select id="onlyFirstKeyword" name="onlyFirstKeyword" style="width:400px;">
										<option id="firstKeywordSetting" value="all" <?php if ($onlyFirstKeyword == 'all') echo "selected";   ?>> Add tooltips to all matching keyword in the same page </option>
										<option id="firstKeywordSetting" value="first" <?php if ($onlyFirstKeyword == 'first') echo "selected";   ?>> Add tooltips to the first matching keyword in the same page </option>
										</select>
										</td>
										<td width="25%"  style="text-align:left;">
										<?php
										// version 3.4.9
										// <input type="submit" id="onlyFirstKeywordsetting" name="onlyFirstKeywordsetting" value=" Update Now ">
										?>
										<input type="submit" id="onlyFirstKeywordsetting" name="onlyFirstKeywordsetting" value="<?php  echo __( ' Update Now ', 'wordpress-tooltips' ); ?>">
										</td>
										</tr>

										</table>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />

		
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
									<?php
									// version 3.4.9
									//	Enable/Disable Tooltips For Image Setting<i> <font color='Gray'> (tooltips shown when mouse hover the image)</font></i>
									echo __( "Enable/Disable Tooltips For Image Setting", 'wordpress-tooltips' )."<i> <font color='Gray'> (".__('tooltips shown when mouse hover the image', 'wordpress-tooltips' ).')</font></i>';
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr style="text-align:left;">
										<td width="25%"  style="text-align:left;">
										<script type="text/javascript"> 
										jQuery(document).ready(function () {
										  jQuery("span.questionimage").hover(function () {
										    jQuery(this).append('<div class="tooltip"><p>The option --  "I want to enable tooltips for image" means if you hover a image, the text in alt attribute will show as the tooltip content.</p><p>The option --  "    I want to disable tooltips for image " means if you hover a image, the tooltip box will not be shown.</p></div>');
										  }, function () {
										    jQuery("div.tooltip").remove();
										  });
										});
										</script>
										<?php
										// version 3.4.9
										//Enable Image Tooltips: <span class="questionimage">?</span>
										echo __( 'Enable Image Tooltips: ', 'wordpress-tooltips' ).'<span class="questionimage">?</span>';
										?>
										</td>
										<td width="50%"  style="text-align:left;">
										<select id="enableTooltipsForImage" name="enableTooltipsForImage" style="width:400px;">
										<option id="enableTooltipsForImageOption" value="YES" <?php if ($enableTooltipsForImage == 'YES') echo "selected";   ?>>  I want to enable tooltips for image </option>
										<option id="enableTooltipsForImageOption" value="NO" <?php if ($enableTooltipsForImage == 'NO') echo "selected";   ?>>   I want to disable tooltips for image </option>
										</select>
										</td>
										<td width="25%"  style="text-align:left;">
										<?php
										// version 3.4.9
										//<input type="submit" id="enableTooltipsForImageSubmit" name="enableTooltipsForImageSubmit" value=" Update Now ">
										?>
										<input type="submit" id="enableTooltipsForImageSubmit" name="enableTooltipsForImageSubmit" value="<?php echo __(' Update Now ', 'wordpress-tooltips'); ?>">
										</td>
										</tr>

										</table>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />
<?php
// 2014-03 3.3.9
?>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
									<?php
									// version 3.4.9
									//	Enable/Disable Tooltips For Post Excerpt<i> <font color='Gray'></font></i>
									echo __( "Enable/Disable Tooltips For Post Excerpt", 'wordpress-tooltips' )."<i> <font color='Gray'></font></i>";
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr style="text-align:left;">
										<td width="25%"  style="text-align:left;">
										<script type="text/javascript"> 
										jQuery(document).ready(function () {
										  jQuery("span.questionexcerpt").hover(function () {
										    jQuery(this).append('<div class="tooltip3"><p>The option --  "Enable Tooltips For Post Excerpt" means show tooltips in your post excerpt</p><p>The option --  "    Disable Tooltips For Post Excerpt " means do not show tooltips in your post excerpt</p><p>This option is helpful for some advance themes</p></div>');
										  }, function () {
										    jQuery("div.tooltip3").remove();
										  });
										});
										</script>										
										<?php
										// Tooltips For Excerpt: <span class="questionexcerpt">?</span>
										echo __( 'Tooltips For Excerpt: ', 'wordpress-tooltips' ).'<span class="questionexcerpt">?</span>';
										?>
										</td>
										<td width="50%"  style="text-align:left;">
										<select id="enableTooltipsForExcerpt" name="enableTooltipsForExcerpt" style="width:400px;">
										<option id="enableTooltipsForExcerptOption" value="YES" <?php if ($enableTooltipsForExcerpt == 'YES') echo "selected";   ?>> Enable Tooltips For Post Excerpt </option>
										<option id="enableTooltipsForExcerptOption" value="NO" <?php if ($enableTooltipsForExcerpt == 'NO') echo "selected";   ?>>   Disable Tooltips For Post Excerpt </option>
										</select>
										</td>
										<td width="25%"  style="text-align:left;">
										<?php
										// version 3.4.9
										// <input type="submit" id="enableTooltipsForExcerptSubmit" name="enableTooltipsForExcerptSubmit" value=" Update Now ">
										?>
										<input type="submit" id="enableTooltipsForExcerptSubmit" name="enableTooltipsForExcerptSubmit" value="<?php echo __( ' Update Now ', 'wordpress-tooltips' ); ?>">
										</td>
										</tr>
										</table>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />

<?php
// 2014-03 3.4.1
?>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
									<?php
									// version 3.4.9
									//	Enable/Disable Tooltips For Post Tag<i> <font color='Gray'></font></i>
									echo __( 'Enable/Disable Tooltips For Post Tag', 'wordpress-tooltips' )."<i> <font color='Gray'></font></i>";
									?>
									</span>
									</h3>
									<div class="inside" style='padding-left:5px;'>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr style="text-align:left;">
										<td width="25%"  style="text-align:left;">
										<script type="text/javascript"> 
										jQuery(document).ready(function () {
										  jQuery("span.questiontags").hover(function () {
										    jQuery(this).append('<div class="tooltip1"><p>The option --  "Enable Tooltips For Post Tag" means show tooltips on your post tags</p><p>The option --  "    Disable Tooltips For Post Tag " means do not show tooltips on your post tags</p></div>');
										  }, function () {
										    jQuery("div.tooltip1").remove();
										  });
										});
										</script>
										<?php
										// version 3.4.9
										//Tooltips For Tag: <span class="questiontags">?</span>
										echo __( 'Tooltips For Tag: ', 'wordpress-tooltips' ).'<span class="questiontags">?</span>';
										?>
										</td>
										<td width="50%"  style="text-align:left;">
										<select id="enableTooltipsForTag" name="enableTooltipsForTag" style="width:400px;">
										<option id="enableTooltipsForTagOption" value="YES" <?php if ($enableTooltipsForTag == 'YES') echo "selected";   ?>> Enable Tooltips For Post Tag </option>
										<option id="enableTooltipsForTagOption" value="NO" <?php if ($enableTooltipsForTag == 'NO') echo "selected";   ?>>   Disable Tooltips For Post Tag </option>
										</select>
										</td>
										<td width="25%"  style="text-align:left;">
										<?php
										// version 3.4.9
										//<input type="submit" id="enableTooltipsForTagSubmit" name="enableTooltipsForTagSubmit" value=" Update Now ">
										?>
										<input type="submit" id="enableTooltipsForTagSubmit" name="enableTooltipsForTagSubmit" value="<?php echo __( ' Update Now ', 'wordpress-tooltips' ); ?>">
										</td>
										</tr>

										</table>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />
<?php
}

function editTooltips()
{
		
		global $wpdb;
		$m_tooltipsArray = get_option('tooltipsarray');
		$m_toolstipskeyword= '';
		$m_toolstipscontent= '';
		if (empty($m_tooltipsArray))
		{
			$m_tooltipsArray = array();
		}
		
		if (isset($_POST['toolstipskeywordsubmitnew']))
		{
			if (isset($_POST['toolstipskeyword']))
			{
				$m_toolstipskeyword = $wpdb->escape($_POST['toolstipskeyword']);
			}

			if (isset($_POST['toolstipscontent']))
			{
				$m_toolstipscontent = $wpdb->escape($_POST['toolstipscontent']);
			}
			
			if ((!(empty($m_toolstipscontent))) && (!(empty($m_toolstipskeyword))))
			{
				$m_added = false;
				if ((is_array($m_tooltipsArray)) && (count($m_tooltipsArray) > 0))
				{
					$i = 0;
					foreach ($m_tooltipsArray as $m_tooltipsSingle)
					{
						if ($m_tooltipsSingle['keyword'] == $m_toolstipskeyword)
						{
							$m_tooltipsSingle['content'] = $m_toolstipscontent;
							$m_tooltipsArray[$i]['content'] = $m_toolstipscontent;
							$m_added = true;
							break;
						}
						$i++;
					}
				}

				if ($m_added  == false)
				{
					$m_tooltipsTempArray = array();
					$m_tooltipsTempArray['keyword'] = $m_toolstipskeyword;
					$m_tooltipsTempArray['content'] = $m_toolstipscontent;
					$m_tooltipsArray[] = $m_tooltipsTempArray;					
				}
				
				update_option('tooltipsarray',$m_tooltipsArray);
			}
			// version 3.4.9
			// tooltipsMessage("Tooltips Added.");
			$tooltipsMessageString =  __( 'Tooltips Added.', 'wordpress-tooltips' );
			tooltipsMessage($tooltipsMessageString);
		}
		


		if (isset($_POST['toolstipskeywordsubmitedit']))
		{
			if (isset($_POST['toolstipskeyword']))
			{
				$m_toolstipskeyword = $wpdb->escape($_POST['toolstipskeyword']);
			}

			if (isset($_POST['toolstipscontent']))
			{
				$m_toolstipscontent = $wpdb->escape($_POST['toolstipscontent']);
			}
			
			if ((!(empty($m_toolstipscontent))) && (!(empty($m_toolstipskeyword))))
			{
				$m_added = false;
				$m_toolstipskeywordsubmithideen = $wpdb->escape($_POST['toolstipskeywordsubmithideen']);
				$m_tooltipsArray[$m_toolstipskeywordsubmithideen]['keyword'] = $m_toolstipskeyword;
				$m_tooltipsArray[$m_toolstipskeywordsubmithideen]['content'] = $m_toolstipscontent;  
				update_option('tooltipsarray',$m_tooltipsArray);
			}
			// version 3.4.9
			//tooltipsMessage("Changes saved.");
			$tooltipsMessageString =  __( 'Changes saved.', 'wordpress-tooltips' );
			tooltipsMessage($tooltipsMessageString);			
		}

		if (isset($_POST['toolstipskeywordsubmitdelete']))
		{
			$m_toolstipskeywordsubmithideen = $wpdb->escape($_POST['toolstipskeywordsubmithideen']);

			{
				array_splice($m_tooltipsArray,$m_toolstipskeywordsubmithideen,1);
				update_option('tooltipsarray',$m_tooltipsArray);
			}
			// version 3.4.9
			//tooltipsMessage("Tooltips Deleted.");
			$tooltipsMessageString =  __( 'Tooltips Deleted.', 'wordpress-tooltips' );
			tooltipsMessage($tooltipsMessageString);

		}
				
		echo "<br />";
		?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/wordpress-tooltips/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'> <i></>Add/Edit Tooltips</i></div>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
										Add New Tooltips 
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<br />
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">

										<tr>
										<td width="100%">
										Please input your keyword/sentence of the tooltip:
										<br />
										<br />										
										<input type="text" id="toolstipskeyword" name="toolstipskeyword" value=""  style="width:600px;">
										<br />
										<br />
										<br />
										<br />
										Please input content/tips/image/video of the tooltip <i><font color="Gray">(HTML tag supported)</font></i>:
										<br />
										<br />
										<textarea style="width:600px;" rows="2" cols="40" name='toolstipscontent'></textarea>
										
										</td>
										</tr>

										</table>
										<br />
										<input type="submit" id="toolstipskeywordsubmitnew" name="toolstipskeywordsubmitnew" value="Add Now">
										</form>
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />
		
<!--  edit  -->
<?php 

$m_tooltipsArray = get_option('tooltipsarray');

	if ((is_array($m_tooltipsArray)) && (count($m_tooltipsArray)>0))
	{		
?>
<div style='margin:20px 5px;'>

<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle'><span>
										Edit Existed Tooltips 
									</span>
									</h3>
								
									<div class="inside" style='padding-left:5px;'>
										<br />
										
										<table id="toolstipstable" width="100%">
										<?php
										$i = 0; 
										foreach ($m_tooltipsArray as $m_tooltipsNow)
										{

										?>
										<form id="toolstipsform" name="toolstipsform" action="" method="POST">
										<tr>
										<td width="10%">
										Keyword:
										</td>
										<td width="20%">
										<input type="text" id="toolstipskeyword" name="toolstipskeyword" value="<?php echo stripslashes(stripslashes($m_tooltipsNow['keyword'])); ?>">
										</td>
										<td width="10%">
										Content:
										</td>
										<td width="35%">
										<textarea rows="2" cols="35" name='toolstipscontent'><?php echo stripslashes(stripslashes($m_tooltipsNow['content'])); ?></textarea>
										</td>
										
										<td width="12%" style='align:right;text-align:right;padding-left:3px;'>
											<input type="hidden" id="toolstipskeywordsubmithideen" name="toolstipskeywordsubmithideen" value="<?php echo $i; ?>">
											<input type="submit" class="toolstipskeywordsubmitedit" name="toolstipskeywordsubmitedit" value="Update Now">										
										</td>
										
										<td width="13%" style='align:right;text-align:right;'>
											<input type="submit" class="toolstipskeywordsubmitdelete" name="toolstipskeywordsubmitdelete" value="Delete Now">										
										</td>										
										</tr>
										</form>
										<?php
										$i++;
										}

										?>
										</table>
										<br />
										
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />		

		<?php
		}				
}
	

//2014-08 3.4.7 add tooltips widget functionality
function TooltipsWidgetInit()
{	
	register_sidebar_widget('Tooltips', tooltipsSidebar);
	register_widget_control('Tooltips', tooltipsControl, 300, 200);
}

function tooltipsControl()
{
	global $wpdb,$table_prefix,$g_content;
    $options = get_option('titleTooltipsControl');

    if (empty($options))
    {
    	$m_title = '';
    }
    else 
    {
		$m_title = $options;
    }
    echo $m_title;
    if ($_POST['HiddenTooltipsControl']) 
    {
		update_option('titleTooltipsControl',$wpdb->escape($_POST['HiddenTooltipsControl']));
    }

    echo '<div style="width:250px">';
    echo 'Input Title Here:';
    echo '<br />';
    echo '<input  type="text" id="HiddenTooltipsControl" name="HiddenTooltipsControl" value="'.$m_title.'" style="margin:5px 5px;width:200px" />';
	echo '</div>';
}


function tooltipsSidebar($argssidebarsidebar = null)
{
	global $wpdb,$table_prefix,$g_content;
	$before_widget = '';
	$after_widget = '';
	if (!empty($argssidebar))
	{
		extract($argssidebar);
	}

    $options = get_option('titleTooltipsControl');

    if (empty($options))
    {
    	$m_title = '';
    }
    else 
    {
		$m_title = $options;
    }
    
    
    echo $before_widget;
    echo '<div class="sidebarTooltips">';
    if (!empty($m_title))
    {
    	echo "<h1>" . $m_title . "</h1>";
    }

	global $table_prefix,$wpdb,$post;

	$args = array( 'post_type' => 'tooltips', 'post_status' => 'public' );
	$loop = new WP_Query( $args );
	$return_content = '';
	$return_content .= '<div class="tooltips_widget">';
	while ( $loop->have_posts() ) : $loop->the_post();
		$return_content .= '<div class="tooltips_list">'.get_the_title().'</div>';
	endwhile;
	$return_content = tooltipsInContent($return_content);
	$return_content = showTooltipsInShorcode($return_content);

	$return_content .= '</div>';
    echo "</div>";
	echo $return_content;
}

function tooltipsMessage($p_message)
{

	echo "<div id='message' class='updated fade'>";

	echo $p_message;

	echo "</div>";

}
	
?>