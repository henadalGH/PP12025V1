<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250712134014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, contacto VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_F41C9B25DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilidad (id INT AUTO_INCREMENT NOT NULL, peluquero_id INT NOT NULL, dia DATE NOT NULL, hora_inicio TIME NOT NULL, hora_fin TIME NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_4B6AAB2FF037A736 (peluquero_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peluquero (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, UNIQUE INDEX UNIQ_8F1334E0DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, peluquero_id INT NOT NULL, cliente_id INT NOT NULL, servicio_id INT NOT NULL, fecha_hora DATETIME NOT NULL, estado VARCHAR(100) NOT NULL, INDEX IDX_188D2E3BF037A736 (peluquero_id), INDEX IDX_188D2E3BDE734E51 (cliente_id), INDEX IDX_188D2E3B71CAA3E7 (servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, duracion INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE disponibilidad ADD CONSTRAINT FK_4B6AAB2FF037A736 FOREIGN KEY (peluquero_id) REFERENCES peluquero (id)');
        $this->addSql('ALTER TABLE peluquero ADD CONSTRAINT FK_8F1334E0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BF037A736 FOREIGN KEY (peluquero_id) REFERENCES peluquero (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B71CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25DB38439E');
        $this->addSql('ALTER TABLE disponibilidad DROP FOREIGN KEY FK_4B6AAB2FF037A736');
        $this->addSql('ALTER TABLE peluquero DROP FOREIGN KEY FK_8F1334E0DB38439E');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BF037A736');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BDE734E51');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B71CAA3E7');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE disponibilidad');
        $this->addSql('DROP TABLE peluquero');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
