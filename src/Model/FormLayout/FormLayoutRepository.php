<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

use Contao\Model\Collection;

interface FormLayoutRepository
{
    /**
     * Find the default form layout by the theme.
     *
     * @param int $themeId Theme id.
     */
    public function findDefaultByTheme(int $themeId): ?FormLayoutModel;

    /**
     * Find by id.
     *
     * @param int $layoutId Form layout id.
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
     */
    public function add(FormLayoutModel $model): void;

    /**
     * Set the default layout setting.
     *
     * @param int $themeId         Theme id.
     * @param int $defaultLayoutId Form layout id.
     */
    public function setDefaultLayout(int $themeId, int $defaultLayoutId): void;
}
