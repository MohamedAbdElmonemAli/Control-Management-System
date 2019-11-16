<?php
include_once("inc/header.php");
include_once("inc/sidebar.php");
$msg='';
if (isset($_GET['delete'])) {
    $sql = mysqli_query($conn , "DELETE FROM `users` WHERE `user_id`='$_GET[delete]'");
    if(isset($sql)){
        $msg =  '<div class="alert alert-success" role="alert">تم حذف العضو بنجاح</div>';
    }
}
?>

<article class="col-lg-9">
<?php echo $msg; ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
		      <div class="panel-heading"><b>الأعضاء</b></div>
		      <div class="panel-body">
		        <table class="table table-hover">
		        	<thead>
		        		<tr>
		        			<th>#</th>
                            <th>الصورة الشخصية</th>
		        			<th>إسم العضو</th>
                            <th>البريد الإلكتروني</th>
                            <th>الجنس</th>
                            <th>الصفحة الشخصية</th>
		        			<th>تعديل</th>
		        			<th>حذف</th>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		<?php
                $per_page =2;
                if (!isset($_GET['page'])) {
                 $page = 1;
                }else {
                 $page = (int)$_GET['page'];
                 }
                 $start_from = ($page-1) * $per_page;

                 $users = mysqli_query($conn,"SELECT * FROM `users` ORDER BY `user_id` DESC LIMIT $start_from , $per_page");
                 $num = 1;
                 while ($user = mysqli_fetch_assoc($users)) {
                 	echo '
             	<tr>
		        			<td>'.$num.'</td>
                  <td><img src="../'.$user['avatar'].'" width="50px" height="50px" class="img-circle"</td>
                  <td>'.$user['username'].'</td>
                  <td>'.$user['email'].'</td>
                  <td>'.($user['gender'] == 'male' ? '<img src="../images/male" width="30px" >' :'<img src="../images/female" width="30px" >').'</td>
                  <td><a href="../profile.php?user='.$user['user_id'].'" class="btn btn-primary btn-sm" target="_blank">مشاهدة</a></td>
		        			<td><a href="edit-users.php?user='.$user['user_id'].'" class="btn btn-warning btn-sm">تعديل</a></td>
		        			<td><a href="users.php?delete='.$user['user_id'].'&page='.$page.'" class="btn btn-danger btn-sm">حذف</a></td>
		        		</tr>
                         	';
                         	$num++;
                         }
		        		?>

		        	</tbody>
						</table>
            <?php
            $page_sql = mysqli_query($conn , "SELECT * FROM `users`");
            $count_page = mysqli_num_rows($page_sql);
            $total_page = ceil($count_page /$per_page);
            ?>
            <nav class="text-center">
              <ul class="pagination">
                <?php
                for ($i=1; $i <=$total_page ; $i++) {
                  echo '<li '.($page == $i ? 'class="active"' :'').'><a href="users.php?page='.$i.'">'.$i.'</a></i>';
                }
                ?>
              </ul>
            </nav>
		      </div>
		    </div>
	    </div>
	</div>

</article>

<?php
include_once("inc/footer.php");
?>
