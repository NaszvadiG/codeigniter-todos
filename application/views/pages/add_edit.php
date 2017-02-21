<?php echo validation_errors(); ?>
<form method="post" action="#">
    <input name="title" type="text" value="<?php echo $todo->title; ?>" placeholder="Write a title...">
    <input type="submit" value="Submit">
</form>