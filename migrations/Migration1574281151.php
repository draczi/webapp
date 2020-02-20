<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574281151 extends Migration {
    public function up() {
      $table = 'mig';
      $this->createTable($table, 'migration_id');
      $this->addColumn($table,'name', 'varchar', ['size' => 255]);
    }
  }
