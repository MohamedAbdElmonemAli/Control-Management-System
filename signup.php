<?php
include_once('include/config.php');
session_start();
if(isset($_POST['signup'])){
	$username = strip_tags($_POST['username']);
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$about = strip_tags($_POST['about']);
	$facebook = htmlspecialchars($_POST['facebook']);
	$twitter = htmlspecialchars($_POST['twitter']);
	$instagram = htmlspecialchars($_POST['instagram']);
	$date = date("Y-m-d");

	if(empty($username)){
		echo '<div class="alert alert-danger" role="alert">الرجاء ادخال اسم المستخدم</div>';
	}elseif (empty($email)) {
	    echo '<div class="alert alert-danger" role="alert">الرجاء ادخال البريد الالكتروني</div>';
	}elseif (!filter_var($email , FILTER_VALIDATE_EMAIL)) {
	    echo '<div class="alert alert-danger" role="alert">الرجاء ادخال بريد الكتروني صحيح</div>';
	}elseif (empty($_POST['password'])) {
		echo '<div class="alert alert-danger" role="alert">الرجاء ادخال كلمه المرور</div>';
	}elseif (empty($_POST['con-password'])) {
		echo '<div class="alert alert-danger" role="alert">الرجاء تاكيد كلمه المرور</div>';
	}elseif ($_POST['password'] != $_POST['con-password']) {
		echo '<div class="alert alert-danger" role="alert">كلمات المرور غير متطابقه</div>';
	}else {
		    $sql_username = mysqli_query($conn,"SELECT `username` FROM `users` WHERE `username` = '$username'");
			$sql_email    = mysqli_query($conn,"SELECT `email` FROM `users` WHERE `email` = '$email'");
			if(mysqli_num_rows($sql_username) > 0){
				echo '<div class="alert alert-danger" role="alert">عذراً , ولكن اسم المستخدم مسجل بالفعل</div>';
			}elseif(mysqli_num_rows($sql_email) > 0){
				echo '<div class="alert alert-danger" role="alert">عذراً ولكن البريد الالكتروني مسجل بالفعل</div>';
			}else{
				if(isset($_FILES['image'])){
				$image = $_FILES['image'];
				$image_name = $image['name'];
				$image_tmp = $image['tmp_name'];
				$image_size = $image['size'];
				$image_error = $image['error'];

				$image_exe = explode('.', $image_name);
				$image_exe = strtolower(end($image_exe));

	            $allowed = array('png','jpg','jpeg','gif');
	            if(in_array($image_exe, $allowed)){
	            	if($image_error === 0){
	            		if($image_size <= 3000000){
	            			$new_name = uniqid('user',false) . '.' . $image_exe;
							$image_dir = 'images/avatar/' . $new_name;
	            			if(move_uploaded_file($image_tmp, $image_dir)){
	            			$password = md5($_POST['password']);
            				$insert = "INSERT INTO `users` (`username` ,
																	`email` ,
																	`password` ,
																	`gender` ,
																	`avatar` ,
																	`about-you`,
																	`facebook`,
																	`twitter`,
																	`instagram` ,
																	`reg_date`,
																	`role`)
																	VALUES
																	('$username',
																	 '$email',
																	 '$password',
																	 '$gender',
																	 '$image_dir',
																	 '$about',
																	 '$facebook',
																	 '$twitter',
																	 '$instagram',
																	 '$date',
																	 'user'
																	 )";
								$insert_sql = mysqli_query($conn, $insert);
	            				    if (isset($insert_sql)) {
	            				    	if (isset($insert_sql)) {
    				    // echo '<div class="alert alert-success" role="alert">تم تسجيلك لدينا بنجاح</div>'; 
											$user_info = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$username'");
											$user = mysqli_fetch_assoc($user_info);
											$_SESSION['id'] = $user['user_id'];
											$_SESSION['user'] = $user['username'];
											$_SESSION['email'] = $user['email'];
											$_SESSION['gender'] = $user['gender'];
											$_SESSION['avatar'] = $user['avatar'];
											$_SESSION['about'] = $user['about-you'];
											$_SESSION['facebook'] = $user['facebook'];
											$_SESSION['twitter'] = $user['twitter'];
											$_SESSION['instagram'] = $user['instagram'];
											$_SESSION['date'] = $user['reg_date'];
											$_SESSION['role'] = $user['role'];
											echo '<div class="alert alert-success" role="alert">تم تسجيلك بنجاح , جاري تحويلك الى الرئيسية</div>';
											echo '<meta http-equiv="refresh" content="3; \'index.php\' " />';
										}   
	            				     //echo '<div class="alert alert-success" role="alert">تم تسجيلك لدينا بنجاح</div>';   
                                   }                                       
	            			}else{
	            				echo '<div class="alert alert-danger" role="alert">حدث خطا اثناء رفع الصورة</div>';
	            			}
	            		}else{
	            			echo '<div class="alert alert-danger" role="alert">عذرا , حجم الصوره يجب ان لا يتعدي  2 MB</div>';
	            		}
	            	}else{
	            		echo '<div class="alert alert-danger" role="alert">عذرا , حدث خطأ غير متوقع اثناء رفع الصورة</div>';
	            	}
	                
	            }else{
	            	echo '<div class="alert alert-danger" role="alert">الرجاء اختيار صوره صحيحه</div>';
	            }

			}else{
				$password = md5($_POST['password']);
            	$insert = "INSERT INTO `users` (`username` ,
												`email` ,
												`password` ,
												`gender` ,
												`avatar` ,
												`about-you`,
												`facebook`,
												`twitter`,
												`instagram` ,
												`reg_date`,
												`role`)
												VALUES
												('$username',
												 '$email',
												 '$password',
												 '$gender',
												 'images/avatar.png',
												 '$about',
												 '$facebook',
												 '$twitter',
												 '$instagram',
												 '$date',
												 'user'
												 )";
					$insert_sql = mysqli_query($conn, $insert);
    				    if (isset($insert_sql)) {
    				    // echo '<div class="alert alert-success" role="alert">تم تسجيلك لدينا بنجاح</div>'; 
							$user_info = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$username'");
							$user = mysqli_fetch_assoc($user_info);
							$_SESSION['id'] = $user['user_id'];
							$_SESSION['user'] = $user['username'];
							$_SESSION['email'] = $user['email'];
							$_SESSION['gender'] = $user['gender'];
							$_SESSION['avatar'] = $user['avatar'];
							$_SESSION['about'] = $user['about-you'];
							$_SESSION['facebook'] = $user['facebook'];
							$_SESSION['twitter'] = $user['twitter'];
							$_SESSION['instagram'] = $user['instagram'];
							$_SESSION['date'] = $user['reg_date'];
							$_SESSION['role'] = $user['role'];
							echo '<div class="alert alert-success" role="alert">تم تسجيلك بنجاح , جاري تحويلك الى الرئيسية</div>';
							echo '<meta http-equiv="refresh" content="3; \'index.php\' " />';
						}          
			}
		}
	}
}
?>