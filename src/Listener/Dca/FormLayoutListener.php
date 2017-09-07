<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\DataContainer;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class FormLayoutListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class FormLayoutListener
{
    /**
     * Form layout factory.
     *
     * @var FormLayoutFactory
     */
    private $factory;

    /**
     * Contao framework.
     *
     * @var ContaoFrameworkInterface
     */
    private $contaoFramework;

    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    private $repository;

    /**
     * FormLayoutListener constructor.
     *
     * @param FormLayoutRepository     $repository      Form layout repository.
     * @param FormLayoutFactory        $factory         Form layout factory.
     * @param ContaoFrameworkInterface $contaoFramework Contao framework.
     */
    public function __construct(
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        ContaoFrameworkInterface $contaoFramework
    ) {
        $this->factory         = $factory;
        $this->contaoFramework = $contaoFramework;
        $this->repository      = $repository;
    }

    /**
     * Load styles.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function initialize()
    {
        /** @var Controller $controller */
        $controller = $this->contaoFramework->getAdapter(Controller::class);
        $controller->loadLanguageFile('tl_form_field');

        $GLOBALS['TL_CSS'][] = 'bundles/netzmachtcontaoformdesigner/style/backend.css';
    }

    /**
     * Set the default layout.
     *
     * @param DataContainer $dataContainer Data container driver.
     *
     * @return void
     */
    public function setDefaultLayout($dataContainer)
    {
        if ($dataContainer->activeRecord->defaultLayout) {
            $this->repository->setDefaultLayout($dataContainer->activeRecord->pid, $dataContainer->activeRecord->id);
        }
    }

    /**
     * Generate the row label.
     *
     * @param array  $row   Data row.
     * @param string $label Default label.
     *
     * @return string
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function generateRowLabel($row, $label)
    {
        if ($row['defaultLayout']) {
            return $label . ' <span class="tl_gray">[' . $GLOBALS['TL_LANG']['tl_form_layout']['default'] . ']</span>';
        }

        return $label;
    }

    /**
     * Get the layout types.
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->factory->supportedTypes();
    }

    /**
     * Get all widget types.
     *
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getWidgetTypes()
    {
        return array_merge(
            array_keys($GLOBALS['TL_FFL']),
            [
                'number',
                'email',
                'url',
            ]
        );
    }

    /**
     * Get the layout templates.
     *
     * @return array
     */
    public function getLayoutTemplates()
    {
        return $this->getTemplateGroup('fd_layout');
    }

    /**
     * Get the control templates.
     *
     * @return array
     */
    public function getControlTemplates()
    {
        return $this->getTemplateGroup('fd_control');
    }

    /**
     * Get the label templates.
     *
     * @return array
     */
    public function getLabelTemplates()
    {
        return $this->getTemplateGroup('fd_label');
    }

    /**
     * Get the error templates.
     *
     * @return array
     */
    public function getErrorTemplates()
    {
        return $this->getTemplateGroup('fd_error');
    }

    /**
     * Get the help templates.
     *
     * @return array
     */
    public function getHelpTemplates()
    {
        return $this->getTemplateGroup('fd_help');
    }

    /**
     * Get the template group.
     *
     * @param string $groupName Group name.
     *
     * @return array
     */
    public function getTemplateGroup($groupName)
    {
        /** @var Controller $controller */
        $controller = $this->contaoFramework->getAdapter(Controller::class);

        return $controller->getTemplateGroup($groupName . '_');
    }
}
