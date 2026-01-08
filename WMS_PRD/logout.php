<?php
session_start();
session_destroy();
	//header("Location:../index.php");

?>

<script type="text/javascript">
	window.location.replace("../index.php");
</script>