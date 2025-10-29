<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoriesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('text', 'string', ['limit' => 200])
            ->create();
    }
}
