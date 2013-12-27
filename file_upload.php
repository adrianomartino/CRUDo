<?php
require('application/bootstrap.php');

$Upload=new Upload();

?>

<html><head><title>File upload</title></head><body>

<form action='<?php echo $_SERVER['PHP_SELF'] ?>' enctype='multipart/form-data' method=post>

<input type=file name='ilfile[]' multiple />
<input type=file name='ilfile2' />
<input type=submit value=carica />
</form>

<? new Notifications_VH?>

</body>
</html>