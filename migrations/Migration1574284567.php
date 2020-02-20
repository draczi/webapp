<?php
  namespace Migrations;
  use Core\Migration;

  class Migration1574284567 extends Migration {
    public function up() {
      $this->createDatabase('minta');
    }
  }
