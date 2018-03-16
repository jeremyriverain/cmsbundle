<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180316071214 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE boolean_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value TINYINT(1) NOT NULL, label VARCHAR(255) DEFAULT NULL, INDEX IDX_9031FE4E89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value LONGTEXT DEFAULT NULL, is_html TINYINT(1) NOT NULL, configuration LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', label VARCHAR(255) DEFAULT NULL, INDEX IDX_AD3780489329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_7D053A935E237E06 (name), INDEX IDX_7D053A93727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(100) NOT NULL, categorie VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE integer_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value INT DEFAULT NULL, constraints LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', label VARCHAR(255) DEFAULT NULL, INDEX IDX_BC7E8F0989329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, configuration LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', compound_value LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', updated_at DATETIME DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_140AB6205E237E06 (name), UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_tag (page_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_CF36BF12C4663E4 (page_id), INDEX IDX_CF36BF12BAD26311 (tag_id), PRIMARY KEY(page_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, temporary_file VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_33617ABE89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_resource (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value INT NOT NULL, label VARCHAR(255) DEFAULT NULL, INDEX IDX_3C0EF336C4663E4 (page_id), INDEX IDX_3C0EF33689329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password_requested_at DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, INDEX IDX_60146F5489329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_item (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, menu_id INT NOT NULL, position INT NOT NULL, INDEX IDX_D754D550C4663E4 (page_id), INDEX IDX_D754D550CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE string_resource (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, help VARCHAR(255) DEFAULT NULL, constraints LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', label VARCHAR(255) DEFAULT NULL, INDEX IDX_19A317D589329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, resource_id INT DEFAULT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_base TINYINT(1) NOT NULL, manageable TINYINT(1) NOT NULL, only_one TINYINT(1) NOT NULL, has_form TINYINT(1) NOT NULL, are_children_positionable TINYINT(1) NOT NULL, is_positionable_in_the_page TINYINT(1) NOT NULL, creator_able TINYINT(1) NOT NULL, path_theme_relative VARCHAR(255) DEFAULT NULL, options LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', deletable TINYINT(1) NOT NULL, has_ckeditor_resource TINYINT(1) NOT NULL, position INT NOT NULL, label VARCHAR(255) DEFAULT NULL, INDEX IDX_C242628727ACA70 (parent_id), UNIQUE INDEX UNIQ_C24262889329D25 (resource_id), INDEX IDX_C242628C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boolean_resource ADD CONSTRAINT FK_9031FE4E89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE text_resource ADD CONSTRAINT FK_AD3780489329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93727ACA70 FOREIGN KEY (parent_id) REFERENCES menu (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE integer_resource ADD CONSTRAINT FK_BC7E8F0989329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE page_tag ADD CONSTRAINT FK_CF36BF12C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_tag ADD CONSTRAINT FK_CF36BF12BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_resource ADD CONSTRAINT FK_33617ABE89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE page_resource ADD CONSTRAINT FK_3C0EF336C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE page_resource ADD CONSTRAINT FK_3C0EF33689329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE color_resource ADD CONSTRAINT FK_60146F5489329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE string_resource ADD CONSTRAINT FK_19A317D589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628727ACA70 FOREIGN KEY (parent_id) REFERENCES module (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C24262889329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93727ACA70');
        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550CCD7E912');
        $this->addSql('ALTER TABLE page_tag DROP FOREIGN KEY FK_CF36BF12BAD26311');
        $this->addSql('ALTER TABLE boolean_resource DROP FOREIGN KEY FK_9031FE4E89329D25');
        $this->addSql('ALTER TABLE text_resource DROP FOREIGN KEY FK_AD3780489329D25');
        $this->addSql('ALTER TABLE integer_resource DROP FOREIGN KEY FK_BC7E8F0989329D25');
        $this->addSql('ALTER TABLE image_resource DROP FOREIGN KEY FK_33617ABE89329D25');
        $this->addSql('ALTER TABLE page_resource DROP FOREIGN KEY FK_3C0EF33689329D25');
        $this->addSql('ALTER TABLE color_resource DROP FOREIGN KEY FK_60146F5489329D25');
        $this->addSql('ALTER TABLE string_resource DROP FOREIGN KEY FK_19A317D589329D25');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C24262889329D25');
        $this->addSql('ALTER TABLE page_tag DROP FOREIGN KEY FK_CF36BF12C4663E4');
        $this->addSql('ALTER TABLE page_resource DROP FOREIGN KEY FK_3C0EF336C4663E4');
        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550C4663E4');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C4663E4');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628727ACA70');
        $this->addSql('DROP TABLE boolean_resource');
        $this->addSql('DROP TABLE text_resource');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE integer_resource');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_tag');
        $this->addSql('DROP TABLE image_resource');
        $this->addSql('DROP TABLE page_resource');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE color_resource');
        $this->addSql('DROP TABLE menu_item');
        $this->addSql('DROP TABLE string_resource');
        $this->addSql('DROP TABLE module');
    }
}
