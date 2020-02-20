<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574282456 extends Migration {
    public function up() {
      $kell = "kell";
      $this->createTable($kell, 'kell_id');
      $this->addColumn($kell,'name', 'varchar', ['size' => 255]);

    }
  }
