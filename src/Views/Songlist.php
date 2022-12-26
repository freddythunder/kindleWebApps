<?php

if (is_array($this->songlist) && count($this->songlist)) {
    echo "<ul>";
    foreach ($this->songlist as $song) { ?>
        <a href="<?= $index->localPath . $index->page . '/song/' . $song['id']; ?>">
            <li class="border">
                <div><?= $song['title']; ?></div>
                <span class="smallText"><?= $song['artist']; ?></span>
            </li>
        </a>
    <?php }

} else if ($this->songdata) {
    // 26 lines max on left side
    $lines = 26;
    $meat = explode("\n", $this->songdata['meat']);
    $left = implode("\n", array_slice($meat, 0, $lines));
    $right = implode("\n", array_slice($meat, $lines)); ?>
     <table>
        <tr>
            <td><span class="largeText"><?= nl2br($left); ?></span></td>
            <td><span class="largeText"><?= nl2br($right); ?></span></td>
        </tr>
    </table>

<?php
} else {
    foreach ($this->initials as $initial) { ?>
        <a href="<?= $index->page . '/list/' . $initial; ?>">
            <div class="kbutton border">
                <h1><?= $initial; ?></h1>
            </div>
        </a>
    <?php }

}



