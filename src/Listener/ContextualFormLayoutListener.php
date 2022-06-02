<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\ContentModel;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Model;
use Contao\ModuleModel;
use Netzmacht\Contao\FormDesigner\Event\SelectLayoutEvent;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Netzmacht\Contao\FormDesigner\LayoutManager;
use Netzmacht\Contao\FormDesigner\Model\Form\FormRepository;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;
use Psr\Log\LoggerInterface;

use function assert;
use function in_array;

class ContextualFormLayoutListener extends AbstractListener
{
    /**
     * List of supported frontend modules.
     *
     * @var list<string>
     */
    private array $supportedModules;

    /**
     * List of supported content elements.
     *
     * @var list<string>
     */
    private array $supportedElements;

    /**
     * Form repository.
     */
    private FormRepository $formRepository;

    /**
     * Contao framework.
     */
    private ContaoFramework $framework;

    /**
     * @param LayoutManager        $manager           Layout manager.
     * @param FormLayoutRepository $repository        Form layout repository.
     * @param FormLayoutFactory    $factory           Form layout factory.
     * @param FormRepository       $formRepository    Form repository.
     * @param ContaoFramework      $framework         Contao framework.
     * @param LoggerInterface      $logger            Logger.
     * @param list<string>         $supportedModules  Supported modules.
     * @param list<string>         $supportedElements Supported content elements.
     */
    public function __construct(
        LayoutManager $manager,
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        FormRepository $formRepository,
        ContaoFramework $framework,
        LoggerInterface $logger,
        array $supportedModules,
        array $supportedElements
    ) {
        parent::__construct($manager, $repository, $factory, $logger);

        $this->supportedModules  = $supportedModules;
        $this->supportedElements = $supportedElements;
        $this->formRepository    = $formRepository;
        $this->framework         = $framework;
    }

    /**
     * Handle the is visible hook.
     *
     * @param Model $model   Model.
     * @param bool  $visible Visible flag.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function onIsVisibleElement(Model $model, bool $visible): bool
    {
        if (TL_MODE === 'BE') {
            return $visible;
        }

        if ($model instanceof ContentModel) {
            if ($model->type === 'module') {
                $repository = $this->framework->getAdapter(ModuleModel::class);
                assert($repository instanceof ModuleModel || $repository instanceof Adapter);
                $model = $repository->findByPk($model->module);

                if (! $model) {
                    return $visible;
                }
            } elseif ($this->handleContentElement($model)) {
                return $visible;
            }
        }

        if ($model instanceof ModuleModel) {
            if ($this->handleModule($model)) {
                return $visible;
            }
        }

        // Forms are hybrid elements. The hook getForm is not used for regular ces or modules, so use this workaround.
        if ($this->isOfTypeForm($model)) {
            $this->handleForm($model);
        }

        return $visible;
    }

    /**
     * Remove the contextual form element.
     *
     * @param Model       $model  Element model.
     * @param string|bool $buffer Generated content.
     *
     * @return string|bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onPostGenerateElement(Model $model, $buffer)
    {
        $this->manager->removeContextLayout();

        return (string) $buffer;
    }

    /**
     * Use a custom form layout based on widget.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onSelectLayout(SelectLayoutEvent $event): void
    {
        if ($event->getLayout() !== null || $event->getWidget()->formLayout < 1) {
            return;
        }

        $model = $this->repository->find((int) $event->getWidget()->formLayout);
        if (! $model) {
            return;
        }

        $this->createFormLayout(
            $model,
            static function (LayoutManager $manager, FormLayout $formLayout) use ($event): void {
                $event->setLayout($formLayout);
            }
        );
    }

    /**
     * Handle a form.
     *
     * @param Model $model Form model.
     */
    private function handleForm(Model $model): bool
    {
        $form = $this->formRepository->find((int) $model->form);
        if (! $form) {
            return false;
        }

        return $this->registerContextLayout((int) $form->formLayout);
    }

    /**
     * Handle a module.
     *
     * @param ModuleModel $model Module model.
     */
    private function handleModule(ModuleModel $model): bool
    {
        if (! in_array($model->type, $this->supportedModules)) {
            return false;
        }

        return $this->registerContextLayout((int) $model->formLayout);
    }

    /**
     * Handle a content element.
     *
     * @param ContentModel $model Content model.
     */
    private function handleContentElement(ContentModel $model): bool
    {
        if (! in_array($model->type, $this->supportedElements)) {
            return false;
        }

        return $this->registerContextLayout((int) $model->formLayout);
    }

    /**
     * Register a form layout in a form context.
     *
     * @param int $layoutId Form layout id.
     */
    private function registerContextLayout(int $layoutId): bool
    {
        $layoutId = (int) $layoutId;
        if (! $layoutId) {
            return false;
        }

        $model = $this->repository->find($layoutId);
        if (! $model) {
            return false;
        }

        $this->createFormLayout(
            $model,
            static function (LayoutManager $manager, FormLayout $formLayout): void {
                $manager->setContextLayout($formLayout);
            }
        );

        return true;
    }

    /**
     * Check if the configured type is a form element.
     *
     * @param Model $model The given model.
     */
    protected function isOfTypeForm(Model $model): bool
    {
        return ($model instanceof ContentModel || $model instanceof ModuleModel) && $model->type === 'form';
    }
}
