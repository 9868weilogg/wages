<?php

namespace App\Interfaces;

interface CsvInterface {
  public function retrieveCsvLines($fileOrRequest);
}