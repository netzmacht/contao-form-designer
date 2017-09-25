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

use Contao\Theme;
use Contao\ZipWriter;
use DOMDocument;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class ThemeExportListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener
 */
class ThemeExportListener extends Theme
{
    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    private $formLayoutRepository;

    /**
     * ThemeExportListener constructor.
     *
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository)
    {
        parent::__construct();

        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Handle the export theme hook.
     *
     * @param DOMDocument $xml     Xml document.
     * @param ZipWriter   $archive Zip archive.
     * @param int|string  $themeId Theme id.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onExportTheme(DOMDocument $xml, ZipWriter $archive, $themeId): void
    {
        // Add the tables
        $formLayoutTable = $xml->createElement('table');
        $formLayoutTable->setAttribute('name', 'tl_form_layout');

        $tables          = $xml->getElementsByTagName('tables')->item(0);
        $formLayoutTable = $tables->appendChild($formLayoutTable);
        $collection      = $this->formLayoutRepository->findByTheme((int) $themeId);

        if ($collection) {
            foreach ($collection as $model) {
                $this->addDataRow($xml, $formLayoutTable, $model->row());
            }
        }
    }
}
