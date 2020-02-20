<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574280795 extends Migration {
    public function up() {
      $table = "probalom";
      $this->createTable($table, 'hello_id');
      $this->addTimeStamps($table);
      $this->addColumn($table, 'prb_id', 'int');
      $this->addColumn($table, 'name', 'varchar', ['size' => 255]);
      $this->addColumn($table, 'price', 'decimal', ['precision' => 10, 'scale' => 2]);
      $this->addColumn($table, 'semmi', 'int');
      $this->addSoftDelete($table);
      $this->addIndex($table, 'price');

    }
  }
