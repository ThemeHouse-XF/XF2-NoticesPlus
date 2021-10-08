<?php

namespace ThemeHouse\NoticesPlus;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

/**
 * Class Setup
 * @package ThemeHouse\NoticesPlus
 */
class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;


    /**
     *
     */
    public function installStep1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_notice', function (Alter $table) {
            $table->addColumn('thnoticesplus_overlay_dismissible', 'boolean')->setDefault(1);
        });
    }

    /**
     *
     */
    public function uninstallStep1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_notice', function (Alter $table) {
            $table->dropColumns(['thnoticesplus_overlay_dismissible']);
        });
    }


    /**
     *
     */
    public function uninstallStep2()
    {
        $this->db()->update('xf_notice', [ 'notice_type' => 'block' ], 'notice_type = ?', 'thnoticesplus_overlay');
        $this->db()->update('xf_notice', [ 'notice_type' => 'block' ], 'notice_type = ?', 'thnoticesplus_overlay');
    }


    /**
     *
     */
    public function uninstallStep3()
    {
        $this->db()->update('xf_notice', [ 'display_style' => 'primary' ], 'display_style = ?', 'thnoticesplus_success');
        $this->db()->update('xf_notice', [ 'display_style' => 'primary' ], 'display_style = ?', 'thnoticesplus_warning');
        $this->db()->update('xf_notice', [ 'display_style' => 'primary' ], 'display_style = ?', 'thnoticesplus_error');
    }
}
