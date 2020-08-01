<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725182254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fpicount (id INT AUTO_INCREMENT NOT NULL, adhesion_id INT NOT NULL, ref VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, p_un_ht NUMERIC(10, 0) DEFAULT NULL, qte INT DEFAULT NULL, remise NUMERIC(10, 0) DEFAULT NULL, p_un_ht_rem NUMERIC(10, 0) DEFAULT NULL, prix_tot_ht NUMERIC(10, 0) DEFAULT NULL, tva NUMERIC(10, 0) DEFAULT NULL, date_bill DATETIME DEFAULT NULL, total_ttc NUMERIC(10, 0) DEFAULT NULL, tot_cumul NUMERIC(10, 0) DEFAULT NULL, date_cumul DATETIME DEFAULT NULL, date_echeance DATETIME DEFAULT NULL, INDEX IDX_F3CE4B93F68139D7 (adhesion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fpicount ADD CONSTRAINT FK_F3CE4B93F68139D7 FOREIGN KEY (adhesion_id) REFERENCES adhesion (id)');
        $this->addSql('DROP TABLE count');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE count (id INT AUTO_INCREMENT NOT NULL, adhesion_id INT NOT NULL, ref VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, p_un_ht NUMERIC(10, 0) DEFAULT NULL, qte INT DEFAULT NULL, remise NUMERIC(10, 0) DEFAULT NULL, p_un_ht_rem NUMERIC(10, 0) DEFAULT NULL, prix_tot_ht NUMERIC(10, 0) DEFAULT NULL, tva NUMERIC(10, 0) DEFAULT NULL, date_bill DATETIME DEFAULT NULL, total_ttc NUMERIC(10, 0) DEFAULT NULL, tot_cumul NUMERIC(10, 0) DEFAULT NULL, date_cumul DATETIME DEFAULT NULL, date_echeance DATETIME DEFAULT NULL, INDEX IDX_85D94462F68139D7 (adhesion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE count ADD CONSTRAINT FK_85D94462F68139D7 FOREIGN KEY (adhesion_id) REFERENCES adhesion (id)');
        $this->addSql('DROP TABLE fpicount');
    }
}
