<?php

namespace App;

class JsonFileWriter
{
    private function generateFileName(): string
    {
        $timestamp = date('Y-m-d_H-i-s');
        return 'files/' . $timestamp . '.json';
    }

    public function writeJsonToFile(string $jsonData): bool
    {
        json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Erro ao decodificar o JSON: " . json_last_error_msg();
            return false;
        }

        $fileName = $this->generateFileName();
        
        $fileWritten = file_put_contents($fileName, $jsonData);

        if ($fileWritten === false) {
            echo "Erro ao escrever no arquivo.";
            return false;
        }

        echo "Arquivo gerado com sucesso: " . $fileName;
        return true;
    }
}