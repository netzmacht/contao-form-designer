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
     * @var FormLayoutFactory
     */
    private $factory;

    /**
     * @var ContaoFrameworkInterface
     */
    private $contaoFramework;

    /**
     * @var FormLayoutRepository
     */
    private $repository;

    /**
     * FormLayoutListener constructor.
     *
     * @param FormLayoutRepository     $repository
     * @param FormLayoutFactory        $factory
     * @param ContaoFrameworkInterface $contaoFramework
     */
    public function __construct (
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
     */
    public function loadStyles ()
    {
        $GLOBALS['TL_CSS'][] = 'bundles/netzmachtcontaoformdesigner/style/backend.css';
    }

    /**
     * Set the default layout.
     *
     * @param $dataContainer
     *
     * @return void
     */
    public function setDefaultLayout ($dataContainer)
    {
        if ($dataContainer->activeRecord->defaultLayout) {
            $this->repository->setDefaultLayout($dataContainer->activeRecord->pid, $dataContainer->activeRecord->id);
        }
    }

    /**
     * @param $label
     * @param $row
     *
     * @return string
     */
    public function generateRowLabel ($row, $label)
    {
        if ($row['defaultLayout']) {
            return $label . ' <span class="tl_gray">[' . $GLOBALS['TL_LANG']['tl_form_layout']['default'] . ']</span>';
        }

        return $label;
    }

    /**
     * @return array
     */
    public function getTypes ()
    {
        return $this->factory->supportedTypes();
    }


    /**
     * Get all widget types.
     *
     * return @array
     */
    public function getWidgetTypes ()
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
     * @return array
     */
    public function getLayoutTemplates ()
    {
        return $this->getTemplateGroup('fd_layout');
    }

    /**
     * @return array
     */
    public function getControlTemplates ()
    {
        return $this->getTemplateGroup('fd_control');
    }

    /**
     * @return array
     */
    public function getLabelTemplates ()
    {
        return $this->getTemplateGroup('fd_label');
    }

    /**
     * @return array
     */
    public function getErrorTemplates ()
    {
        return $this->getTemplateGroup('fd_error');
    }

    /**
     * @return array
     */
    public function getHelpTemplates ()
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
    public function getTemplateGroup ($groupName)
    {
        /** @var Controller $controller */
        $controller = $this->contaoFramework->getAdapter(Controller::class);

        return $controller->getTemplateGroup($groupName . '_');
    }
}
