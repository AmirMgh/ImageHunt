<?php
include_once('db.php');
$imageDB = new ImageHuntDB();
?>
<table id="leaderboardtable">
<tr>
  <th># </th>
  <th>User name</th>
  <th>Score</th>
</tr>
<?php
$username = $_GET['username'];
$result = $imageDB->load_leaderboard();
$position = 1;
while ($row = mysqli_fetch_assoc($result)) {
	print('<tr ');
	if ($username == $row['username'])
		print("class='selected'");
	if ($position % 2 == 0)
		print("class='alt'");
	print('>');
	print('<td>'.$position.'</td>');
	print('<td>'.$row['username'].'</td>');
	print('<td>'.$row['total_score'].'</td>');
	print('</tr>');
	$position ++;
}
?>
</table>
