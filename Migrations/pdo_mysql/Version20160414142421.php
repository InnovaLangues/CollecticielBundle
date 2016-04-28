<?php

namespace Innova\CollecticielBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2016/04/14 02:24:23
 */
class Version20160414142421 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            DROP FOREIGN KEY FK_CFFAAB5D54FC3EC3
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            ADD CONSTRAINT FK_CFFAAB5D54FC3EC3 FOREIGN KEY (dropzone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            DROP FOREIGN KEY FK_CFFAAB5D54FC3EC3
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_grading_criteria 
            ADD CONSTRAINT FK_CFFAAB5D54FC3EC3 FOREIGN KEY (dropzone_id) 
            REFERENCES innova_collecticielbundle_dropzone (id)
        ");
    }
}