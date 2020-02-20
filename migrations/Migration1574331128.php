<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574331128 extends Migration {
    public function up() {
      $kell = "nemkell";
      $this->createTable($kell, 'kell_id', 'AUTO_INCREMENT');
      $this->addColumn($kell,'name', 'varchar', ['size' => 255]);
      $nem = "nem";
      $this->createTable($nem, 'nem_id');
    }
  }
