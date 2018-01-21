
<script type="text/javascript">
    function play_sound() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'assets/alarm.mp3');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play();
    }
</script>

<?php
	//<meta http-equiv="refresh" content="3" >
	
	include('header.php');
    $mysqli = new mysqli("10.136.198.217", "hpc", "root", "swampfour");
	$sql="select * from (SELECT * from criminal ORDER BY timelastseen DESC) AS x GROUP BY name";
	$result=mysqli_query($mysqli,$sql);
	$row_cnt = mysqli_num_rows($result);
	if($_SESSION['count']<$row_cnt){
		echo '<script type="text/javascript">play_sound();</script>';
		$_SESSION['count'] = $row_cnt;
	}
?>

<?php
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<a href="details.php?id='.$row['id'].'"><div class="card" style="float:left;margin-right:30px;margin-top:20px;">
		<img style="width:100%" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>
		<h1>Name: '.$row['Name'].'</h1>
		<p>Gender: '.$row['Gender'].'</p>
		<p class="title">Last seen at: '.$row['timelastseen'].'</p>
		<p>Location: '.$row['location'].'</p>
		</div></a>';
	}
?>
</body>
</html>
<style>
  @-webkit-keyframes argh-my-eyes {
    0%   { background-color: #fff; }
    49% { background-color: #fff; }
    50% { background-color: red; }
    99% { background-color: red; }
    100% { background-color: #fff; }
  }
  @-moz-keyframes argh-my-eyes {
    0%   { background-color: #fff; }
    49% { background-color: #fff; }
    50% { background-color: red; }
    99% { background-color: red; }
    100% { background-color: #fff; }
  }
  @keyframes argh-my-eyes {
    0%   { background-color: #fff; }
    49% { background-color: #fff; }
    50% { background-color: red; }
    99% { background-color: red; }
    100% { background-color: #fff; }
  }
  .blink {
  -webkit-animation: argh-my-eyes 1s infinite;
  -moz-animation:    argh-my-eyes 1s infinite;
  animation:         argh-my-eyes 1s infinite;
}
</style>