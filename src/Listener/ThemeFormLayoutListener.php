<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Netzmacht\Contao\FormDesigner\LayoutManager;

/**
 * Class PageThemeListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener
 */
class ThemeFormLayoutListener extends AbstractListener
{
    /**
     * Handle the generate page hook.
     *
     * @param PageModel   $pageModel   Page model.
     * @param LayoutModel $layoutModel Layout model.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onPageLayout(PageModel $pageModel, LayoutModel $layoutModel)
    {
        $model = $this->repository->findDefaultByTheme((int) $layoutModel->pid);
        if (!$model) {
            return;
        }

        $this->createFormLayout(
            $model,
            function (LayoutManager $manager, FormLayout $formLayout) {
                $manager->setDefaultThemeLayout($formLayout);
            }
        );
    }
}
