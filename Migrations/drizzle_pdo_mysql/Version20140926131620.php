<?php

namespace Innova\CollecticielBundle\Migrations\drizzle_pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/09/26 01:16:25
 */
class Version20140926131620 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            ADD event_agenda_drop INT DEFAULT NULL, 
            ADD event_agenda_correction INT DEFAULT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            ADD CONSTRAINT FK_6782FC23E6B974D2 FOREIGN KEY (event_agenda_drop) 
            REFERENCES claro_event (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            ADD CONSTRAINT FK_6782FC238D9E1321 FOREIGN KEY (event_agenda_correction) 
            REFERENCES claro_event (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_6782FC23E6B974D2 ON innova_collecticielbundle_dropzone (event_agenda_drop)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_6782FC238D9E1321 ON innova_collecticielbundle_dropzone (event_agenda_correction)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            DROP FOREIGN KEY FK_6782FC23E6B974D2
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            DROP FOREIGN KEY FK_6782FC238D9E1321
        ");
        $this->addSql("
            DROP INDEX UNIQ_6782FC23E6B974D2 ON innova_collecticielbundle_dropzone
        ");
        $this->addSql("
            DROP INDEX UNIQ_6782FC238D9E1321 ON innova_collecticielbundle_dropzone
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            DROP event_agenda_drop, 
            DROP event_agenda_correction
        ");
    }
}