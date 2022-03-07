<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307203417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO person(`name`, `birthday`)
            VALUES 
           ("tino","1988/11/03"),
           ("agata","1988/01/17"),
           ("allen","2017/03/08");
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM person WHERE `name` IN ("tino", "agata", "allen")');
    }
}
