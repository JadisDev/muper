<?php

namespace App\Protocol;

use App\DTO\LocationDataDTO;
use App\Interfaces\Protocol\ProtocolInterface;
use App\Utils\PacketUtils;

class ProtocolPositionData implements ProtocolInterface {

    private array $packages;

    const GPS = PacketUtils::LOCATION_PACKET;

    public function __construct(array $packages = []) {
        $this->packages = $packages;
    }

    public function makeJson(): array
    {
        $data = [];
        $imei = null;
        $batteryVoltage = "";

        foreach ($this->packages as $package) {
            $bytes = explode(" ", $package);

            // Verifica se o pacote é de login (0x01) e extrai o IMEI
            if (hexdec($bytes[3]) == 0x01) {
                $imei = $this->extractImei($bytes);
                continue;  // Vai para o próximo pacote
            }

            // Verifica se o pacote é de transmissão de informações (0x94) e extrai a tensão da bateria
            if (hexdec($bytes[3]) == 0x94) {
                $batteryVoltage = $this->extractBatteryVoltage($bytes);
            }

            // Verifica se o pacote é de localização (0x12) e processa os dados
            if (hexdec($bytes[3]) == 0x12) {
                $data[] = $this->processLocationPacket($bytes, $imei, $batteryVoltage);
            }
        }

        return $data;
    }

    // Função para extrair o IMEI do pacote de login (0x01)
    private function extractImei(array $bytes): ?string
    {
        return implode("", array_slice($bytes, 4, 8));  // Terminal ID (IMEI)
    }

    // Função para extrair o nível de bateria do pacote de transmissão de informações (0x94)
    private function extractBatteryVoltage(array $bytes): ?float
    {
        $infoType = $bytes[4];
        if ($infoType === "00") {  // Information Type "00" para tensão da bateria
            $batteryHex = implode("", array_slice($bytes, 5, 2));
            return hexdec($batteryHex) / 100;  // Tensão em volts (dividido por 100)
        }
        return null;
    }

    // Função para formatar a data e hora (bytes 4-9)
    private function formatTimestamp(array $bytes): string
    {
        $year = 2000 + hexdec($bytes[4]);
        $month = str_pad(hexdec($bytes[5]), 2, "0", STR_PAD_LEFT);
        $day = str_pad(hexdec($bytes[6]), 2, "0", STR_PAD_LEFT);
        $hour = str_pad(hexdec($bytes[7]), 2, "0", STR_PAD_LEFT);
        $minute = str_pad(hexdec($bytes[8]), 2, "0", STR_PAD_LEFT);
        $second = str_pad(hexdec($bytes[9]), 2, "0", STR_PAD_LEFT);
        return "$year-$month-$day $hour:$minute:$second";
    }

    // Função para determinar o estado do GPS (fixado ou não)
    private function getGpsStatus(array $bytes): string
    {
        $byte1 = hexdec($bytes[20]);
        $byte1Bin = str_pad(decbin($byte1), 8, "0", STR_PAD_LEFT);
        return ($byte1Bin[3] == "1") ? "F" : "A";
    }

    // Função para determinar os hemisférios de latitude e longitude
    private function getHemisphere(array $bytes): array
    {
        $byte1 = hexdec($bytes[20]);
        $byte1Bin = str_pad(decbin($byte1), 8, "0", STR_PAD_LEFT);
        $latitudeHemisferio = ($byte1Bin[5] == "1") ? "N" : "S";
        $longitudeHemisferio = ($byte1Bin[4] == "1") ? "W" : "E";
        return [$latitudeHemisferio, $longitudeHemisferio];
    }

    // Função para determinar o estado da ignição (alarm e acc)
    private function getIgnitionStatus(array $bytes): array
    {
        $ignitionStatus = hexdec($bytes[20]);
        if ($ignitionStatus & 0x01) {
            // Ignition On
            return ["accon", "on"];
        } else {
            // Ignition Off
            return ["accoff", "off"];
        }
    }

    // Função para processar o pacote de localização (0x12)
    private function processLocationPacket(array $bytes, ?string $imei, ?string $batteryVoltage): LocationDataDTO
    {
        // Extraindo e formatando a data e hora
        $timestamp = $this->formatTimestamp($bytes);

        // Latitude e Longitude
        $latitude = round(hexdec(implode("", array_slice($bytes, 11, 4))) / 1800000, 6);
        $longitude = round(hexdec(implode("", array_slice($bytes, 15, 4))) / 1800000, 6);

        // Velocidade
        $speed = hexdec($bytes[19]);

        // Course & Status (indica o estado do GPS)
        $gps = $this->getGpsStatus($bytes);

        // Hemisférios
        list($latitudeHemisferio, $longitudeHemisferio) = $this->getHemisphere($bytes);

        // Direção
        $course = hexdec(implode("", array_slice($bytes, 20, 2))) & 0x03FF;

        // Alarm e ACC (estado da ignição)
        list($alarm, $acc) = $this->getIgnitionStatus($bytes);

        // Preenchendo o JSON com os dados extraídos
        // Criando e retornando o DTO
        return new LocationDataDTO(
            $gps,
            $latitude,
            $longitude,
            $latitudeHemisferio,
            $longitudeHemisferio,
            $speed,
            $imei ?? '',
            $timestamp,
            $alarm,
            $acc,
            $course,
            $batteryVoltage ?? ""
        );
    }
}
