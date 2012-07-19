<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('waterfall');?><?php include template('common/header'); include template('waterfall:css'); ?><script src="./source/plugin/waterfall/template/js/jquery.min.js" type="text/javascript"></script>
<script src="./source/plugin/waterfall/template/js/jquery.masonry.min.js" type="text/javascript"></script>
<script>
var $17 = jQuery.noConflict(true);//�˴�Ϊ�����ͻ
var loads=0; 
var picwidth=<?php echo $picwidth;?>;
var loadsperpage=<?php echo $loadsperpage;?>;
var space=10;
var loading=false;

<?php if(!empty($_GET['fid'])) { ?>
var fid=<?php echo $_GET['fid'];?>;
<?php } else { ?>
var fid='';
<?php } if(!empty($_GET['filter'])) { ?>
var filter=<?php echo $_GET['filter'];?>;
<?php } else { ?>
var filter='';
<?php } if(!empty($_GET['orderby'])) { ?>
var orderby=<?php echo $_GET['orderby'];?>;
<?php } else { ?>
var orderby=<?php echo $orderbydefault;?>;
<?php } if(!empty($_GET['page'])) { ?>
var page=<?php echo $_GET['page'];?>;
<?php } else { ?>
var page='';
<?php } ?>
$17(document).ready(function(){
var container=$17('#waterfall');
container.masonry({
itemSelector:'.threadwrap',
isFitWidth: true,
//columnWidth:picwidth+22,
gutterWidth:space,
isAnimate:true
});

$17('#fidselect a').each(function(){
if (this.id=='fid'+fid) $17(this).addClass('selected');
});
$17('#filterselect a').each(function(){
if (this.id=='filter'+filter) $17(this).addClass('selected');
});
$17('#orderbyselect a').each(function(){
if (this.id=='orderby'+orderby) $17(this).addClass('selected');
});
waterfall();
});

$17(window).scroll(function(){
// ����������ײ�����100����ʱ�� ����������
if ((loads<loadsperpage)&&(!loading)&&($17(document).height() - $17(this).scrollTop() - $17(this).height()<240)) waterfall();
});

function waterfall()
{
loading=true;
loads=loads+1;
var container = $17('#waterfall');

$17('#loading').show();
$17.ajax({
url : 'plugin.php?id=waterfall:threads',
data:{'fid':fid,'filter':filter,'orderby':orderby,'page':page,'loads':loads},
success : function(data)
{		
var result=$17(data).find('.threadwrap');	
var newitem=result.css({opacity:0});
//������룬Ϊ��֤��ͼ���������ٵ���λ�ã�����imagesLoaded plugin,����֤���������ź�.
container.append(newitem);
newitem.imagesLoaded(function (){
newitem.animate({opacity:1});
container.masonry('appended',newitem,true);
});
//ʹ��������룬�ᷢ��ͼ���ص�����Ϊ��ͼ��δ��������ʱ���ͽ�����λ�õĵ�����
/*newitem.each(function(){
container.append($17(this)).masonry('appended',$17(this),true);
$17(this).animate({opacity:1});
});*/
}
});	
loading=false;
$17('#loading').hide();		 	
}
</script>

<div id="threadlist">
<ul id="waterfall" class="cl">
<li id="handle" class="threadwrap">
<div class="thread">
<div id="fidselect" class="threadpart">
���:<a id="fid" href="plugin.php?id=waterfall:waterfall&amp;fid=&amp;filter=<?php echo $_GET['filter'];?>&amp;orderby=<?php echo $_GET['orderby'];?>">ȫ��</a><?php if(is_array($forums)) foreach($forums as $val) { ?><a id="fid<?php echo $val['fid'];?>" href="plugin.php?id=waterfall:waterfall&amp;fid=<?php echo $val['fid'];?>&amp;filter=<?php echo $_GET['filter'];?>&amp;orderby=<?php echo $_GET['orderby'];?>"><?php echo $val['name'];?></a>
<?php } ?>
</div>
<div id="filterselect" class="threadpart">
ɸѡ:<a id="filter" href="plugin.php?id=waterfall:waterfall&amp;fid=<?php echo $_GET['fid'];?>&amp;filter=&amp;orderby=<?php echo $_GET['orderby'];?>">ȫ��</a><?php if(is_array($filters)) foreach($filters as $key => $val) { ?><a id="filter<?php echo $key;?>" href="plugin.php?id=waterfall:waterfall&amp;fid=<?php echo $_GET['fid'];?>&amp;filter=<?php echo $key;?>&amp;orderby=<?php echo $_GET['orderby'];?>"><?php echo $val['name'];?></a>
<?php } ?>
</div>
<div id="orderbyselect" class="threadpart">
����:<?php if(is_array($orderbys)) foreach($orderbys as $key => $val) { ?><a id="orderby<?php echo $key;?>" href="plugin.php?id=waterfall:waterfall&amp;fid=<?php echo $_GET['fid'];?>&amp;filter=<?php echo $_GET['filter'];?>&amp;orderby=<?php echo $key;?>"><?php echo $val['name'];?></a>
<?php } ?>
</div>
</div>
</li>
</ul>
<div id="loading" style="display:none;">
<span><img src="<?php echo IMGDIR;?>/loading.gif" alt="" width="16" height="16" class="vm" /> ������...</span>
</div>
<div id="mulpage" class="pages cl"><?php echo $mulpage;?></div>
</div><?php include template('common/footer'); ?>