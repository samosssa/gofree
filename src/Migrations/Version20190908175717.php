<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190908175717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, skills_id INT DEFAULT NULL, user_soc_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, start_day DATE NOT NULL, end_date DATE NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, cover_image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9067F23C12469DE2 (category_id), INDEX IDX_9067F23C7FF61858 (skills_id), INDEX IDX_9067F23CF2D761A2 (user_soc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apply (id INT AUTO_INCREMENT NOT NULL, freelancer_id INT NOT NULL, mission_id INT NOT NULL, user_soc_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_BD2F8C1F8545BDF5 (freelancer_id), INDEX IDX_BD2F8C1FBE6CAE90 (mission_id), INDEX IDX_BD2F8C1FF2D761A2 (user_soc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, introduction VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_mission (user_id INT NOT NULL, mission_id INT NOT NULL, INDEX IDX_C86AEC36A76ED395 (user_id), INDEX IDX_C86AEC36BE6CAE90 (mission_id), PRIMARY KEY(user_id, mission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_skill (user_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_BCFF1F2FA76ED395 (user_id), INDEX IDX_BCFF1F2F5585C142 (skill_id), PRIMARY KEY(user_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_soc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tva BIGINT NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, introduction VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_soc_role (user_soc_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9880E18EF2D761A2 (user_soc_id), INDEX IDX_9880E18ED60322AC (role_id), PRIMARY KEY(user_soc_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_soc_mission (user_soc_id INT NOT NULL, mission_id INT NOT NULL, INDEX IDX_6153623FF2D761A2 (user_soc_id), INDEX IDX_6153623FBE6CAE90 (mission_id), PRIMARY KEY(user_soc_id, mission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_soc_skill (user_soc_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_F9952B7DF2D761A2 (user_soc_id), INDEX IDX_F9952B7D5585C142 (skill_id), PRIMARY KEY(user_soc_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C7FF61858 FOREIGN KEY (skills_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF2D761A2 FOREIGN KEY (user_soc_id) REFERENCES user_soc (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F8545BDF5 FOREIGN KEY (freelancer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1FBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1FF2D761A2 FOREIGN KEY (user_soc_id) REFERENCES user_soc (id)');
        $this->addSql('ALTER TABLE user_mission ADD CONSTRAINT FK_C86AEC36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_mission ADD CONSTRAINT FK_C86AEC36BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_role ADD CONSTRAINT FK_9880E18EF2D761A2 FOREIGN KEY (user_soc_id) REFERENCES user_soc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_role ADD CONSTRAINT FK_9880E18ED60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_mission ADD CONSTRAINT FK_6153623FF2D761A2 FOREIGN KEY (user_soc_id) REFERENCES user_soc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_mission ADD CONSTRAINT FK_6153623FBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_skill ADD CONSTRAINT FK_F9952B7DF2D761A2 FOREIGN KEY (user_soc_id) REFERENCES user_soc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_soc_skill ADD CONSTRAINT FK_F9952B7D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1FBE6CAE90');
        $this->addSql('ALTER TABLE user_mission DROP FOREIGN KEY FK_C86AEC36BE6CAE90');
        $this->addSql('ALTER TABLE user_soc_mission DROP FOREIGN KEY FK_6153623FBE6CAE90');
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1F8545BDF5');
        $this->addSql('ALTER TABLE user_mission DROP FOREIGN KEY FK_C86AEC36A76ED395');
        $this->addSql('ALTER TABLE user_skill DROP FOREIGN KEY FK_BCFF1F2FA76ED395');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF2D761A2');
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1FF2D761A2');
        $this->addSql('ALTER TABLE user_soc_role DROP FOREIGN KEY FK_9880E18EF2D761A2');
        $this->addSql('ALTER TABLE user_soc_mission DROP FOREIGN KEY FK_6153623FF2D761A2');
        $this->addSql('ALTER TABLE user_soc_skill DROP FOREIGN KEY FK_F9952B7DF2D761A2');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C12469DE2');
        $this->addSql('ALTER TABLE user_soc_role DROP FOREIGN KEY FK_9880E18ED60322AC');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C7FF61858');
        $this->addSql('ALTER TABLE user_skill DROP FOREIGN KEY FK_BCFF1F2F5585C142');
        $this->addSql('ALTER TABLE user_soc_skill DROP FOREIGN KEY FK_F9952B7D5585C142');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE apply');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_mission');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('DROP TABLE user_soc');
        $this->addSql('DROP TABLE user_soc_role');
        $this->addSql('DROP TABLE user_soc_mission');
        $this->addSql('DROP TABLE user_soc_skill');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE skill');
    }
}
