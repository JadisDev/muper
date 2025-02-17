<?php

namespace App\DTO;

class LocationDataDTO
{
    public string $gps;
    public float $latitude;
    public float $longitude;
    public string $latitudeHemisferio;
    public string $longitudeHemisferio;
    public int $speed;
    public string $imei;
    public string $data;
    public string $alarm;
    public string $acc;
    public int $direcao;
    public ?string $nivelBateria;

    // Construtor para inicializar os dados
    public function __construct(
        string $gps,
        float $latitude,
        float $longitude,
        string $latitudeHemisferio,
        string $longitudeHemisferio,
        int $speed,
        string $imei,
        string $data,
        string $alarm,
        string $acc,
        int $direcao,
        ?string $nivelBateria
    ) {
        $this->gps = $gps;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->latitudeHemisferio = $latitudeHemisferio;
        $this->longitudeHemisferio = $longitudeHemisferio;
        $this->speed = $speed;
        $this->imei = $imei;
        $this->data = $data;
        $this->alarm = $alarm;
        $this->acc = $acc;
        $this->direcao = $direcao;
        $this->nivelBateria = $nivelBateria;
    }
}
