<?php


?>
<form name="crossword" action="" method="POST">
    <p>Validate today's date and kindle email address to have NewsDay crossword delivered.</p>
    <div>Date: <br>
        <input type="date" class="textInput" name="date" value="<?= (new DateTime())->format("Y-m-d"); ?>"></div>
    <div>Kindle Email: <br>
        <input type="text" class="textInput" name="kindleEmail" value="<?= $this->kindleEmail; ?>"></div>
    <div><input type="submit" value="Send Crossword"></div>
</form>
<?php if ($this->successMsg) { ?>
<p class="success"><?= $this->successMsg; ?></p>
<?php } ?>