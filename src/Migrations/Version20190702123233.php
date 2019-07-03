<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190702123233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chapters ADD articles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C72143711EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_C72143711EBAF6CC ON chapters (articles_id)');
        $this->addSql('ALTER TABLE articles ADD author_id INT NOT NULL, ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F675F31B FOREIGN KEY (author_id) REFERENCES authors (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31683DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BFDD3168F675F31B ON articles (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BFDD31683DA5256D ON articles (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168F675F31B');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31683DA5256D');
        $this->addSql('DROP INDEX UNIQ_BFDD3168F675F31B ON articles');
        $this->addSql('DROP INDEX UNIQ_BFDD31683DA5256D ON articles');
        $this->addSql('ALTER TABLE articles DROP author_id, DROP image_id');
        $this->addSql('ALTER TABLE chapters DROP FOREIGN KEY FK_C72143711EBAF6CC');
        $this->addSql('DROP INDEX IDX_C72143711EBAF6CC ON chapters');
        $this->addSql('ALTER TABLE chapters DROP articles_id');
    }
}
