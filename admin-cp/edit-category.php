<?php
include_once("inc/header.php");
include_once("inc/sidebar.php");
$msg = '';
if(isset($_GET['cate'])){
	$sql = mysqli_query($conn , "SELECT * FROM `category` WHERE `cate_id`='$_GET[cate]'");
	$cate = mysqli_fetch_assoc($sql);
}
if(isset($_POST['edit_cat'])){
	if(empty($_POST['category'])){
		$msg = '<div class="alert alert-danger" role="alert">الرجاء إدخال إسم التصنيف</div>';
	}else{
		$sql = mysqli_query($conn , "UPDATE `category` SET `category`='$_POST[category]' WHERE `cate_id`='$_GET[cate]'");
		if (isset($sql)) {
			header("Location: category.php");
		}
	}
}
?>
   
<article class="col-lg-9">
	<div class="row">
		<div class="col-md-6">
			<?php echo $msg; ?>
			<div class="panel panel-info">
		      <div class="panel-heading">تعديل التصنيف  :: <?php echo $cate['category']; ?></div>
		      <div class="panel-body">
		        <form action="" method="post" class="form-horizontal">
				  <div class="form-group">
				    <label for="category" class="col-sm-4 control-label">إسم التصنيف  :</label>
				    <div class="col-sm-8">
				      <input type="text" name="category" value="<?php echo $cate['category']; ?>" class="form-control" id="category" placeholder="أدخل اسم التصنيف الجديد">
				    </div>
				  </div>
				  <hr />
				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-8">
				      <input type="submit" name="edit_cat" class="btn btn-info" value="تعديل التصنيف" />
				    </div>
				  </div>
				</form>
		      </div>
		    </div>
		</div>
	</div>
  
</article>
    
<?php
include_once("inc/footer.php");
?>    
  