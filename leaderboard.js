function refreshLeaderBoard () {
	$.ajax('leaderboard_table.php?username=amir', {
		success: function (resp) {
			$('div#leaderboard').html(resp);
		}
	});
	setTimeout(refreshLeaderBoard, 5000);
}