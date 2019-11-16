<?php
  function register(){
  	if(isset($_SESSION['id'])){
  		echo '<div class="alert alert-danger" role="alert">عذرا يا '.$_SESSION['user'].' ولكنك مسجل لدينا بالفعل</div>';
  	}else{
  		echo '
          		<form action="signup.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="register">
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label"><span style="color: red;">*</span> إسم المستخدم :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="username" id="username"  placeholder="ادخل الاسم الخاص بك">
            </div>
          </div>
           <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><span style="color: red;">*</span> البريد الالكتروني :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="email" id="email"  placeholder="ادخل البريد الالكتروني">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label"><span style="color: red;">*</span> كلمه المرور :</label>
            <div class="col-sm-5">
              <input type="password" class="form-control" name="password" id="password"  placeholder="ادخل كلمه المرور">
            </div>
          </div>
          <div class="form-group">
            <label for="con-password" class="col-sm-2 control-label"><span style="color: red;">*</span> تاكيد كلمه المرور :</label>
            <div class="col-sm-5">
              <input type="password" class="form-control" name="con-password" id="con-password"  placeholder="اعد كتابه كلمه المرور">
            </div>
          </div>
          <div class="form-group">
            <label for="gender" class="col-sm-2 control-label" >النوع :</label>
            <div class="col-sm-3">
              <select name="gender" class="form-control" id="gender" >
        	  <option value="">اختر النوع </option>
        	  <option value="male">ذكر </option>
        	  <option value="female">انثي </option>
        	  </select>
            </div>
        	</div>
        	<div class="form-group">
            <label for="avatar" class="col-sm-2 control-label">الصوره الخاصه بك :</label>
            <div class="col-sm-6">
              <input type="file" class="form-control" name="image" id="avatar"  >
            </div>
          </div>

        	<div class="form-group">
            <label for="about-you" class="col-sm-2 control-label">وصف مختصر عنك :</label>
            <div class="col-sm-6">
              <textarea class="form-control" name="about" id="about-you"  rows="4"></textarea>
            </div>
          </div>

           <div class="form-group">
            <label for="facebook" class="col-sm-2 control-label"> <i class="fab fa-facebook fa-2x"></i> :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="facebook" id="facebook"   placeholder="ادخل رابط الفيس الخاص بك">
            </div>
          </div>
           <div class="form-group">
            <label for="twitter" class="col-sm-2 control-label"><i class="fab fa-twitter fa-2x"></i> :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="twitter" id="twitter"  placeholder="ادخل رابط تويتر الخاص بك">
            </div>
          </div>
           <div class="form-group">
            <label for="instagram" class="col-sm-2 control-label"><i class="fab fa-instagram fa-2x"></i> :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="instagram" id="instagram"  placeholder="ادخل رابط الانستجرام الخاص بك">
            </div>
          </div>

           <div class="col-md-1"></div>
        	 <div class="col-md-8 text-center">
        		 <div id="result"></div>
        	 </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              <button type="submit" name="signup" class="btn btn-danger btn-block"><i class="fas fa-pencil-alt" ></i>تسجيل</button>
            </div>
          </div>


        </form>
  		';
  	}
  }

  function login_area(){
    if(isset($_SESSION['id'])){
    echo '
        <div class="panel panel-default">
        <div class="panel-heading" >  <h4 class="text-center">اهلا وسهلا بك يا '.$_SESSION['user'].'</h4></div>
        <div class="panel-body">
        <div class="text-center" style="margin-bottom:20px">

          <img src="'.$_SESSION['avatar'].'" width="128px"/>
        </div>
        <hr />
          <div class="col-md-12">
            <div class="row">
              <p><b>البريد الالكتروني :</b>'.$_SESSION['email'].'</p>
              <p><b>روابط التواصل لديك :</b>
              <a href="'.$_SESSION['facebook'].'" target="_blank" class="lo_face"><i class="fab fa-facebook fa-lg"></i></a>
              <a href="'.$_SESSION['twitter'].'" target="_blank" class="lo_twit"><i class="fab fa-twitter-square fa-lg"></i></a>
              <a href="'.$_SESSION['instagram'].'" target="_blank" class="lo_inst"><i class="fab fa-instagram fa-lg"></i></a>
              </p>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <div class="col-md-12">
            <div class="row">
              ';
              if ($_SESSION['role'] == 'admin') {
                echo '<a href="admin-cp/index.php" class="btn btn-danger btn-sm pull-right">لوحة التحكم</a>';
              }
              echo '
              <a href="" class="btn btn-info btn-sm pull-left">الصفحه الشخصيه</a>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
    </div>';
    }else{
      echo '
          <div class="panel panel-default">
            <div class="panel-heading" >  <h4 class="text-center"> <i class="fas fa-theater-masks fa-2x"></i> تسجيل الدخول</h4></div>
            <div class="panel-body">
            <div class="text-center" style="margin-bottom:20px">

              <img src="images/avatar.png" width="128px"/>
            </div>
            <hr />
              <form id="login" action="include/login.php" method="post" class="form-horizontal">
                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label text-center"><i class="fas fa-users fa-2x"></i></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="user" placeholder="أدخل اسم المستخدم او البريد الالكتروني">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label text-center"><i class="fas fa-key fa-2x"></i></label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="ادخل كلمه المرور">
                  </div>
                </div>
                <div id="log_result" style="text-align: center; margin: 20px 0;"></div>
                <div class="form-group">
                  <div class="col-sm-10 pull-left">
                    <button type="submit" name="login" class="btn btn-success" >تسجيل الدخول</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="panel-footer"><i class="fas fa-exclamation-circle " style="color: red;"></i>اذا لم تكن مسجل لدينا <a href="register.php">اضغط هنا</a>
          </div>
        </div>
      ';
    }
  }

    function comment_area(){
      global $_SESSION;
      global $id;
      if(!isset($_SESSION['id'])){
      echo '
      <center><h4 style="color:red;"> لإضافة التعليق يرجي تسجيل الدخول في البدايه</h4><small>إذا لم تكن تمتلك حساب , <a href="register.php">إضغط هنا</a></small></center>
      ';
    }else {
      echo '
      <form action="include/comment.php" method="post" class="form-horizontal" id="comments">

    <div class="form-group">
     <label for="title" class="col-sm-2 control-label">عنوان التعليق :</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="title" id="title" placeholder="ادخل عنوان للتعليق">
     </div>
    </div>
    <div class="form-group">
     <label for="comment" class="col-sm-2 control-label">التعليق :</label>
     <div class="col-sm-8">
       <textarea type="text" class="form-control"  name="comment" id="comment" rows="4"></textarea>
     </div>
    </div>

    <input type="hidden" value="'.$id.'" name="id"/>
    <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
       <div id="com_result"></div>
       <button type="submit" name="submit" class="btn btn-success">إضافه تعليق</button>
     </div>
    </div>
    </form>
      ';
    }
  }
?>
