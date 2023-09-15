<?php namespace TPF;

$locale = isset($_GET['locale']) ? $_GET['locale'] : get_locale();

$translator = new \TPF_Translator;

$defaults = $translator->defaults();

if(isset($_GET['tpf_translator_scan'])) {
  $translator->scan();
}

if(isset($_POST['save_translator'])) {
  $translator->save($_POST, $locale);
}

$languages = [0 => get_locale()];
$languages = array_merge($languages, get_available_languages());

?>
		
<div class="p-margin p-flex p-flex-between p-flex-middle">
  <div>
    <h2 class="p-margin" style="font-size: 1.6rem;">Translate (<?= $locale ?>)</h2>
		<?php if (count($languages) > 1) : ?>
		<ul class="p-subnav p-tabs-nav p-margin-remove">
			<?php foreach($languages as $lang) : ?>
			<li>
				<a class="p-tabs-nav<?= $lang == $locale ? ' p-active' : '' ?>" href="./admin.php?page=translator&locale=<?= $lang ?>">
					<?= $lang ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
  </div>
  <div>
    <button class="p-btn p-btn-sm p-margin-right-sm" type="submit" form="translator-form" name="translator_button_submit">
      <span class="dashicons dashicons-saved"></span>
      Save
    </button>
    <a class="p-btn p-btn-sm" href="<?= admin_url() ?>admin.php?page=translator&tpf_translator_scan=1">
      <span class="dashicons dashicons-controls-repeat" style="line-height:1;"></span>
      Scan
    </a>
  </div>
</div>

<form id="translator-form" action="./admin.php?page=translator&locale=<?= $locale ?>" method="POST">

  <input type="hidden" name="save_translator" value="1" />

  <div class="p-card p-padding p-margin-top">
    <?php foreach($defaults as $key => $value) : ?>
      <div class="p-margin">
        <label style="display: block;margin-bottom: 5px;font-weight: bold;">
          <?= $defaults[$key] ?>
        </label>
        <input type="text" name="<?= $key ?>" value="<?= $translator->value($key, $locale) ?>" style="width:100%;" />
      </div>
    <?php endforeach; ?>
  </div>

  <div class="p-margin">
    <input class="p-btn" type="submit" name="submit_translator" value="Save Translations" />
  </div>

</form>