<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221209104438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP adresse_livraison, DROP numero_telephone');
        $this->addSql('ALTER TABLE user ADD adresse_livraison LONGTEXT DEFAULT NULL, ADD numero_telephone INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD adresse_livraison VARCHAR(255) NOT NULL, ADD numero_telephone INT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP adresse_livraison, DROP numero_telephone');
    }
}
