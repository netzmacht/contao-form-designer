<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;

final class WidgetsGroupIndexMigration extends AbstractMigration
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();
        if (! $schemaManager->tablesExist(['tl_form_layout'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_form_layout');
        if (! isset($columns['widgets'])) {
            return false;
        }

        $affected = (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM tl_form_layout WHERE widgets LIKE \'a:1:{i:0;%\''
        );

        return $affected > 0;
    }

    public function run(): MigrationResult
    {
        $result = $this->connection->fetchAllAssociative(
            'SELECT * FROM tl_form_layout WHERE widgets LIKE \'a:1:{i:0;%\''
        );

        foreach ($result as $row) {
            $templates = [];

            foreach (StringUtil::deserialize($row['widgets'], true) as $key => $template) {
                if (is_numeric($key)) {
                    $key = $key + 1;
                }

                $templates[$key] = $template;
            }

            $this->connection->update(
                'tl_form_layout',
                ['widgets' => serialize($templates)],
                ['id' => $row['id']]
            );
        }

        return $this->createResult(true);
    }
}
