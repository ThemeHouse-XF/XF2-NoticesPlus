<?php

namespace ThemeHouse\NoticesPlus\XF;

use XF\Language;
use XF\Template\Templater;

/**
 * Class NoticeList
 * @package ThemeHouse\NoticesPlus\XF
 */
class NoticeList extends XFCP_NoticeList
{
    /**
     * @param $key
     * @param $type
     * @param $message
     * @param array $override
     */
    public function addNotice($key, $type, $message, array $override = [])
    {
        $language = $this->app->language($this->user->language_id);
        $message = $this->thNoticesPlusReplacePhrases($message, $language);
        $message = $this->thNoticesPlusReplaceTemplatePlaceholders($message);

        if (trim($message)) {
            parent::addNotice($key, $type, $message, $override);
        }
    }

    /**
     * @param $string
     * @param Language $language
     * @return string
     */
    protected function thNoticesPlusReplacePhrases($string, Language $language)
    {
        return $this->app->stringFormatter()->replacePhrasePlaceholders($string, $language);
    }

    /**
     * @param $string
     * @param Templater|null $templater
     * @return string
     */
    public function thNoticesPlusReplaceTemplatePlaceholders($string, Templater $templater = null)
    {
        if (!preg_match_all(
            '#\{template:([a-z0-9_]+)\}#iU',
            $string,
            $templateMatches,
            PREG_SET_ORDER
        )) {
            return $string;
        }

        if (!$templater) {
            $templater = $this->app->templater();
        }

        $pageParams = $this->pageParams;

        $replacements = [];
        foreach ($templateMatches as $templateMatch) {
            $replacements[$templateMatch[0]] = $templater->renderTemplate('public:' . $templateMatch[1], $pageParams);
        }

        return strtr($string, $replacements);
    }
}
