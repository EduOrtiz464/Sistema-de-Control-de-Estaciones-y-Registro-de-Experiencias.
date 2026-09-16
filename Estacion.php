<?php
// CLASE PADRE
class Estacion
{
    // ENCAPSULAMIENTO
    private $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    // POLIMORFISMO
    public function mostrarExperiencia()
    {
        return "Experiencia turística";
    }
}
// HERENCIA
class Danza extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Participación en danza Yanesha";
    }
}
// HERENCIA
class Orquidiario extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Recorrido por el orquidiario";
    }
}
// HERENCIA
class JuegoAncestral extends Estacion
{
    public function mostrarExperiencia()
    {
        return "Participación en juegos ancestrales";
    }
}

?>