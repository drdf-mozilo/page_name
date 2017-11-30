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
class page_name extends Plugin
{

    const NAME = __CLASS__;

    const VERSION = '1.0.1';

    const AUTHOR = 'David Ringsdorf';

    const DOKU_URL = 'http://mozilo.davidringsdorf.de';

    const MOZILO_VERSION = '2.0';

    private $_languageObject;

    private $_pluginTemplateDir;

    private $_licenceFile;

    public function __construct()
    {
        parent::__construct();

        $languageFile = $this->PLUGIN_SELF_DIR . 'language' . DIRECTORY_SEPARATOR . $this->_fetchLanguageKey() . '.txt';

        $this->_languageObject = new Language($languageFile);
        $this->_pluginTemplateDir = $this->PLUGIN_SELF_DIR . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;
        $this->_licenceFile = $this->PLUGIN_SELF_DIR . DIRECTORY_SEPARATOR . 'licence.txt';
    }

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
                        if ($cat === $page) {
                            $CatPage->change_Name($cat, FALSE, $newName);
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
        $info[2] = $this->_template('admin_description', $this->_languageObject, [
            'licence.text' => nl2br(file_get_contents($this->_licenceFile))
        ]);

        // Name des Autors.
        $info[3] = self::AUTHOR;

        // Webseite.
        $info[4] = self::DOKU_URL;

        // (optional) Platzhalter der im Seiten-Editor vorgeschlagen wird.

        $info[5] = [
            '[ueber1=page_name|...]' => $this->_languageObject->getLanguageValue('info.placeholder.title')
        ];

        return $info;
    }

    /**
     *
     * @global Properties $ADMIN_CONF
     * @global Properties $CMS_CONF
     * @return string
     */
    private function _fetchLanguageKey()
    {
        global $ADMIN_CONF, $CMS_CONF;

        $language = $CMS_CONF->get('cmslanguage');
        if (IS_ADMIN) {
            $language = $ADMIN_CONF->get('language');
        }

        return $language;
    }

    /**
     *
     * @param string $templateName
     * @param Language $languageObject
     * @param array|NULL $param
     * @return string
     */
    private function _template($templateName, Language $languageObject = NULL, $param = NULL)
    {
        ob_start();
        $t = $languageObject;
        $p = $param;
        require $this->_pluginTemplateDir . $templateName . '.php';
        return (string) ob_get_clean();
    }
}