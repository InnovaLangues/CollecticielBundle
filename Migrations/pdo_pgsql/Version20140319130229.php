<?php

namespace Innova\CollecticielBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/03/19 01:02:32
 */
class Version20140319130229 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_correction 
            ADD correctionDenied BOOLEAN NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_correction 
            ADD correctionDeniedComment TEXT DEFAULT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            ADD diplay_corrections_to_learners BOOLEAN NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            ADD allow_correction_deny BOOLEAN NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_correction 
            DROP correctionDenied
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_correction 
            DROP correctionDeniedComment
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            DROP diplay_corrections_to_learners
        ");
        $this->addSql("
            ALTER TABLE innova_collecticielbundle_dropzone 
            DROP allow_correction_deny
        ");
    }
}