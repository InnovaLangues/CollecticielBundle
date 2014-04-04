<?php

namespace Icap\DropzoneBundle\Migrations\pdo_ibm;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/04/04 11:24:27
 */
class Version20140404112422 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_drop ALTER auto_closed_drop auto_closed_drop SMALLINT NOT NULL
        ");
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_dropzone 
            ADD COLUMN auto_close_opened_drops_when_time_is_up SMALLINT NOT NULL 
            ADD COLUMN auto_close_state VARCHAR(255) NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_drop ALTER auto_closed_drop auto_closed_drop SMALLINT NOT NULL
        ");
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_dropzone 
            DROP COLUMN auto_close_opened_drops_when_time_is_up 
            DROP COLUMN auto_close_state
        ");
    }
}