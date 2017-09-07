<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\ContentElement;
use Contao\ContentModel;
use Contao\Model;
use Contao\ModuleModel;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Netzmacht\Contao\FormDesigner\LayoutManager;
use Netzmacht\Contao\FormDesigner\Model\Form\FormRepository;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;
use Psr\Log\LoggerInterface;

/**
 * Class IsVisibleElementListener
 *
 * @package Netzmacht\Contao\FormDesigner\Listener
 */
class ContextualFormLayoutListener extends AbstractListener
{
    /**
     * List of supported frontend modules.
     *
     * @var array
     */
    private $supportedModules;

    /**
     * List of supported content elements.
     *
     * @var array
     */
    private $supportedContentElements;

    /**
     * Form repository.
     *
     * @var FormRepository
     */
    private $formRepository;


    /**
     * HookListener constructor.
     *
     * @param LayoutManager        $manager                  Layout manager.
     * @param FormLayoutRepository $repository               Form layout repository.
     * @param FormLayoutFactory    $factory                  Form layout factory.
     * @param FormRepository       $formRepository           Form repository.
     * @param LoggerInterface      $logger                   Logger.
     * @param array                $supportedModules         Supported modules.
     * @param array                $supportedContentElements Supported content elements.
     */
    public function __construct (
        LayoutManager $manager,
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        FormRepository $formRepository,
        LoggerInterface $logger,
        array $supportedModules,
        array $supportedContentElements
    ) {
        parent::__construct($manager, $repository, $factory, $logger);

        $this->supportedModules         = $supportedModules;
        $this->supportedContentElements = $supportedContentElements;
        $this->formRepository           = $formRepository;
    }

    /**
     * Handle the is visible hook.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function onIsVisibleElement (Model $model, $visible)
    {
        // Forms are hybrid elements. The hook getForm is not used for regular ces or modules, so use this workaround.
        if (($model instanceof ContentModel || $model instanceof ModuleModel) && $model->type === 'form') {
            $this->handleForm($model);
        }

        if ($model instanceof ModuleModel) {
            $this->handleModule($model);
        }

        if ($model instanceof ContentModel) {
            $this->handleContentElement($model);
        }

        return $visible;
    }

    /**
     * Remove the contextual form element.
     *
     * @param Model  $model  Element model.
     * @param string $buffer Generated content.
     *
     * @return string
     */
    public function onPostGenerateElement (Model $model, $buffer)
    {
        $this->manager->removeContextLayout();

        return $buffer;
    }

    /**
     * Handle a form.
     *
     * @param Model $model Form model.
     */
    private function handleForm (Model $model)
    {
        $form = $this->formRepository->find($model->form);
        if (!$form) {
            return;
        }

        $layoutId = (int) $form->formLayout;
        if (!$layoutId) {
            return;
        }

        $this->registerContextLayout($layoutId);
    }

    /**
     * @param ModuleModel $model
     */
    private function handleModule (ModuleModel $model)
    {
        if (!in_array($model->type, $this->supportedModules)) {
            return;
        }

        $this->registerContextLayout($model->formLayout);
    }

    /**
     * @param ContentModel $model
     */
    private function handleContentElement ($model)
    {
        if (!in_array($model->type, $this->supportedContentElements)) {
            return;
        }

        $this->registerContextLayout($model->formLayout);
    }

    /**
     * Register a form layout in a form context.
     *
     * @param int $layoutId Form layout id.
     *
     * @return void
     */
    private function registerContextLayout ($layoutId)
    {
        $layoutId = (int) $layoutId;
        if (!$layoutId) {
            return;
        }

        $model = $this->repository->find($layoutId);
        if (!$model) {
            return;
        }

        $this->createFormLayout(
            $model,
            function (LayoutManager $manager, FormLayout $formLayout) {
                $manager->setContextLayout($formLayout);
            }
        );
    }
}
