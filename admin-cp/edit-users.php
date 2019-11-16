<?php
include_once("inc/header.php");
include_once("inc/sidebar.php");
$id = intval($_GET['user']);
$msg='';
$get_user = mysqli_query($conn , "SELECT * FROM `users` WHERE `user_id`='$id'");
$user = mysqli_fetch_assoc($get_user);
if(isset($_POST['edit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    if(empty($username)){
        $msg = '<div class="alert alert-success" role="alert">الرجاء إدخال إسم المستخدم</div>';
    }elseif (empty($email)) {
        $msg = '<div class="alert alert-success" role="alert">الرجاء إدخال البريد الإلكتروني</div>';
    }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        $msg = '<div class="alert alert-success" role="alert">الرجاء إدخال بريد الكتروني صحيح</div>';
    }else{
        $sql = mysqli_query($conn , "SELECT * FROM `users` WHERE `username`='$username' OR `email`='$email'");
        if(mysqli_num_rows($sql) > 0){
            if($username == $user['username'] AND $email == $user['email']){
                if($_POST['password'] != '' OR $_POST['con-password'] != ''){
                    if($_POST['password'] != $_POST['con-password']){
                        $msg = '<div class="alert alert-success" role="alert">كلمة االمرور غير متطابقة</div>';
                    }else{
                        $password = md5($_POST['password']);
                        $image = $_FILES['image'];
                        $image_name =$image['name'];
                        $image_tmp =$image['tmp_name'];
                        $image_size =$image['size'];
                        $image_error =$image['error'];
                        if($image_name != ''){
                            $image_exe = explode('.', $image_name);
                            $image_exe = strtolower(end($image_exe));
                            $allowed = array('png','jpg','jpeg','gif');
                            if (in_array($image_exe, $allowed)) {
                                if ($image_error === 0) {
                                    if ($image_size <= 3000000) {
                                        $new_name = uniqid('user',false) . '.' . $image_exe;
                                        $image_dir = '../images/avatar/'.$new_name;
                                        $image_db = 'images/avatar/'.$new_name;
                                        if (move_uploaded_file($image_tmp, $image_dir)) {
                                        $update_user = "UPDATE `users` SET `password`='$password',`gender`='$_POST[gender]',`avatar`='$image_db',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                                            $sql = mysqli_query($conn , $update_user);
                                            if (isset($sql)) {
                                                echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                                echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                            }
                                        }else{
                                        $msg = '<div class="alert alert-success" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                    }
                                    }else{
                                        $msg = '<div class="alert alert-success" role="alert">حجم الصورة كبير جدا يجب ان لا يتعدي 2 MB</div>';
                                    }
                                }else{
                                    $msg = '<div class="alert alert-success" role="alert">حدث خطأ غير متوقع أثناء رفع الصوره</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-success" role="alert">عذرا ولكن امتداد الصورة غير صحيح</div>';
                            }
                        }else{
                           $update_user = "UPDATE `users` SET `password`='$password',`gender`='$_POST[gender]',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                            $sql = mysqli_query($conn , $update_user);
                            if (isset($sql)) {
                                echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                            } 
                        }
                    }
                }else{
                    $image = $_FILES['image'];
                    $image_name =$image['name'];
                    $image_tmp =$image['tmp_name'];
                    $image_size =$image['size'];
                    $image_error =$image['error'];
                    if($image_name != ''){
                        $image_exe = explode('.', $image_name);
                        $image_exe = strtolower(end($image_exe));
                        $allowed = array('png','jpg','jpeg','gif');
                        if (in_array($image_exe, $allowed)) {
                            if ($image_error === 0) {
                                if ($image_size <= 3000000) {
                                    $new_name = uniqid('user',false) . '.' . $image_exe;
                                    $image_dir = '../images/avatar/'.$new_name;
                                    $image_db = 'images/avatar/'.$new_name;
                                    if (move_uploaded_file($image_tmp, $image_dir)) {
                                    $update_user = "UPDATE `users` SET `gender`='$_POST[gender]',`avatar`='$image_db',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                                        $sql = mysqli_query($conn , $update_user);
                                        if (isset($sql)) {
                                            echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                        }
                                    }else{
                                    $msg = '<div class="alert alert-success" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                }
                                }else{
                                    $msg = '<div class="alert alert-success" role="alert">حجم الصورة كبير جدا يجب ان لا يتعدي 2 MB</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-success" role="alert">حدث خطأ غير متوقع أثناء رفع الصوره</div>';
                            }
                        }else{
                            $msg = '<div class="alert alert-success" role="alert">عذرا ولكن امتداد الصورة غير صحيح</div>';
                        }
                    }else{
                       $update_user = "UPDATE `users` SET `gender`='$_POST[gender]',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                        $sql = mysqli_query($conn , $update_user);
                        if (isset($sql)) {
                            echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                        } 
                    } 
                }
            }elseif($username != $user['username'] AND $email == $user['email']){
                $sql =mysqli_query($conn ,"SELECT `username` FROM `users` WHERE `username`='$username'");
                if(mysqli_num_rows($sql) > 0){
                    $msg = '<div class="alert alert-success" role="alert">عذرا ولكن اسم المستخدم موجود بالفعل</div>';
                }else{
                    if($_POST['password'] != '' OR $_POST['con-password'] != ''){
                    if($_POST['password'] != $_POST['con-password']){
                        $msg = '<div class="alert alert-success" role="alert">كلمة االمرور غير متطابقة</div>';
                    }else{
                        $password = md5($_POST['password']);
                        $image = $_FILES['image'];
                        $image_name =$image['name'];
                        $image_tmp =$image['tmp_name'];
                        $image_size =$image['size'];
                        $image_error =$image['error'];
                        if($image_name != ''){
                            $image_exe = explode('.', $image_name);
                            $image_exe = strtolower(end($image_exe));
                            $allowed = array('png','jpg','jpeg','gif');
                            if (in_array($image_exe, $allowed)) {
                                if ($image_error === 0) {
                                    if ($image_size <= 3000000) {
                                        $new_name = uniqid('user',false) . '.' . $image_exe;
                                        $image_dir = '../images/avatar/'.$new_name;
                                        $image_db = 'images/avatar/'.$new_name;
                                        if (move_uploaded_file($image_tmp, $image_dir)) {
                                        $update_user = "UPDATE `users` SET `username`='$username' ,`password`='$password',`gender`='$_POST[gender]',`avatar`='$image_db',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                                            $sql = mysqli_query($conn , $update_user);
                                            if (isset($sql)) {
                                                echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                                echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                            }
                                        }else{
                                        $msg = '<div class="alert alert-success" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                    }
                                    }else{
                                        $msg = '<div class="alert alert-success" role="alert">حجم الصورة كبير جدا يجب ان لا يتعدي 2 MB</div>';
                                    }
                                }else{
                                    $msg = '<div class="alert alert-success" role="alert">حدث خطأ غير متوقع أثناء رفع الصوره</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-success" role="alert">عذرا ولكن امتداد الصورة غير صحيح</div>';
                            }
                        }else{
                           $update_user = "UPDATE `users` SET `username`='$username' , `password`='$password',`gender`='$_POST[gender]',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                            $sql = mysqli_query($conn , $update_user);
                            if (isset($sql)) {
                                echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                            } 
                        }
                    }
                }else{
                    $image = $_FILES['image'];
                    $image_name =$image['name'];
                    $image_tmp =$image['tmp_name'];
                    $image_size =$image['size'];
                    $image_error =$image['error'];
                    if($image_name != ''){
                        $image_exe = explode('.', $image_name);
                        $image_exe = strtolower(end($image_exe));
                        $allowed = array('png','jpg','jpeg','gif');
                        if (in_array($image_exe, $allowed)) {
                            if ($image_error === 0) {
                                if ($image_size <= 3000000) {
                                    $new_name = uniqid('user',false) . '.' . $image_exe;
                                    $image_dir = '../images/avatar/'.$new_name;
                                    $image_db = 'images/avatar/'.$new_name;
                                    if (move_uploaded_file($image_tmp, $image_dir)) {
                                    $update_user = "UPDATE `users` SET `username`='$username' , `gender`='$_POST[gender]',`avatar`='$image_db',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                                        $sql = mysqli_query($conn , $update_user);
                                        if (isset($sql)) {
                                            echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                        }
                                    }else{
                                    $msg = '<div class="alert alert-success" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                }
                                }else{
                                    $msg = '<div class="alert alert-success" role="alert">حجم الصورة كبير جدا يجب ان لا يتعدي 2 MB</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-success" role="alert">حدث خطأ غير متوقع أثناء رفع الصوره</div>';
                            }
                        }else{
                            $msg = '<div class="alert alert-success" role="alert">عذرا ولكن امتداد الصورة غير صحيح</div>';
                        }
                    }else{
                       $update_user = "UPDATE `users` SET `username`='$username' , `gender`='$_POST[gender]',`about-you`='$_POST[about]',`facebook`='$_POST[facebook]',`twitter`='$_POST[twitter]',`instagram`='$_POST[instagram]',`role`='$_POST[role]' WHERE `user_id`='$id'";
                        $sql = mysqli_query($conn , $update_user);
                        if (isset($sql)) {
                            echo '<div class="alert alert-success" role="alert">تم تحديث بيانات العضو بنجاح , جاري تحويلك الي صفحه الأعضاء</div>';
                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                        } 
                    } 
                }
             }

            }elseif($username == $user['username'] AND $email != $user['email']){
                    $sql = mysqli_query($conn, "SELECT `email` FROM `users` WHERE `email` = '$email'");
                    if(mysqli_num_rows($sql) > 0){
                        $msg = '<div class="alert alert-danger" role="alert">عذراً , ولكن البريد الالكتروني مسجل بالفعل</div>';
                    }else{
                        if($_POST['password'] != '' OR $_POST['con-password'] != ''){
                            if($_POST['password'] != $_POST['con-password']){
                                $msg = '<div class="alert alert-danger" role="alert">كلمة المرور غير متطابقة</div>';
                            }else{
                                $password = md5($_POST['password']);
                                $image = $_FILES['image'];
                                $image_name = $image['name'];
                                $image_tmp = $image['tmp_name'];
                                $image_size = $image['size'];
                                $image_error = $image['error'];
                                if($image_name != ''){
                                    $image_exe = explode('.' , $image_name);
                                    $image_exe = strtolower(end($image_exe));
                                    
                                    $allowd = array('gif','png','jpg','jpeg');
                                    
                                    if(in_array($image_exe , $allowd)){
                                        if($image_error === 0){
                                            if($image_size <= 3000000){
                                                $new_name = uniqid('user',false) . '.' . $image_exe;
                                                $image_dir = '../images/avatar/' . $new_name;
                                                $image_db = 'images/avatar/' . $new_name;
                                                if(move_uploaded_file($image_tmp , $image_dir)){
                                                    $update_user = "UPDATE `users` SET `email` = '$email' ,`password` = '$password' , `gender` = '$_POST[gender]', `avatar` = '$image_db', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                                    $sql = mysqli_query($conn, $update_user);
                                                    if(isset($sql)){
                                                        $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                                        echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                                    }
                                                }else{
                                                    $msg = '<div class="alert alert-danger" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                                }
                                            }else{
                                                $msg = '<div class="alert alert-danger" role="alert">حجم الصورة كبير جداً يجب ان لا يتعدى 2 MB</div>';
                                            }
                                        }else{
                                            $msg = '<div class="alert alert-danger" role="alert">حدث خطأ غير متوقع اثناء رفع الصورة</div>';
                                        }
                                    }else{
                                        $msg = '<div class="alert alert-danger" role="alert">عذراً ولكن امتداد الصورة غير صحيح</div>';
                                    }
                                }else{
                                    $update_user = "UPDATE `users` SET `email` = '$email' ,`password` = '$password' , `gender` = '$_POST[gender]', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                    $sql = mysqli_query($conn, $update_user);
                                        if(isset($sql)){
                                            $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                        }
                                }
                            }
                        }else{
                                $image = $_FILES['image'];
                                $image_name = $image['name'];
                                $image_tmp = $image['tmp_name'];
                                $image_size = $image['size'];
                                $image_error = $image['error'];
                                if($image_name != ''){
                                    $image_exe = explode('.' , $image_name);
                                    $image_exe = strtolower(end($image_exe));
                                    
                                    $allowd = array('gif','png','jpg','jpeg');
                                    
                                    if(in_array($image_exe , $allowd)){
                                        if($image_error === 0){
                                            if($image_size <= 3000000){
                                                $new_name = uniqid('user',false) . '.' . $image_exe;
                                                $image_dir = '../images/avatar/' . $new_name;
                                                $image_db = 'images/avatar/' . $new_name;
                                                if(move_uploaded_file($image_tmp , $image_dir)){
                                                    $update_user = "UPDATE `users` SET `email` = '$email' , `gender` = '$_POST[gender]', `avatar` = '$image_db', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                                    $sql = mysqli_query($conn, $update_user);
                                                    if(isset($sql)){
                                                        $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                                        echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                                    }
                                                }else{
                                                    $msg = '<div class="alert alert-danger" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                                }
                                            }else{
                                                $msg = '<div class="alert alert-danger" role="alert">حجم الصورة كبير جداً يجب ان لا يتعدى 2 MB</div>';
                                            }
                                        }else{
                                            $msg = '<div class="alert alert-danger" role="alert">حدث خطأ غير متوقع اثناء رفع الصورة</div>';
                                        }
                                    }else{
                                        $msg = '<div class="alert alert-danger" role="alert">عذراً ولكن امتداد الصورة غير صحيح</div>';
                                    }
                                }else{
                                    $update_user = "UPDATE `users` SET `email` = '$email' ,`gender` = '$_POST[gender]', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                    $sql = mysqli_query($conn, $update_user);
                                        if(isset($sql)){
                                            $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                        }
                                }
                        }
                    }
                }else{
                $msg = '<div class="alert alert-success" role="alert">إسم المستخدم أو البريد الإلكتروني موجود بالفعل</div>';
            }
        }else{
           if($_POST['password'] != '' OR $_POST['con-password'] != ''){
            if($_POST['password'] != $_POST['con-password']){
                $msg = '<div class="alert alert-danger" role="alert">كلمة المرور غير متطابقة</div>';
            }else{
                $password = md5($_POST['password']);
                $image = $_FILES['image'];
                $image_name = $image['name'];
                $image_tmp = $image['tmp_name'];
                $image_size = $image['size'];
                $image_error = $image['error'];
                if($image_name != ''){
                    $image_exe = explode('.' , $image_name);
                    $image_exe = strtolower(end($image_exe));
                    
                    $allowd = array('gif','png','jpg','jpeg');
                    
                    if(in_array($image_exe , $allowd)){
                        if($image_error === 0){
                            if($image_size <= 3000000){
                                $new_name = uniqid('user',false) . '.' . $image_exe;
                                $image_dir = '../images/avatar/' . $new_name;
                                $image_db = 'images/avatar/' . $new_name;
                                if(move_uploaded_file($image_tmp , $image_dir)){
                                    $update_user = "UPDATE `users` SET `username`='$username' , `email` = '$email' ,`password` = '$password' , `gender` = '$_POST[gender]', `avatar` = '$image_db', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                    $sql = mysqli_query($conn, $update_user);
                                    if(isset($sql)){
                                        $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                        echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                    }
                                }else{
                                    $msg = '<div class="alert alert-danger" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-danger" role="alert">حجم الصورة كبير جداً يجب ان لا يتعدى 2 MB</div>';
                            }
                        }else{
                            $msg = '<div class="alert alert-danger" role="alert">حدث خطأ غير متوقع اثناء رفع الصورة</div>';
                        }
                    }else{
                        $msg = '<div class="alert alert-danger" role="alert">عذراً ولكن امتداد الصورة غير صحيح</div>';
                    }
                }else{
                    $update_user = "UPDATE `users` SET `username`='$username' , `email` = '$email' ,`password` = '$password' , `gender` = '$_POST[gender]', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                    $sql = mysqli_query($conn, $update_user);
                        if(isset($sql)){
                            $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                        }
                }
            }
        }else{
                $image = $_FILES['image'];
                $image_name = $image['name'];
                $image_tmp = $image['tmp_name'];
                $image_size = $image['size'];
                $image_error = $image['error'];
                if($image_name != ''){
                    $image_exe = explode('.' , $image_name);
                    $image_exe = strtolower(end($image_exe));
                    
                    $allowd = array('gif','png','jpg','jpeg');
                    
                    if(in_array($image_exe , $allowd)){
                        if($image_error === 0){
                            if($image_size <= 3000000){
                                $new_name = uniqid('user',false) . '.' . $image_exe;
                                $image_dir = '../images/avatar/' . $new_name;
                                $image_db = 'images/avatar/' . $new_name;
                                if(move_uploaded_file($image_tmp , $image_dir)){
                                    $update_user = "UPDATE `users` SET `username`='$username' , `email` = '$email' , `gender` = '$_POST[gender]', `avatar` = '$image_db', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                                    $sql = mysqli_query($conn, $update_user);
                                    if(isset($sql)){
                                        $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                                        echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                                    }
                                }else{
                                    $msg = '<div class="alert alert-danger" role="alert">حدث خطأ اثناء نقل الملف</div>';
                                }
                            }else{
                                $msg = '<div class="alert alert-danger" role="alert">حجم الصورة كبير جداً يجب ان لا يتعدى 2 MB</div>';
                            }
                        }else{
                            $msg = '<div class="alert alert-danger" role="alert">حدث خطأ غير متوقع اثناء رفع الصورة</div>';
                        }
                    }else{
                        $msg = '<div class="alert alert-danger" role="alert">عذراً ولكن امتداد الصورة غير صحيح</div>';
                    }
                }else{
                    $update_user = "UPDATE `users` SET `username`='$username' , `email` = '$email' ,`gender` = '$_POST[gender]', `about-you` = '$_POST[about]' , `facebook` = '$_POST[facebook]', `twitter` = '$_POST[twitter]', `instagram` = '$_POST[instagram]' , `role` = '$_POST[role]' WHERE `user_id` = '$id'";
                    $sql = mysqli_query($conn, $update_user);
                        if(isset($sql)){
                            $msg = '<div class="alert alert-success" role="alert">تم تحديث البيانات , جاري تحويلك الى صفحة الاعضاء</div>';
                            echo '<meta http-equiv="refresh" content="1; \'users.php\' " />';
                        }
                }
            }
        }
    }
}
$get_user = mysqli_query($conn , "SELECT * FROM `users` WHERE `user_id`='$id'");
$user = mysqli_fetch_assoc($get_user);
?>
   
    <article class="col-lg-9">
        <?php echo $msg; ?>
      <div class="panel panel-info">
      <div class="panel-heading"><b>تعديل بيانات العضو : <?php echo $user['username']; ?></b></div>
      <div class="panel-body">
        <form action=""  method="post" enctype="multipart/form-data" class="form-horizontal col-md-9" >
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label"><span style="color: red;">*</span> إسم المستخدم </label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" id="username"  placeholder="ادخل الاسم الخاص بك">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label"><span style="color: red;">*</span> البريد الالكتروني </label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" id="email"  placeholder="ادخل البريد الالكتروني">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label"><span style="color: red;">*</span> كلمه المرور </label>
                <div class="col-sm-6">
                <input type="password" class="form-control" name="password" id="password"  placeholder="ادخل كلمه المرور">
                </div>
            </div>
            <div class="form-group">
                <label for="con-password" class="col-sm-2 control-label"><span style="color: red;">*</span> تاكيد كلمه المرور </label>
                <div class="col-sm-6">
                <input type="password" class="form-control" name="con-password" id="con-password"  placeholder="اعد كتابه كلمه المرور">
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="col-sm-2 control-label" >النوع </label>
                <div class="col-sm-5">
                <select name="gender" class="form-control" id="gender" >
                <option value="">اختر النوع </option>
                <option value="male"<?php echo ($user['gender'] == 'male' ? 'selected' : ''); ?>>ذكر </option>
                <option value="female"<?php echo ($user['gender'] == 'female' ? 'selected' : ''); ?>>انثي </option>
                </select>
                </div>
                </div>
                <div class="form-group">
                <label for="avatar" class="col-sm-2 control-label">الصوره الخاصه بك </label>
                <div class="col-sm-8">
                <input type="file" class="form-control" name="image" id="avatar"  >
                </div>
            </div> 
                
                <div class="form-group">
                <label for="about-you" class="col-sm-2 control-label">الوصف </label>
                <div class="col-sm-9">
                <textarea class="form-control" name="about" id="about-you"  rows="4"><?php echo $user['about-you']; ?></textarea>
                </div>
            </div>
                
            <div class="form-group">
                <label for="facebook" class="col-sm-2 control-label"> <i class="fab fa-facebook fa-2x"></i> </label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="facebook" value="<?php echo $user['facebook']; ?>" id="facebook"   placeholder="ادخل رابط الفيس الخاص بك">
                </div>
            </div>
            <div class="form-group">
                <label for="twitter" class="col-sm-2 control-label"><i class="fab fa-twitter fa-2x"></i> </label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo $user['twitter']; ?>"  placeholder="ادخل رابط تويتر الخاص بك">
                </div>
            </div>
            <div class="form-group">
                <label for="instagram" class="col-sm-2 control-label"><i class="fab fa-instagram fa-2x"></i> </label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="instagram" id="instagram"  value="<?php echo $user['instagram']; ?>" placeholder="ادخل رابط الانستجرام الخاص بك">
                </div>
            </div>
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label" >الصلاحيه </label>
                <div class="col-sm-5">
                <select name="role" class="form-control" id="role" >
                <option value="">اختر النوع </option>
                <option value="admin"<?php echo ($user['role'] == 'admin' ? 'selected' : ''); ?>>أدمين </option>
                <option value="writer"<?php echo ($user['role'] == 'writer' ? 'selected' : ''); ?>>كاتب </option>
                <option value="user"<?php echo ($user['role'] == 'user' ? 'selected' : ''); ?>>عضو </option>
                </select>
                </div>
                </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
                <button type="submit" name="edit" class="btn btn-danger btn-block"><i class="fas fa-pencil-alt" ></i>تعديل البيانات</button>
                </div>
            </div>


            </form>
            <div class="panel panel-default col-md-3">
                <div class="panel-body">
                    <img src="../<?php echo $user['avatar']; ?>" class="img-rounded" width="100%"/>
                </div>
</div>
      </div>
      </div>
    </article>
    
<?php
include_once("inc/footer.php");
?>    
  