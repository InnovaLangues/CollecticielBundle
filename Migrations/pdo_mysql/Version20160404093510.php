<?php

namespace Innova\CollecticielBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2016/04/04 09:35:12
 */
class Version20160404093510 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE innova_collecticielbundle_grading_criteria (
                id INT AUTO_INCREMENT NOT NULL, 
                drop_zone_id INT NOT NULL, 
                criteria_name LONGTEXT NOT NULL, 
                INDEX IDX_CFFAAB5DA8C6E7BD (drop_zone_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE innova_collecticielbundle_grading_scale (
                id INT AUTO_INCREMENT NOT NULL, 
                dropzone_id INT NOT NULL, 
                scale_name LONGTEXT NOT NULL, 
                INDEX IDX_99352CDE54FC3EC3 (dropzone_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            ADD CONSTRAINT FK_CFFAAB5DA8C6E7BD FOREIGN KEY (drop_zone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_scale 
            ADD CONSTRAINT FK_99352CDE54FC3EC3 FOREIGN KEY (dropzone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE innova_collecticielbundle_grading_criteria
        ");
        $this->addSql("
            DROP TABLE innova_collecticielbundle_grading_scale
        ");
    }
}