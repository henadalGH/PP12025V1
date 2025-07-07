<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707111821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B25DB38439E ON cliente (usuario_id)');
        $this->addSql('ALTER TABLE peluquero ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE peluquero ADD CONSTRAINT FK_8F1334E0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F1334E0DB38439E ON peluquero (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25DB38439E');
        $this->addSql('DROP INDEX UNIQ_F41C9B25DB38439E ON cliente');
        $this->addSql('ALTER TABLE cliente DROP usuario_id');
        $this->addSql('ALTER TABLE peluquero DROP FOREIGN KEY FK_8F1334E0DB38439E');
        $this->addSql('DROP INDEX UNIQ_8F1334E0DB38439E ON peluquero');
        $this->addSql('ALTER TABLE peluquero DROP usuario_id');
    }
}
