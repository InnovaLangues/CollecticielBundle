<?php

namespace Innova\CollecticielBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2016/04/04 09:37:52
 */
class Version20160404093750 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            DROP FOREIGN KEY FK_CFFAAB5DA8C6E7BD
        ");
        $this->addSql("
            DROP INDEX IDX_CFFAAB5DA8C6E7BD ON innova_collecticielbundle_grading_criteria
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria CHANGE drop_zone_id dropzone_id INT NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            ADD CONSTRAINT FK_CFFAAB5D54FC3EC3 FOREIGN KEY (dropzone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id)
        ");
        $this->addSql("
            CREATE INDEX IDX_CFFAAB5D54FC3EC3 ON innova_collecticielbundle_grading_criteria (dropzone_id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            DROP FOREIGN KEY FK_CFFAAB5D54FC3EC3
        ");
        $this->addSql("
            DROP INDEX IDX_CFFAAB5D54FC3EC3 ON innova_collecticielbundle_grading_criteria
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria CHANGE dropzone_id drop_zone_id INT NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            ADD CONSTRAINT FK_CFFAAB5DA8C6E7BD FOREIGN KEY (drop_zone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            CREATE INDEX IDX_CFFAAB5DA8C6E7BD ON innova_collecticielbundle_grading_criteria (drop_zone_id)
        ");
    }
}