<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

use Doctrine\DBAL\Connection;

/**
 * Class FormLayoutRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\FormLayout
 */
class ContaoFormLayoutRepository implements FormLayoutRepository
{
    /**
     * Database connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * ContaoFormLayoutRepository constructor.
     *
     * @param Connection $connection Database connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function findDefaultByTheme($themeId)
    {
        return FormLayoutModel::findOneBy(['tl_form_layout.pid=?', 'tl_form_layout.defaultLayout=1'], [$themeId]);
    }

    /**
     * {@inheritdoc}
     */
    public function find($layoutId)
    {
        return FormLayoutModel::findByPk($layoutId);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultLayout($themeId, $defaultLayoutId)
    {
        $statement = $this->connection->prepare('UPDATE tl_form_layout SET defaultLayout=? WHERE pid=? AND id!=?');
        $statement->bindValue(1, '');
        $statement->bindValue(2, $themeId);
        $statement->bindValue(3, $defaultLayoutId);
        $statement->execute();

        $statement = $this->connection->prepare('UPDATE tl_form_layout SET defaultLayout=? WHERE id=?');
        $statement->bindValue(1, 1);
        $statement->bindValue(2, $defaultLayoutId);
        $statement->execute();
    }
}
