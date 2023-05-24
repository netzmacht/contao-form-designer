<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

use Contao\Model\Collection;
use Doctrine\DBAL\Connection;

class ContaoFormLayoutRepository implements FormLayoutRepository
{
    /**
     * Database connection.
     */
    private Connection $connection;

    /** @param Connection $connection Database connection. */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findDefaultByTheme(int $themeId): FormLayoutModel|null
    {
        return FormLayoutModel::findOneBy(['tl_form_layout.pid=?', 'tl_form_layout.defaultLayout=1'], [$themeId]);
    }

    public function find(int $layoutId): FormLayoutModel|null
    {
        return FormLayoutModel::findByPk($layoutId);
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function findByTheme(int $themeId): Collection|null
    {
        return FormLayoutModel::findBy('pid', $themeId);
    }

    public function findAll(): Collection|null
    {
        return FormLayoutModel::findAll();
    }

    public function add(FormLayoutModel $model): void
    {
        $model->save();
    }

    public function setDefaultLayout(int $themeId, int $defaultLayoutId): void
    {
        $statement = $this->connection->prepare('UPDATE tl_form_layout SET defaultLayout=? WHERE pid=? AND id!=?');
        $statement->bindValue(1, '');
        $statement->bindValue(2, $themeId);
        $statement->bindValue(3, $defaultLayoutId);
        $statement->executeStatement();

        $statement = $this->connection->prepare('UPDATE tl_form_layout SET defaultLayout=? WHERE id=?');
        $statement->bindValue(1, 1);
        $statement->bindValue(2, $defaultLayoutId);
        $statement->executeStatement();
    }
}
