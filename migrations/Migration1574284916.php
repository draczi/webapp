<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574284916 extends Migration {
    public function up() {
      $this->query("SELECT * FROM products");
    }
  }
