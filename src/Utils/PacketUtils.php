<?php

namespace App\Utils;

class PacketUtils {
    public const LOGIN_PACKET = 0x01;
    public const LOCATION_PACKET = 0x12;
    public const HEARTBEAT_PACKET = 0x13;
    public const ALARM_PACKET = 0x16;
    public const ONLINE_COMMAND_PACKET = 0x80;
    public const INFORMATION_TRANSMISSION_PACKET = 0x94;

    public static function getPacketTypes(): array {
        return [
            'LOGIN_PACKET' => self::LOGIN_PACKET,
            'LOCATION_PACKET' => self::LOCATION_PACKET,
            'HEARTBEAT_PACKET' => self::HEARTBEAT_PACKET,
            'ALARM_PACKET' => self::ALARM_PACKET,
            'ONLINE_COMMAND_PACKET' => self::ONLINE_COMMAND_PACKET,
            'INFORMATION_TRANSMISSION_PACKET' => self::INFORMATION_TRANSMISSION_PACKET,
        ];
    }
}
