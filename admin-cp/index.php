<?php
include_once("inc/header.php");
include_once("inc/sidebar.php");

$get_user = mysqli_query($conn , "SELECT `username` ,`email` ,`role`,`avatar` FROM `users` WHERE `user_id` = '$_SESSION[id]'");
$user = mysqli_fetch_assoc($get_user);

$posts = mysqli_query($conn , "SELECT * FROM `posts`");
$post = mysqli_num_rows($posts);

$users = mysqli_query($conn , "SELECT * FROM `users`");
$count_user = mysqli_num_rows($users);

$comments = mysqli_query($conn , "SELECT * FROM `comments`");
$count_comments = mysqli_num_rows($comments);
?>

    <article class="col-lg-9">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-3">
            <div class="panel panel-primary">
              <div class="panel-heading"><b>أهلا وسهلا بك يا <?php echo ucwords($user['username']); ?></b></div>
                <div class="panel-body">
                  <div class="text-center">
                    <img src="../<?php echo $user['avatar']; ?>" width="40%" class="img-rounded" style="max-width: 150px;" />
                  </div>
                  <hr/>
                  <div class="text-right">
                  <p><b>البريد الإلكتروني :  <?php echo $user['email']; ?></b></p>
                  <p><b>الصلاحية :  <?php echo ($user['role'] == 'admin' ? 'المدير العام' : 'كاتب'); ?></b></p>
                  <p><a href="" class="btn btn-primary btn-sm pull-left">تعديل البيانات </a></p>
                </div>
                </div>
             </div>
           </div>
           <div class="col-md-3">
             <div class="panel panel-success">
               <div class="panel-heading"><b>المقالات</b></div>
                 <div class="panel-body">
                   <div class="text-center">
                     <div class="col-md-8">
                       <p><i class="fas fa-list-alt fa-5x" style="color: #3C763D;" ></i></p>
                     </div>
                     <div class="col-md-4">
                       <p style="color: #3C763D;"><?php echo $post; ?></p>
                     </div>
                 </div>
              </div>
              <div class="text-center">
              <div class="panel-footer"><a href="posts.php" class="btn btn-success btn-sm"><i class="fas fa-eye" style="color: #3C763D;"></i> مشاهدة</a></div>
            </div>
            </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-danger">
            <div class="panel-heading"><b>التعليقات</b></div>
              <div class="panel-body">
                <div class="text-center">
                  <div class="col-md-8">
                    <p><i class="fas fa-comments fa-5x" style="color: #7a290b;" ></i></p>
                  </div>
                  <div class="col-md-4">
                    <p style="color: #7a290b;"><?php echo $count_comments; ?></p>
                  </div>
              </div>
           </div>
           <div class="text-center">
           <div class="panel-footer"><a href="comments.php" class="btn btn-danger btn-sm"><i class="fas fa-eye" style="color: #7a290b;"></i> مشاهدة</a></div>
         </div>
         </div>
     </div>
     <div class="col-md-3">
       <div class="panel panel-info">
         <div class="panel-heading"><b>الأعضاء</b></div>
           <div class="panel-body">
             <div class="text-center">
               <div class="col-md-8">
                 <p><i class="fas fa-users fa-5x" style="color: #31708F;" ></i></p>
               </div>
               <div class="col-md-4">
                 <p style="color: #31708F;"><?php echo $count_user; ?></p>
               </div>
           </div>
        </div>
        <div class="text-center">
        <div class="panel-footer"><a href="users.php" class="btn btn-info btn-sm"><i class="fas fa-eye" style="color: #31708F;"></i> مشاهدة</a></div>
      </div>
      </div>
  </div>

  <div class="col-md-12">
    <div class="panel panel-success">
    <div class="panel-heading"><b>المقالات</b></div>
    <div class="panel-body">
      <table class="table table-hover">
          <thead>
              <tr>
                  <th>#</th>
                  <th>صورة المقال</th>
                  <th>عنوان المقال</th>
                  <th>الكاتب</th>
                  <th>تاريخ النشر</th>
                  <th>مشاهدة المقال</th>
                  <th>الحالة</th>
                  <th>تعديل</th>
                  <th>حذف</th>
              </tr>
          </thead>
          <tbody>
              <?php
                  $posts = mysqli_query($conn,"SELECT * FROM `posts` p INNER JOIN `users` u WHERE p.author = u.user_id ORDER BY `post_id` DESC LIMIT 5");
                  $num = 1;
                  while ($post = mysqli_fetch_assoc($posts)) {
                  echo '
              <tr>
                  <td>'.$num.'</td>
                  <td><img src="../'.($post['image'] == '' ? '../images/no-image' : $post['image']).'" class="img-rounded" width="70px" height="50px" /></td>
                  <td>'.substr($post['title'],0,40).' ...</td>
                  <td>'.$post['username'].'</td>
                  <td>'.$post['post_date'].'</td>
                  <td><a href="../post.php?id='.$post['post_id'].'" class="btn btn-primary btn-sm" target="_blank">مشاهدة</a></td>
                  <td>'.($post['status'] == 'dreft' ? '<a href="posts.php?status=published&post='.$post['post_id'].'" class="btn btn-success btn-sm">نشر</a>' : '<a href="posts.php?status=dreft&post='.$post['post_id'].'" class="btn btn-info btn-sm">تعطيل</a>').'</td>
                  <td><a href="edit-post.php?post='.$post['post_id'].'" class="btn btn-warning btn-sm">تعديل</a></td>
                  <td><a href="posts.php?delete='.$post['post_id'].'" class="btn btn-danger btn-sm">حذف</a></td>
              </tr>
                  ';
                  $num++;
                  }
              ?>

          </tbody>
      </table>
    </div>
    </div>
  </div>

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
                       $users = mysqli_query($conn,"SELECT * FROM `users` ORDER BY `user_id` DESC LIMIT 5");
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
                <td><a href="users.php?delete='.$user['user_id'].'" class="btn btn-danger btn-sm">حذف</a></td>
              </tr>
                        ';
                        $num++;
                       }
              ?>

            </tbody>
          </table>
        </div>
      </div>


  </div>

  <div class="col-md-12">
    <div class="panel panel-danger">
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
          $posts = mysqli_query($conn, "SELECT * FROM `comments` c INNER JOIN `users` u WHERE c.user_id = u.user_id ORDER BY `com_id` DESC LIMIT 5");
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
                <td>'.($post['status'] == 'dreft' ? '<a href="comments.php?status=published&post='.$post['com_id'].'" class="btn btn-success btn-sm">موافقة</a>' : '<a href="comments.php?status=dreft&post='.$post['com_id'].'" class="btn btn-info btn-sm">رفض</a>').'</td>
                <td><a href="edit-comment.php?post='.$post['com_id'].'" class="btn btn-warning btn-sm">تعديل</a></td>
                <td><a href="comments.php?delete='.$post['com_id'].'" class="btn btn-danger btn-sm">حذف</a></td>
              </tr>
            ';
          $num++;
          }
        ?>

        </tbody>
        </table>
    </div>
    </div>
  </div>
      </div>
    </div>
    </article>

<?php
include_once("inc/footer.php");
?>
