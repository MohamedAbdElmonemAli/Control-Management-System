<meta charset="utf8" />
<?php
   $host='localhost';
   $username='root';
   $password='';
   $DB_name='cms-system';
   $conn=mysqli_connect($host,$username,$password,$DB_name);
       mysqli_set_charset($conn,"utf8");
	   
	if(!$conn){
		echo mysqli_connect_error("خطأ في عملية الاتصال") . mysqli_connect_errno();
	}
	function close_db(){
		global $conn;
		mysqli_close($conn);
	}

?>