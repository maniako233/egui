<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101150820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detailorder ADD product_id INT NOT NULL, ADD commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE detailorder ADD CONSTRAINT FK_5F590B0C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detailorder ADD CONSTRAINT FK_5F590B0C82EA2E54 FOREIGN KEY (commande_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5F590B0C4584665A ON detailorder (product_id)');
        $this->addSql('CREATE INDEX IDX_5F590B0C82EA2E54 ON detailorder (commande_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE product ADD coupe_id INT NOT NULL, ADD type_id INT NOT NULL, ADD supplier_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD717D2393 FOREIGN KEY (coupe_id) REFERENCES coupe (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD717D2393 ON product (coupe_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADC54C8C93 ON product (type_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD2ADD6D8C ON product (supplier_id)');
        $this->addSql('ALTER TABLE user ADD supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492ADD6D8C ON user (supplier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detailorder DROP FOREIGN KEY FK_5F590B0C4584665A');
        $this->addSql('ALTER TABLE detailorder DROP FOREIGN KEY FK_5F590B0C82EA2E54');
        $this->addSql('DROP INDEX IDX_5F590B0C4584665A ON detailorder');
        $this->addSql('DROP INDEX IDX_5F590B0C82EA2E54 ON detailorder');
        $this->addSql('ALTER TABLE detailorder DROP product_id, DROP commande_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD717D2393');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC54C8C93');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2ADD6D8C');
        $this->addSql('DROP INDEX IDX_D34A04AD717D2393 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADC54C8C93 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD2ADD6D8C ON product');
        $this->addSql('ALTER TABLE product DROP coupe_id, DROP type_id, DROP supplier_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492ADD6D8C');
        $this->addSql('DROP INDEX UNIQ_8D93D6492ADD6D8C ON user');
        $this->addSql('ALTER TABLE user DROP supplier_id');
    }
}
