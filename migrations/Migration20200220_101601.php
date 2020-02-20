<?php
  namespace Migrations;
  use Core\Migration;

  class Migration20200220_101601 extends Migration {
    public function up() {
        $table = "products";
        $this->addColumn($table, 'sold', 'tinyint');
    }
  }
