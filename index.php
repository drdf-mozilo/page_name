<?php
if (! defined('IS_CMS')) {
    die();
}

/**
 *
 * @author David Ringsdorf <git@drdf.de>
 * @copyright (c) 2016, David Ringsdorf
 */
class page_name extends Plugin
{

    const NAME = __CLASS__;

    const VERSION = '0.1.0-alpha';

    const AUTHOR = 'David Ringsdorf';

    const DOKU_URL = 'http://mozilo.davidringsdorf.de';

    const MOZILO_VERSION = '2.0';

    /**
     *
     * @param string $value
     * @return string ''
     */
    public function getContent($value)
    {
        if ($value === 'plugin_first') {

            global $CatPage;

            $allowedPageTypes = [
                EXT_PAGE,
                EXT_HIDDEN
            ];

            $cats = $CatPage->get_CatArray(FALSE, FALSE, $allowedPageTypes);
            foreach ($cats as $cat) {

                $ignore_cmsconf_hidecatnamedpages = TRUE;

                $pages = $CatPage->get_PageArray($cat, $allowedPageTypes, $ignore_cmsconf_hidecatnamedpages);
                foreach ($pages as $page) {

                    $content = $CatPage->get_PageContent($cat, $page);
                    $matches = [];
                    $success = preg_match('#(?<!\^)\[\s*ueber\d\s*\=\s*page_name\s*\|([\s\S]*?)(?<!\^)\]#', $content, $matches);

                    if ($success && count($matches) > 0 && isset($matches[1])) {
                        $newName = trim($matches[1]);
                        $CatPage->change_Name($cat, $page, $newName);
                        // Cat mit selbem Namen wie Page auch umschreiben
                        $catName = $page;
                        if ($CatPage->exists_CatPage($catName, FALSE)) {
                            $CatPage->change_Name($catName, FALSE, $newName);
                        }
                    }
                }
            }
        }
        return '';
    }

    public function getDefaultSettings()
    {
        return [
            'plugin_first' => 'true'
        ];
    }

    public function getConfig()
    {}

    public function getInfo()
    {

        // Name und Version des Plugins.
        // Den Pluginnamen in `<b> ... </b>` zu fassen, wird von mozilo vorgeschlagen.
        $info[0] = '<b>' . self::NAME . '</b> ' . self::VERSION;

        // Benoetigte moziloCMS-Version.
        $info[1] = self::MOZILO_VERSION;

        // Kurzbeschreibung.
        $info[2] = '<code><span style="color:blue" >[ueber1</span><span style="color:red" >=page_name</span><span style="color:blue" >|</span>schöne Gärten<span style="color:blue" >]</span></code>';

        // Name des Autors.
        $info[3] = self::AUTHOR;

        // Webseite.
        $info[4] = self::DOKU_URL;

        // (optional) Platzhalter der im Seiten-Editor vorgeschlagen wird.

        return $info;
    }
}