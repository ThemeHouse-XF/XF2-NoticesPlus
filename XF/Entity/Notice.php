<?php

namespace ThemeHouse\NoticesPlus\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Class Notice
 * @package ThemeHouse\NoticesPlus\XF\Entity
 */
class Notice extends XFCP_Notice
{
    /**
     *
     */
    protected function _preSave()
    {
        parent::_preSave();

        if ($this->notice_type === 'thnoticesplus_overlay' && !$this->thnoticesplus_overlay_dismissible && $this->dismissible) {
            $this->dismissible = false;
        }
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['notice_type']['allowedValues'][] = 'thnoticesplus_overlay';
        $structure->columns['notice_type']['allowedValues'][] = 'thnoticesplus_topbar';

        $structure->columns['display_style']['allowedValues'][] = 'thnoticesplus_success';
        $structure->columns['display_style']['allowedValues'][] = 'thnoticesplus_warning';
        $structure->columns['display_style']['allowedValues'][] = 'thnoticesplus_error';

        $structure->columns['thnoticesplus_overlay_dismissible'] = ['type' => self::BOOL, 'default' => true];

        return $structure;
    }
}
