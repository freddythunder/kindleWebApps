<?php foreach ($index->navigation as $navItem) { ?>
    <a href="<?= $this->localPath . $navItem['link']; ?>">
        <div class="kbutton border">
            <h5><?= $navItem['name']; ?></h5>
            <?php if ($navItem['img'] && file_exists($index->serverPath . $navItem['img'])) { ?>
            <img src="<?= $this->localPath . $navItem['img']; ?>" width="80">
            <?php } ?>
        </div>
    </a>
<?php } ?>