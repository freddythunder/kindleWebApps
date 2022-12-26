<ul>
<?php foreach ($this->filelist as $file) { ?>
    <a href="<?= $index->localPath . 'files/' . basename($file); ?>">
        <li class="border">
            <div><?= basename($file); ?></div>
            <span class="smallText">Size: <?= $this->humanFilesize(filesize($file)); ?> - Last Modified: <?= date("F d Y H:i:s.", filemtime($file)); ?></span>
        </li>
    </a>
<?php } ?>
</ul>
