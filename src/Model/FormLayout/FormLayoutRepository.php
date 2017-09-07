<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

/**
 * Interface FormLayoutRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\FormLayout
 */
interface FormLayoutRepository
{
    /**
     * @param int $themeId Theme id.
     *
     * @return FormLayoutModel|null
     */
    public function findDefaultByTheme($themeId);

    /**
     * Find by id.
     *
     * @param int $layoutId Form layout id.
     *
     * @return FormLayoutModel|null
     */
    public function find($layoutId);

    /**
     * Set the default layout setting.
     *
     * @param int $themeId         Theme id.
     * @param int $defaultLayoutId Form layout id.
     *
     * @return void
     */
    public function setDefaultLayout ($themeId, $defaultLayoutId);
}
