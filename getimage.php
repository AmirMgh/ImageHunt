<?php

		$images = glob('{./images/*.jpg,./images/*.jpeg, ./images/*.gif, ./images/*.png}', GLOB_BRACE);
		echo  json_encode($images);
	