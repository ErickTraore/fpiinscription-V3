<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726101650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fpicount ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fpicount ADD CONSTRAINT FK_F3CE4B93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F3CE4B93A76ED395 ON fpicount (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fpicount DROP FOREIGN KEY FK_F3CE4B93A76ED395');
        $this->addSql('DROP INDEX IDX_F3CE4B93A76ED395 ON fpicount');
        $this->addSql('ALTER TABLE fpicount DROP user_id');
    }
}
