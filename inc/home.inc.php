<div class="content">
    <h1>Home</h1>
    <div id="quizz" style="margin-left:20px">
    <h3 style="color:#F00">Seniors, be sure to select your own presentation!</h3>
    <?
if(!isset($_POST['submit'])){
?>
<div class="row">
<div class="12u">
<form action="?p=home" method="post">
<div class="12u">Firstname:<input type="text" name="firstname" /></div>
Lastname:<input type="text" name="lastname" /><br />
Email:<input type="text" name="email"/><br />
Grade:<select name="grade">
<option value=""></option>
<option value="11">11th</option>
<option value="12">12th</option>
</select><br />
House:<select name="house">
<option value=""></option>
<option value="N">North</option>
<option value="S">South</option>
<option value="E">East</option>
<option value="W">West</option>
</select><br />
<input type="submit" name="submit" value="Begin" />
</form>
</div>
</div>
<?
} else {
	?>
    <form action="func/submit.func.php" method="post">
    <?
	if($_POST['submit']=="Begin"){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$grade = $_POST['grade'];
		$house = $_POST['house'];
		$uuid = md5($firstname.$lastname.$email);
		if(strlen($firstname)==0 || strlen($lastname)==0 || strlen($email)==0 || strlen($grade)==0 || strlen($house)==0){
			?>
            <h2>Please <a href="?p=home">go back</a> and fill in all the information!</h2>
            <?
			exit();
		}
		?>
        <input type="hidden" name="firstname" value="<? echo $firstname; ?>" />
        <input type="hidden" name="lastname" value="<? echo $lastname; ?>" />
        <input type="hidden" name="email" value="<? echo $email; ?>" />
        <input type="hidden" name="grade" value="<? echo $grade; ?>" />
        <input type="hidden" name="house" value="<? echo $house; ?>" />
        <input type="hidden" name="uuid" value="<? echo $uuid; ?>" />
        <?
		$mysqli = new mysqli($db_host, $db_user, $db_pass);
		$mysqli -> select_db($db_name);
		if(mysqli_connect_errno()) {
			echo "Connection Failed: " . mysqli_connect_errno();
			exit();
		}
		if($stmt = $mysqli->prepare("SELECT * FROM dates")){
			$stmt->execute();
			$stmt->bind_result($date);
			$dateArray = array();
			while($stmt->fetch()){
				array_push($dateArray, $date);
			}
			$stmt->close();
			?>
            <input type="hidden" name="dateArray" value="<? echo base64_encode(serialize($dateArray)); ?>" />            
            <?
			for($x = 0; $x < count($dateArray); $x++){
				?>
                <table>
                <h3><? echo $dateArray[$x]; ?> - Block 1</h3>
                <tr>
                <td>RB</td>
                <td>Name</td>
                <td>Topic</td>
                <td>Location</td>
                <td>Juniors</td>
                <td>Seniors</td>
                </tr>
                <?
				if($stmt2 = $mysqli->prepare("SELECT * FROM presentations WHERE date=? AND block=1")){
					$stmt2->bind_param("s", $dateArray[$x]);
					$stmt2->execute();
					$stmt2->bind_result($pres['uuid'], $pres['firstname'],$pres['lastname'],$pres['house'],$pres['topic'],$pres['date'],$pres['block'],$pres['location'],$pres['juniors'],$pres['seniors']);
					$stmt2->store_result();
					$num = $stmt2-> num_rows;
					if($num==0){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-1'; ?>" value="NA" checked="checked"/></td>
                            <td>No Presentations</td>
                        </tr>
                        <?
					}
					while($stmt2->fetch()){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-1'; ?>" <? if($grade=="11" && numberOfJuniors($pres['uuid'])>=16){ echo "disabled"; } if($grade=="12" && numberOfSeniors($pres['uuid'])>=16){ echo "disabled"; }?> value="<? echo $pres['uuid']; ?>"/></td>
                            <td><? echo $pres['lastname'].", ".$pres['firstname']; ?></td>
                            <td><? echo $pres['topic']; ?></td>
                            <td><? echo $pres['location']; ?></td>
                            <td><? echo numberOfJuniors($pres['uuid']); ?>/16</td>
                            <td><? echo numberOfSeniors($pres['uuid']); ?>/16</td>
                        </tr>
                        <?
					}
					$stmt2->close();
				} else {
					echo $mysqli->error;
				}
				?>
                </table>
                <table>
                <h3><? echo $dateArray[$x]; ?> - Block 2</h3>
                <tr>
                <td>RB</td>
                <td>Name</td>
                <td>Topic</td>
                <td>Location</td>
                <td>Juniors</td>
                <td>Seniors</td>
                </tr>
                <?
				if($stmt2 = $mysqli->prepare("SELECT * FROM presentations WHERE date=? AND block=2")){
					$stmt2->bind_param("s", $dateArray[$x]);
					$stmt2->execute();
					$stmt2->bind_result($pres['uuid'], $pres['firstname'],$pres['lastname'],$pres['house'],$pres['topic'],$pres['date'],$pres['block'],$pres['location'],$pres['juniors'],$pres['seniors']);
					$stmt2->store_result();
					$num = $stmt2-> num_rows;
					if($num==0){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-2'; ?>" value="NA" checked="checked"/></td>
                            <td>No Presentations</td>
                        </tr>
                        <?
					}
					while($stmt2->fetch()){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-2'; ?>" <? if($grade=="11" && numberOfJuniors($pres['uuid'])>=16){ echo "disabled"; } if($grade=="12" && numberOfSeniors($pres['uuid'])>=16){ echo "disabled"; }?> value="<? echo $pres['uuid']; ?>"/></td>
                            <td><? echo $pres['lastname'].", ".$pres['firstname']; ?></td>
                            <td><? echo $pres['topic']; ?></td>
                            <td><? echo $pres['location']; ?></td>
                            <td><? echo numberOfJuniors($pres['uuid']); ?>/16</td>
                            <td><? echo numberOfSeniors($pres['uuid']); ?>/16</td>
                        </tr>
                        <?
					}
					$stmt2->close();
				} else {
					echo $mysqli->error;
				}
				?>
                </table>
                <table>
                <h3><? echo $dateArray[$x]; ?> - Block 3</h3>
                <tr>
                <td>RB</td>
                <td>Name</td>
                <td>Topic</td>
                <td>Location</td>
                <td>Juniors</td>
                <td>Seniors</td>
                </tr>
                <?
				if($stmt2 = $mysqli->prepare("SELECT * FROM presentations WHERE date=? AND block=3")){
					$stmt2->bind_param("s", $dateArray[$x]);
					$stmt2->execute();
					$stmt2->bind_result($pres['uuid'], $pres['firstname'],$pres['lastname'],$pres['house'],$pres['topic'],$pres['date'],$pres['block'],$pres['location'],$pres['juniors'],$pres['seniors']);
					$stmt2->store_result();
					$num = $stmt2-> num_rows;
					if($num==0){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-3'; ?>" value="NA" checked="checked"/></td>
                            <td>No Presentations</td>
                        </tr>
                        <?
					}
					while($stmt2->fetch()){
						?>
                        <tr>
                        	<td><input type="radio" name="<? echo $dateArray[$x].'-3'; ?>" value="<? echo $pres['uuid']; ?>" <? if($grade=="11" && numberOfJuniors($pres['uuid'])>=16){ echo "disabled"; } if($grade=="12" && numberOfSeniors($pres['uuid'])>=16){ echo "disabled"; }?> value="<? echo $pres['uuid']; ?>" /></td>
                            <td><? echo $pres['lastname'].", ".$pres['firstname']; ?></td>
                            <td><? echo $pres['topic']; ?></td>
                            <td><? echo $pres['location']; ?></td>
                            <td><? echo numberOfJuniors($pres['uuid']); ?>/16</td>
                            <td><? echo numberOfSeniors($pres['uuid']); ?>/16</td>
                        </tr>
                        <?
					}
					$stmt2->close();
				} else {
					echo $mysqli->error;
				}
				?>
                </table>
                <?
			}
		}
		//display choices
		?>
        <br /><br />
        <input type="submit" name="submit" value="Submit" />
        </form>
        <br /><br />
        <a href="?p=home">Cancel</a>
        <?
	}	
}
?>
    </div>
    <!-- end .content --></div>
										