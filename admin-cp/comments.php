<?php
	include_once("inc/header.php");
	include_once("inc/sidebar.php");
	$msg = '';
	if(isset($_GET['status']) AND isset($_GET['post'])){
		$sql = mysqli_query($conn, "UPDATE `comments` SET `status` = '$_GET[status]' WHERE `com_id` = '$_GET[post]'");
	}

	if(isset($_GET['delete'])){
		$sql = mysqli_query($conn, "DELETE FROM `comments` WHERE `com_id` = '$_GET[delete]'");
		if(isset($sql)){
			$msg = '<div class="alert alert-success" role="alert">تم حذف التعليق بنجاح</div>';
		}
	}
?>

	<article class="col-lg-9">
	<?php echo $msg; ?>
		<div class="panel panel-info">
		  <div class="panel-heading"><b>التعليقات</b></div>
		  <div class="panel-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>عنوان التعليق</th>
					<th>التعليق</th>
					<th>الكاتب</th>
					<th>تاريخ النشر</th>
					<th>مشاهدة</th>
					<th>الحالة</th>
					<th>تعديل</th>
					<th>حذف</th>
				</tr>
			</thead>
			<tbody>
			<?php

				$per_page = 5;

				if(!isset($_GET['page'])){
					$page = 1;
				}else{
					$page = (int)$_GET['page'];
				}

				$start_from = ($page-1) * $per_page;


				$posts = mysqli_query($conn, "SELECT * FROM `comments` c INNER JOIN `users` u WHERE c.user_id = u.user_id ORDER BY `com_id` DESC LIMIT $start_from , $per_page");
				$num = 1;
				while($post = mysqli_fetch_assoc($posts)){
					echo '
						<tr>
							<td>'.$num.'</td>
							<td>'.substr($post['title'],0,200).'</td>
							<td>'.substr($post['comment'],0,50).' ...</td>
							<td>'.$post['username'].'</td>
							<td>'.$post['com_date'].'</td>
							<td><a href="../post.php?id='.$post['post_id'].'" class="btn btn-primary btn-sm" target="_blank">مشاهدة المقال</a></td>
							<td>'.($post['status'] == 'dreft' ? '<a href="comments.php?status=published&post='.$post['com_id'].'&page='.$page.'" class="btn btn-success btn-sm">موافقة</a>' : '<a href="comments.php?status=dreft&post='.$post['com_id'].'&page='.$page.'" class="btn btn-info btn-sm">رفض</a>').'</td>
							<td><a href="edit-comment.php?post='.$post['com_id'].'" class="btn btn-warning btn-sm">تعديل</a></td>
							<td><a href="comments.php?delete='.$post['com_id'].'&page='.$page.'" class="btn btn-danger btn-sm">حذف</a></td>
						</tr>
					';
				$num++;
				}
			?>

			</tbody>
			</table>

			<?php
				$page_sql = mysqli_query($conn , "SELECT * FROM `comments`");
				$count_page = mysqli_num_rows($page_sql);

				$total_page = ceil($count_page / $per_page);
			?>
			<nav class="text-center">
				<ul class="pagination">
			<?php
				for($i = 1; $i <= $total_page; $i++){
					echo '<li '.($page == $i ? 'class="active"' : '').'><a href="comments.php?page='.$i.'">'.$i.'</a></li>';
				}
			?>
				</ul>
			</nav>
		  </div>
		</div>
	</article>
<?php
	include_once("inc/footer.php");
?>
