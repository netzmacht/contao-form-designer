<?php

/**
 * Contao Form Designer.
 *
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

use Contao\Model\Collection;

/**
 * Interface FormLayoutRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\FormLayout
 */
interface FormLayoutRepository
{
    /**
     * Find the default form layout by the theme.
     *
     * @param int $themeId Theme id.
     *
     * @return FormLayoutModel|null
     */
    public function findDefaultByTheme(int $themeId): ?FormLayoutModel;

    /**
     * Find by id.
     *
     * @param int $layoutId Form layout id.
     *
     * @return FormLayoutModel|null
     */
    public function find(int $layoutId): ?FormLayoutModel;

    /**
     * Find form layout by theme.
     *
     * @param int $themeId Theme id.
     *
     * @return FormLayoutModel[]|Collection|null
     */
    public function findByTheme(int $themeId): ?Collection;

    /**
     * Find all form layouts.
     *
     * @return FormLayoutModel[]|Collection|null
     */
    public function findAll(): ?Collection;

    /**
     * Add a form layout model to the repository.
     *
     * @param FormLayoutModel $model Form layout model.
     *
     * @return void
     */
    public function add(FormLayoutModel $model): void;

    /**
     * Set the default layout setting.
     *
     * @param int $themeId         Theme id.
     * @param int $defaultLayoutId Form layout id.
     *
     * @return void
     */
    public function setDefaultLayout(int $themeId, int $defaultLayoutId): void;
}
