<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219083839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add reset_password_token column to user table';
    }

    public function up(Schema $schema): void
    {
        // Add the reset_password_token column to the user table
        $table = $schema->getTable('user');
        $table->addColumn('reset_password_token', 'string', ['length' => 255, 'nullable' => true]);
    }

    public function down(Schema $schema): void
    {
        // Remove the reset_password_token column if rolling back the migration
        $schema->getTable('user')->dropColumn('reset_password_token');
    }
}
