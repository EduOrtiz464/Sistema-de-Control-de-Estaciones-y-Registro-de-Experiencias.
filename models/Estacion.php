<?php
class Estacion
{
    private $nombre;
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function mostrarExperiencia()
    {
        return "Experiencia turística";
    }
}
class Danza extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Participación en danza Yanesha";
    }
}
class Orquidiario extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Recorrido por el orquidiario";
    }
}
class JuegoAncestral extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Participación en juegos ancestrales";
    }
}

?>