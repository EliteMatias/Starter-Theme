<?php
  $elite_banner_image = carbon_get_theme_option('elite_banner_image');
  $elite_banner_title = carbon_get_theme_option('elite_banner_title');

  $image = wp_get_attachment_image_url($elite_banner_image, 'full');
  $title = $title ? $title : get_the_title();
?>

<div class="banner generic" style="background-image: url('<?= $image; ?>');">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h1 class="title"><?= $title; ?></h1>
      </div>
    </div>
  </div>
</div>