<?php
class ImageHuntDB{
	public $conn;

	function __construct(){
		$this->conn = mysqli_connect("127.0.0.1","root","","image_hunt");

		if (mysqli_connect_errno($this->conn)) {
			echo "Failed to connect to MySQL:" . mysqli_connect_error();
		}
	}

	function __destruct(){
		mysqli_close($this->conn);
	}

	function load_leaderboard() {
		$query = "SELECT * FROM leader_board order by total_score desc";
		$leaderboard = mysqli_query($this->conn, $query);
		return $leaderboard;
	}

	function update_leaderboard($username, $score) {
		$query = "UPDATE leader_board
				SET total_score = total_score + ".intval($score).",
						play_times = play_times +1
				  WHERE username = '".$username."'";
		mysqli_query($this->conn, $query);
	}

	function log_user_activity($username, $image_id, $image_rank, $keywords) {
		$query = "INSERT INTO user_activity (username, image_id, image_rank, keywords)
				VALUES ('".$username."', ".intval($image_id).", ".intval($image_rank).",
						'".$keywords."')";
		mysqli_query($this->conn, $query);
	}

	function insert_into_leaderboard($username, $total_score, $play_times) {
		$query = "INSERT INTO leader_board (username, total_score, play_times, cur_timestamp)
				VALUES ('".$username."', ".intval($total_score).", ".intval($play_times).", Now())";
		mysqli_query($this->conn, $query);
	}
	
	function insert_user($username) {
   	 $query = "SELECT * from leader_board where username='".$username."'";
   	 $result = mysqli_query($this->conn, $query);
   	 if ($result->num_rows==0) {
   		 $query = "INSERT into leader_board (username,total_score,play_times) VALUES ('".$username."',0,0)";
   		 mysqli_query($this->conn, $query);
   	 }
    }


	/*function clear_leaderboard() {
		$query
	}*/
}

$test = new ImageHuntDB();
/*$test->insert_into_leaderboard("amir", 100, 1);
$test->insert_into_leaderboard("ajay", 200, 2);
$test->insert_into_leaderboard("kazem", 10, 3);
$test->insert_into_leaderboard("Pri", 600, 4);
$test->insert_into_leaderboard("Hadis", 400, 5);
$test->update_leaderboard("amir", 3000);

$result = $test->load_leaderboard();

while ($row = mysqli_fetch_assoc($result)) {
echo "[".$row['username'].",".$row['total_score'].",".$row['play_times'].",".$row['cur_timestamp']."]";
echo "<br/>";
}*/?>
