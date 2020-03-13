<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313144148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prix ADD edition_festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prix ADD CONSTRAINT FK_F7EFEA5ECFFA8989 FOREIGN KEY (edition_festival_id) REFERENCES edition_festival (id)');
        $this->addSql('CREATE INDEX IDX_F7EFEA5ECFFA8989 ON prix (edition_festival_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prix DROP FOREIGN KEY FK_F7EFEA5ECFFA8989');
        $this->addSql('DROP INDEX IDX_F7EFEA5ECFFA8989 ON prix');
        $this->addSql('ALTER TABLE prix DROP edition_festival_id');
    }
}
