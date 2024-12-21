<?php while ($plxShow->plxMotor->plxRecord_arts->loop()) :  ?>
  <article class="wrap_article">
    <a aria-label="<?php $plxShow->artTitle() ?>" href="<?php $plxShow->artUrl() ?>">
      <?php
      // Affiche une miniature si elle existe, sinon un dégradé
      if ($plxShow->plxMotor->plxRecord_arts->f('thumbnail')) {
        $plxShow->artThumbnail(
          '<img class="my-img_art_loop" src="#img_thumb_url" alt="#img_alt" title="#img_title">',
          true
        );
      } else {
        echo '<div class="no-img_art_loop"></div>';
      } ?>
    </a>
    <div class="p-6 space-y-6 flex grow flex-col">
      <div class="flex items-center justify-between mylink">
        <div>
          <dl class="inline align-middle">
            <dt class="sr-only">Publié le</dt>
            <dd class="inline">
            <time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
            <?php $plxShow->artDate('#num_day #month #num_year(4)'); ?></time></dd>
          </dl>
        </div>
        <p class="inline align-middle">
        <span class="inline font-bold 1">
            <?php $plxShow->artNbCom('#nb', '#nb', '#nb') ?>
          </span>
        </p>
      </div>
      <div class="flex grow flex-col">
        <a aria-label="" href="<?php $plxShow->artUrl() ?>">
          <h3 class="text-xl font-bold mb-2">
            <?php $plxShow->artTitle(); ?>
          </h3>
        </a>
        <div class="article-clamp">
          <?php $plxShow->artChapo(false); ?>
        </div>
      </div>
      <div class="text-base">
        <div class="flex flex-wrap items-center gap-x-2 mylink">
        <?php $plxShow->artCat('') ?>
        </div>
        <div class="flex flex-wrap items-center gap-x-2 mylink opacity-70 italic">
        <?php $plxShow->artTags('<a class="#tag_status" href="#tag_url" title="#tag_name">#tag_name</a>', '') ?>
        </div>
      </div>
    </div>
  </article>
<?php endwhile; ?>