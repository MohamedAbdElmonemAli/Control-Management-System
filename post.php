<?php
include_once('include/header.php');
include_once('include/sidebar.php');
$id = intval($_GET['id']);
$select_post = mysqli_query($conn , "SELECT * FROM `posts` p INNER JOIN `users` u ON p.author = u.user_id WHERE `post_id` = '$id' ORDER BY `post_id` DESC ");
$post = mysqli_fetch_assoc($select_post);

?>

<article class="col-md-9 col-lg-9 ">
<ol class="breadcrumb">
  <li><a href="index.php">الرئيسيه</a></li>
  <li><a href="#"><?php echo $post['category']; ?></a></li>
  <li class="active"><?php echo strip_tags($post['title']); ?></li>
</ol>
  <div class="col-lg-12 art_bg">
	<div class="cate-post">

	   <div class="col-md-12 ">
	   <h2 class="cat_h2"><?php echo strip_tags($post['title']); ?></h2>
	            <img src="<?php echo ($post['image'] == '' ? 'images/no-image' :$post['image']); ?>" width="100%" style="max-height: 400px"/>
			</div>
			<div class="col-md-12">
			<div class="col-md-12  author_post">
					<p class="pull-right" style="margin-top: 9px;"><i class="fas fa-user"></i>  الكاتب : <a href="profile.php?user=<?php echo $post['user_id']; ?>"><?php echo $post['username']; ?></a></p>
					<p class="pull-left" style="margin-top: 9px;"> <?php echo $post['post_date']; ?> <i class="fas fa-clock"></i></p>

					</div>
					<p><?php echo strip_tags(substr($post['post'],0,500)); ?></p>
					<div class="clearfix"></div>
					</div>

	   <div class="clearfix"></div>
	    </div>
	   </div>
	   <!--comment area-->
	   <div class="col-md-12 art_bg" style="margin-top: 20px; padding-top: 15px;">
	   <div class="row">
    <?php
 		$sel_com = mysqli_query($conn, "SELECT * FROM `comments` c INNER JOIN `users` u ON c.user_id = u.user_id WHERE `post_id` = '$id' AND `status` = 'published'");
 		while($comment = mysqli_fetch_assoc($sel_com)){
   	?>
	   <div class="cate-post">
	   <div class="col-md-2 ">
	            <img src="<?php echo $comment['avatar'];?>" width="100%" class="img-rounded" />
			</div>
					<div class="col-md-10 ">
					<h2 class="cat_h2"><i class="fas fa-comments"></i>  <?php echo $comment['title'];?></h2>
					<p>
            <?php echo $comment['comment'];?>
          </p>
					</div>
					<div class="col-md-12">
					<hr style="margin-bottom: 8px; margin-top: 5px;"/>
					<p class="pull-left">12-3-2019 <i class="fas fa-clock"></i> </p>
					<p class="pull-right"><i class="fas fa-user"></i>  تم التعليق بواسطة : <a href="profile.php?user=<?php echo $comment['user_id'];?>"><?php echo $comment['username'];?></a></p>
					</div>
	   <div class="clearfix"></div>
	   </div>
     <?php
		}
	?>
	   </div>
	   </div>
	   <!--comment area-->
	   <div class="col-lg-12 art_bg" style="margin-top: 20px; padding-top: 15px;">
	   <h2><i class="fas fa-comment" style="color: #AB8171;"></i> إضافه تعليق جديد</h2>
	   <hr/>

	 <?php comment_area(); ?>
	   </div>

</article>
<?php
include_once('include/footer.php');
?>
