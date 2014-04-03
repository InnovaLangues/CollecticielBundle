<?php

namespace Icap\DropzoneBundle\Migrations\drizzle_pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/04/03 11:43:47
 */
class Version20140403114342 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_dropzone 
            ADD auto_close_opened_drops_when_time_is_up BOOLEAN DEFAULT 'false' NOT NULL, 
            ADD auto_close_state VARCHAR(255) DEFAULT 'waiting' NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE icap__dropzonebundle_dropzone 
            DROP auto_close_opened_drops_when_time_is_up, 
            DROP auto_close_state
        ");
    }
}