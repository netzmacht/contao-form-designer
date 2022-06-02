<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\CoreBundle\Monolog\ContaoContext;
use Netzmacht\Contao\FormDesigner\Exception\CreatingLayoutFailed;
use Netzmacht\Contao\FormDesigner\Factory\FormLayoutFactory;
use Netzmacht\Contao\FormDesigner\LayoutManager;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutModel;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

abstract class AbstractListener
{
    /**
     * Layout manager.
     *
     * @var LayoutManager
     */
    protected LayoutManager $manager;

    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    protected FormLayoutRepository $repository;

    /**
     * Form layout factory.
     *
     * @var FormLayoutFactory
     */
    protected FormLayoutFactory $factory;

    /**
     * Error logger.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LayoutManager        $manager    Layout manager.
     * @param FormLayoutRepository $repository Form layout repository.
     * @param FormLayoutFactory    $factory    Form layout factory.
     * @param LoggerInterface      $logger     Logger.
     */
    public function __construct(
        LayoutManager $manager,
        FormLayoutRepository $repository,
        FormLayoutFactory $factory,
        LoggerInterface $logger
    ) {
        $this->manager    = $manager;
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->logger     = $logger;
    }

    /**
     * Create form layout.
     *
     * @param FormLayoutModel $model    Form layout model.
     * @param callable        $callback Callback to handle an created.
     */
    protected function createFormLayout(FormLayoutModel $model, callable $callback): void
    {
        try {
            $formLayout = $this->factory->create((string) $model->type, $model->row());
            $callback($this->manager, $formLayout);
        } catch (CreatingLayoutFailed $e) {
            $this->logger->log(
                LogLevel::ERROR,
                $e->getMessage(),
                ['contao' => new ContaoContext(__METHOD__, TL_ERROR)]
            );
        }
    }
}
