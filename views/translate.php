<?php

$i = 0;

$this_language = isset($_GET['lng']) ? $_GET['lng'] : 'en';

$languages = [
  'en' => 'Default',
];


function lng_def($str = "") {
  $file = get_template_directory() . "/assets/language/default.json";
  $json = file_get_contents($file);
  $arr = json_decode($json, true);
  if($arr && count($arr) > 0) ksort($arr);
  return $str != "" ? $arr[$str] : $arr;
}

function lng_current($str, $lang) {
  $file = get_template_directory() . "/assets/language/$lang.json";
  if (!file_exists($file)) return lng_def($str);
  $json = file_get_contents($file);
  $arr = json_decode($json, true);
  ksort($arr);
  return !empty($arr[$str]) ? $arr[$str] : lng_def($str);
}

if($_POST && $_POST['submit_translation']) {
  $lang = $_POST['lang'];
  $file = get_template_directory() . "/assets/language/$lang.json";
  file_put_contents($file, json_encode($_POST));
}

?>

<h1>Translate (<?= $languages[$this_language] ?>)</h1>

<div class="translate-nav">
  <?php foreach($languages as $key => $value) : ?>
  <a href="?page=project-translate&lng=<?= $key ?>" class="<?= $this_language == $key ? 'current' : '' ?>">
    <?= $value; ?>
  </a>
  <?php endforeach;?>
</div>

<div class="p-card p-padding p-margin-top">
  <form class="p-form" action="?page=project-translate&lng=<?= $this_language ?>" method="POST">

    <input type="hidden" name="lang" value="<?= $this_language ?>" />

    <?php if(lng_def()) : ?>
    <?php foreach(lng_def() as $key => $value) : ?>
      <?php if($key != "lang" && $key != "submit_translation") : ?>
        <div class="<?= $i++ > 0 ? "p-margin-sm" : "" ?>">
          <label style="display: block;margin-bottom: 5px;"><?= lng_def($key) ?></label>
          <input style="width: 90%" type="text" name="<?= $key ?>" value="<?= lng_current($key, $this_language) ?>" />
        </div>
      <?php endif;?>
    <?php endforeach;?>
    <?php endif; ?>

    <div class="p-margin-top">
      <input class="p-btn" type="submit" name="submit_translation" value="Save Translateions" />
    </div>

  </form>
</div>

<style>
.translate-nav a {
  margin-right: 10px;
  text-decoration: none;
}
.translate-nav a.current {
  background: white;
  border-radius: 3px;
  padding: 5px;
}
</style>