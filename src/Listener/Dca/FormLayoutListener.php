<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\Controller;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\DataContainer;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

use function array_keys;
use function array_merge;

class FormLayoutListener
{
    /**
     * Form layout factory.
     */
    private FormLayoutFactory $factory;

    /**
     * Contao framework.
     */
    private ContaoFramework $contaoFramework;

    /**
     * Form layout repository.
     */
    private FormLayoutRepository $repository;

    /**
     * List of virtual widget names.
     *
     * @var list<string>
     */
    private $virtualWidgets;

    /**
     * @param FormLayoutRepository $repository      Form layout repository.
     * @param FormLayoutFactory    $factory         Form layout factory.
     * @param ContaoFramework      $contaoFramework Contao framework.
     * @param list<string>         $virtualWidgets  List of virtual widget names.
     */
    public function __construct(
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        ContaoFramework $contaoFramework,
        array $virtualWidgets
    ) {
        $this->factory         = $factory;
        $this->contaoFramework = $contaoFramework;
        $this->repository      = $repository;
        $this->virtualWidgets  = $virtualWidgets;
    }

    /**
     * Load styles.
     */
    public function initialize(): void
    {
        /** @var Adapter<Controller> $controller */
        $controller = $this->contaoFramework->getAdapter(Controller::class);
        $controller->loadLanguageFile('tl_form_field');
    }

    /**
     * Set the default layout.
     *
     * @param DataContainer $dataContainer Data container driver.
     */
    public function setDefaultLayout(DataContainer $dataContainer): void
    {
        if (! $dataContainer->activeRecord || ! $dataContainer->activeRecord->defaultLayout) {
            return;
        }

        $this->repository->setDefaultLayout(
            (int) $dataContainer->activeRecord->pid,
            (int) $dataContainer->activeRecord->id
        );
    }

    /**
     * Generate the row label.
     *
     * @param array<string,mixed> $row Data row.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function generateRowLabel(array $row): string
    {
        $label = $row['title'];

        if ($row['defaultLayout']) {
            $label .= ' <span class="tl_gray">[' . $GLOBALS['TL_LANG']['tl_form_layout']['default'] . ']</span>';
        }

        return $label;
    }

    /**
     * Get the layout types.
     *
     * @return list<string>
     */
    public function getTypes(): array
    {
        return $this->factory->supportedTypes();
    }

    /**
     * Get all widget types.
     *
     * @return list<string>
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getWidgetTypes(): array
    {
        return array_merge(
            array_keys($GLOBALS['TL_FFL']),
            $this->virtualWidgets
        );
    }

    /**
     * Get the layout templates.
     *
     * @return list<string>
     */
    public function getLayoutTemplates(): array
    {
        return $this->getTemplateGroup('fd_layout');
    }

    /**
     * Get the control templates.
     *
     * @return list<string>
     */
    public function getControlTemplates(): array
    {
        return $this->getTemplateGroup('fd_control');
    }

    /**
     * Get the label templates.
     *
     * @return list<string>
     */
    public function getLabelTemplates(): array
    {
        return $this->getTemplateGroup('fd_label');
    }

    /**
     * Get the error templates.
     *
     * @return list<string>
     */
    public function getErrorTemplates(): array
    {
        return $this->getTemplateGroup('fd_error');
    }

    /**
     * Get the help templates.
     *
     * @return list<string>
     */
    public function getHelpTemplates(): array
    {
        return $this->getTemplateGroup('fd_help');
    }

    /**
     * Get the template group.
     *
     * @param string $groupName Group name.
     *
     * @return list<string>
     */
    public function getTemplateGroup(string $groupName): array
    {
        /** @var Adapter<Controller> $controller */
        $controller = $this->contaoFramework->getAdapter(Controller::class);

        return $controller->getTemplateGroup($groupName . '_');
    }
}
