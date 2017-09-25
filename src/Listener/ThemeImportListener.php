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

use Contao\ZipReader;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutModel;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class ThemeImportListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener
 */
class ThemeImportListener
{
    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    private $formLayoutRepository;

    /**
     * ThemeImportListener constructor.
     *
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository)
    {
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Handle the extract theme files hook.
     *
     * @param \DOMDocument $xml     Theme xml document.
     * @param ZipReader    $archive Zip archive.
     * @param int|string   $themeId Theme id.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onExtractThemeFiles(\DOMDocument $xml, ZipReader $archive, $themeId): void
    {
        $tables = $xml->getElementsByTagName('table');

        for ($index = 0; $index < $tables->length; $index++) {
            if ($tables->item($index)->getAttribute('name') !== 'tl_form_layout') {
                continue;
            }

            $this->importFormLayout($tables->item($index), (int) $themeId);
        }
    }

    /**
     * Import the form layout rows.
     *
     * @param \DOMElement $item    Table item.
     * @param int         $themeId Theme id.
     *
     * @return void
     */
    private function importFormLayout(\DOMElement $item, int $themeId): void
    {
        $rows = $item->childNodes;

        for ($index = 0; $index < $rows->length; $index++) {
            $values = $this->getRowValues($rows->item($index), $themeId);
            $model  = new FormLayoutModel();

            $model->setRow($values);
            $this->formLayoutRepository->add($model);
        }
    }

    /**
     * Prepare row values.
     *
     * @param \DOMElement $item    Row item element.
     * @param int         $themeId Theme id.
     *
     * @return array
     */
    private function getRowValues(\DOMElement $item, int $themeId): array
    {
        $fields = $item->childNodes;
        $values = [];

        for ($index = 0; $index < $fields->length; $index++) {
            $value = $fields->item($index)->nodeValue;
            $name  = $fields->item($index)->getAttribute('name');

            switch ($name) {
                case 'id':
                    continue;

                case 'pid':
                    $value = $themeId;

                    // No break
                default:
                    $values[$name] = $value;
            }
        }

        return $values;
    }
}
