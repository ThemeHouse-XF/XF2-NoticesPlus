<?php

namespace ThemeHouse\NoticesPlus\XF\Repository;

/**
 * Class Notice
 * @package ThemeHouse\NoticesPlus\XF\Repository
 */
class Notice extends XFCP_Notice
{
    /**
     * @return array
     */
    public function getNoticeTypes()
    {
        $noticeTypes = parent::getNoticeTypes();

        $noticeTypes['thnoticesplus_overlay'] = \XF::phrase('thnoticesplus_overlay');
        $noticeTypes['thnoticesplus_topbar'] = \XF::phrase('thnoticesplus_topbar');

        return $noticeTypes;
    }
}
