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

namespace Netzmacht\Contao\FormDesigner\Listener;

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
 * Class IsVisibleElementListener.
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
    private $supportedElements;

    /**
     * Form repository.
     *
     * @var FormRepository
     */
    private $formRepository;


    /**
     * HookListener constructor.
     *
     * @param LayoutManager        $manager           Layout manager.
     * @param FormLayoutRepository $repository        Form layout repository.
     * @param FormLayoutFactory    $factory           Form layout factory.
     * @param FormRepository       $formRepository    Form repository.
     * @param LoggerInterface      $logger            Logger.
     * @param array                $supportedModules  Supported modules.
     * @param array                $supportedElements Supported content elements.
     */
    public function __construct(
        LayoutManager $manager,
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        FormRepository $formRepository,
        LoggerInterface $logger,
        array $supportedModules,
        array $supportedElements
    ) {
        parent::__construct($manager, $repository, $factory, $logger);

        $this->supportedModules  = $supportedModules;
        $this->supportedElements = $supportedElements;
        $this->formRepository    = $formRepository;
    }

    /**
     * Handle the is visible hook.
     *
     * @param Model $model   Model.
     * @param bool  $visible Visible flag.
     *
     * @return bool
     */
    public function onIsVisibleElement(Model $model, $visible): bool
    {
        if (TL_MODE === 'BE') {
            return $visible;
        }

        if ($model instanceof ContentModel) {
            if ($this->handleContentElement($model)) {
                return $visible;
            }
        }

        if ($model instanceof ModuleModel) {
            if ($this->handleModule($model)) {
                return $visible;
            };
        }


        // Forms are hybrid elements. The hook getForm is not used for regular ces or modules, so use this workaround.
        if (($model instanceof ContentModel || $model instanceof ModuleModel) && $model->type === 'form') {
            $this->handleForm($model);
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onPostGenerateElement(Model $model, $buffer): string
    {
        $this->manager->removeContextLayout();

        return $buffer;
    }

    /**
     * Handle a form.
     *
     * @param Model $model Form model.
     *
     * @return bool
     */
    private function handleForm(Model $model): bool
    {
        $form = $this->formRepository->find((int) $model->form);
        if (!$form) {
            return false;
        }

        return $this->registerContextLayout((int) $form->formLayout);
    }

    /**
     * Handle a module.
     *
     * @param ModuleModel $model Module model.
     *
     * @return bool
     */
    private function handleModule(ModuleModel $model): bool
    {
        if (!in_array($model->type, $this->supportedModules)) {
            return false;
        }

        return $this->registerContextLayout((int) $model->formLayout);
    }

    /**
     * Handle a content element.
     *
     * @param ContentModel $model Content model.
     *
     * @return bool
     */
    private function handleContentElement(ContentModel $model): bool
    {
        if (!in_array($model->type, $this->supportedElements)) {
            return false;
        }

        return $this->registerContextLayout((int) $model->formLayout);
    }

    /**
     * Register a form layout in a form context.
     *
     * @param int $layoutId Form layout id.
     *
     * @return bool
     */
    private function registerContextLayout(int $layoutId): bool
    {
        $layoutId = (int) $layoutId;
        if (!$layoutId) {
            return false;
        }

        $model = $this->repository->find($layoutId);
        if (!$model) {
            return false;
        }

        $this->createFormLayout(
            $model,
            function (LayoutManager $manager, FormLayout $formLayout) {
                $manager->setContextLayout($formLayout);
            }
        );

        return true;
    }
}
