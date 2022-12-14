<?php
class ConfigDB
{
    public function __construct()
    {
        $this->conexion = new mysqli("2daw.esvirgua.com", "user2daw_06", "6F.Z@GPTwB!s", "user2daw_BD2-06");
        $this->conexion->set_charset('utf8');
    }
}
