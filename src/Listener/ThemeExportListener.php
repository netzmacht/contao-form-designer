<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener;

use Contao\Theme;
use Contao\ZipWriter;
use DOMDocument;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

class ThemeExportListener extends Theme
{
    /**
     * Form layout repository.
     */
    private FormLayoutRepository $formLayoutRepository;

    /** @param FormLayoutRepository $formLayoutRepository Form layout repository. */
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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onExportTheme(DOMDocument $xml, ZipWriter $archive, int|string $themeId): void
    {
        // Add the tables
        $formLayoutTable = $xml->createElement('table');
        $formLayoutTable->setAttribute('name', 'tl_form_layout');

        $tables          = $xml->getElementsByTagName('tables')->item(0);
        $formLayoutTable = $tables->appendChild($formLayoutTable);
        $collection      = $this->formLayoutRepository->findByTheme((int) $themeId);

        if (! $collection) {
            return;
        }

        foreach ($collection as $model) {
            $this->addDataRow($xml, $formLayoutTable, $model->row());
        }
    }
}
