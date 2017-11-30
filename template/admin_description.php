<?php
if (! defined('IS_CMS')) {
    die();
}

/**
 *
 * @author David Ringsdorf <git@drdf.de>
 * @copyright (c) 2016, David Ringsdorf
 * @license The MIT License (MIT)
 */
?>
<p><?= $t->getLanguageValue('info.description.warning'); ?></p>
<h1><?= $t->getLanguageValue('info.description.description_header'); ?></h1>
<p><?= $t->getLanguageValue('info.description.description_text'); ?></p>
<h2><?= $t->getLanguageValue('info.description.example_header'); ?></h2>
<?= $t->getLanguageValue('info.description.example_text_1'); ?><br />
<pre>
  <code>
    <span style="color: blue">[ueber1</span><span style="color: red">=page_name</span><span
      style="color: blue">|</span><?= $t->getLanguageValue('info.description.example_text_2'); ?><span
      style="color: blue">]</span>
  </code>
</pre>
<h1><?= $t->getLanguageValue('info.description.licence_header'); ?></h1>
<p><?= $p['licence.text'] ?></p>