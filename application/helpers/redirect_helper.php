<?php
	function get_redirecting($url) {
		//echo "redirecting...";
		redirect(base_url() . $url, 'refresh');
	}
?>