<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574283308 extends Migration {
    public function up() {
      $table = 'kell';
      $this->addColumn($table, 'visit', 'varchar', ['size'=>255, 'NOT NULL', 'default'=>0]);
    }
  }
