<?php

namespace App;

use Exception;

class ReadLog {
    
    private string $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function getLog(): array {
        if (!file_exists($this->path)) {
            throw new Exception("Arquivo não encontrado: " . $this->path);
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return $lines;
    }
}