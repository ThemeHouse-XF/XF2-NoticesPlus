<?php

namespace ThemeHouse\NoticesPlus\XF\Admin\Controller;

/**
 * Class Notice
 * @package ThemeHouse\NoticesPlus\XF\Admin\Controller
 */
class Notice extends XFCP_Notice
{
    /**
     * @param \XF\Entity\Notice $notice
     * @return \XF\Mvc\FormAction
     */
    protected function noticeSaveProcess(\XF\Entity\Notice $notice)
    {
        $form = parent::noticeSaveProcess($notice);

        $input = $this->filter([
            'thnoticesplus_overlay_dismissible' => 'bool',
        ]);

        $form->basicEntitySave($notice, $input);

        return $form;
    }
}
