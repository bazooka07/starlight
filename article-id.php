<?php include(dirname(__FILE__) . '/header.php'); ?>

<?php
$contenu = $plxShow->plxMotor->plxRecord_arts->f('chapo') . $plxMotor->plxRecord_arts->f('content');
$word_Count = str_word_count(strip_tags($contenu));
$read_Time = ceil($word_Count / 200);
$timer = ($read_Time == 1) ? " minute" : " minutes";
$totalread_Time = $read_Time . $timer;
?>

<main class="relative w-full px-0 xl:px-32 mx-auto py-12 md:py-24" role="main">
  <div class="text-center pb-24 mylink">
    <h1 class="font-bold pb-4"><?php $plxShow->artTitle(); ?></h1>
    <?php $plxShow->lang('WRITTEN_BY'); ?> <?php $plxShow->artAuthor() ?> |
    <?php $plxShow->artCat(', ') ?>
    <p class="text-slate-500 text-italic">
      Dernière mise à jour : <?php $plxShow->artUpdateDate('#num_day #month #num_year(4) #time') ?>
      <br> <?= $plxShow->lang('READING_TIME') . $totalread_Time; ?>
    </p>
  </div>

  <div class="grid xl:grid-cols-12 gap-8">
    <div class="xl:col-span-3">
      <nav class="sticky top-[110px] rounded-lg bg-white p-10 dark:bg-slate-900">
        <ul class="list-none" id="myList">
          <?php
          if (preg_match_all('/<h2>(.*?)<\/h2>/', $contenu, $matches)) {
            $id = 1;
            foreach ($matches[1] as $match) {
              echo '<li><a href="#heading_' . $id . '" onclick="setActiveLink(\'heading_' . $id . '\')">' . $match . '</a></li>';
              $contenu = str_replace('<h2>' . $match . '</h2>', '<h2 id="heading_' . $id . '">' . $match . '</h2>', $contenu);
              $id++;
            }
            // Ajoutez le dernier élément
            echo '<li><a href="#comments" onclick="setActiveLink(\'comments\')">Voir les commentaires</a></li>';
          }
          ?>
        </ul>

      </nav>
    </div>

    <div class="xl:col-span-6 px-2 xl:px-0 mylink">
      <article id="article">
        <?php
        $check_Thumb = ($plxShow->plxMotor->plxRecord_arts->f('thumbnail'));
        if (!$check_Thumb) {
          echo '<hr class="w-1/4 h-0.5 mb-4 bg-slate-200 border-0 rounded dark:bg-slate-900" />';
        } else
          $plxShow->artThumbnail('<div class="mx-auto"><img class="mx-auto rounded-lg art_thumbnail" src="#img_url" alt="#img_alt" title="#img_title"></div>', true) ?>
        <div class="mx-auto plx_content">
          <?= $contenu; ?>
        </div>
      </article>

      <?php $plxShow->artAuthorInfos('<div class="mx-auto py-8">#art_authorinfos</div>'); ?>

      <hr class="hr">

      <div class="mx-auto py-8">
        <div class="text-3xl pb-16 text-primary-500 text-center">
          Articles dans la même catégorie
        </div>
        <div class="grid grid-cols-1 gap-8">
          <?php
          $quellesCategories = $plxShow->plxMotor->plxRecord_arts->f('categorie');
          $quelleCategorie = explode(',', $quellesCategories)[0];
          $plxShow->lastArtList(
            '<div class="flex flex-col items-center overflow-hidden rounded-lg md:flex-row">
              <a href="#art_url" class="group img_lastArt_Wrap">
                <img src="#img_url" onerror="omg_No_Thumb(this)" class="archive_thumb" alt="" title="" >
              </a>
              <div class="content_lastArt">
                <h2 class="text-xl font-semibold mylink">#art_title</h2>
                <div class="text-slate-500"> #art_date </div>
                <div class="text-slate-500">#art_chapo(80)...</div>
                <div>
                  <a href="#art_url">Lire l\'article</a>
                </div>
              </div>
            </div>
            ',
            2,
            $quelleCategorie,
            '',
            'random'
          ); ?>
          <script>
            function omg_No_Thumb(imgElement) {
              imgElement.style.display = 'none'; // Masquer l'image en cas d'erreur
              // ou alors imgElement.src = 'rep/vers/image_de_remplacement.jpg';
            }
          </script>
        </div>
      </div>

      <hr class="hr">

      <?php include(dirname(__FILE__) . '/commentaires.php'); ?>
    </div>

    <div class="xl:col-span-3">
      <?php include(dirname(__FILE__) . '/sidebar.php'); ?>
    </div>

  </div>
</main>

<?php include(dirname(__FILE__) . '/footer.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.getElementById('progressBar');
    const article = document.querySelector('article');

    // Gérer le changement de largeur de la barre de progression en fonction du défilement
    function updateProgressBar() {
      const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPercent = (window.scrollY / documentHeight) * 100;

      // Assurez-vous que le pourcentage reste dans la plage de 0 à 100
      progressBar.style.width = Math.min(scrollPercent, 100) + '%';

      // Arrêtez la barre de progression à 100% lorsque la fin de l'article est atteinte
      if (scrollPercent >= 100) {
        progressBar.style.width = '100%';
      }
    }

    window.addEventListener('scroll', updateProgressBar);
    window.addEventListener('resize', updateProgressBar);
  });
</script>

<script>
  // Fonction pour activer le lien correspondant au paragraphe appelé
  function setActiveLink(id) {
    const listItems = document.querySelectorAll('#myList li');

    // Retirez la classe 'active' de tous les liens
    listItems.forEach(item => {
      item.classList.remove('active');
    });

    // Ajoutez la classe 'active' au lien correspondant
    const activeLink = document.querySelector(`#myList a[href="#${id}"]`);
    if (activeLink) {
      activeLink.parentNode.classList.add('active');
    }
  }
</script>