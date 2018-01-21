<?php
	include('header.php');
    $mysqli = new mysqli("10.136.198.217", "hpc", "root", "swampfour");
	$sql="select * from criminal where name = (SELECT name from criminal where id=".$_GET['id'].") order by timelastseen desc limit 15";
	$result=mysqli_query($mysqli,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	echo '<div class="icon-bar">
	  <a href="#"><i class="fa">Name: '.$row["Name"].'</i></a> 
	  <a href="#"><i class="fa">Gender: '.$row["Gender"].'</i></a> 
	  <a href="#"><i class="fa">Age: '.$row["Age"].'</i></a> 
	</div>';
	?>

	<?php
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<a href="details.php?id='.$row['id'].'"><div class="card" style="float:left;margin-right:30px;margin-top:20px;">
		<img style="width:100%" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>
		<p class="title">Last seen at: '.$row['timelastseen'].'</p>
		<p>Location: '.$row['location'].'</p>
		</div></a>';
	}
?>