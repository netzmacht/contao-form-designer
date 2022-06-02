<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\LayoutModel;
use Contao\PageModel;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Netzmacht\Contao\FormDesigner\LayoutManager;

class ThemeFormLayoutListener extends AbstractListener
{
    /**
     * Handle the generate page hook.
     *
     * @param PageModel   $pageModel   Page model.
     * @param LayoutModel $layoutModel Layout model.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onPageLayout(PageModel $pageModel, LayoutModel $layoutModel): void
    {
        $model = $this->repository->findDefaultByTheme((int) $layoutModel->pid);
        if (! $model) {
            return;
        }

        $this->createFormLayout(
            $model,
            static function (LayoutManager $manager, FormLayout $formLayout): void {
                $manager->setDefaultThemeLayout($formLayout);
            }
        );
    }
}
