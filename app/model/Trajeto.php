<?php

namespace App\Model;

class Trajeto extends Model
{
    protected $cod_pet;
    protected $data_hora;
    protected $latitude;
    protected $longitude;

    public function validar() : bool
    {
        return true;
    }

    public function gerarCoordenadasGeografica($numCoordenadas)
    {
        $latitude = $this->gerarCoordenada(0, 28, 0, 9999999, 7) * (-1);

        if ($latitude < 1 && $latitude > -10 ) {
            $minIntLatitude = 38;
            $maxIntLatitude = 71;
        } elseif ($latitude < -10 && $latitude > -16 ) {
            $minIntLatitude = 39;
            $maxIntLatitude = 60;
        } elseif ($latitude < -16 && $latitude > -24 ) {
            $minIntLatitude = 41;
            $maxIntLatitude = 55;
        } elseif ($latitude < -24 && $latitude > -29 ) {
            $minIntLatitude = 49;
            $maxIntLatitude = 53;
        }

        $longitude = $this->gerarCoordenada($minIntLatitude, $maxIntLatitude, 0, 9999999, 7) * (-1);

        $coordenadas[] = ["latitude"=>$latitude, "longitude"=>$longitude];

        for($i = 1; $i < $numCoordenadas; $i++) {
            $offsetLatitude = $this->gerarCoordenada(0, 0, 0, 9999, 7);
            $offsetLongitude = $this->gerarCoordenada(0, 0, 0, 9999, 7);

            $novaLatitude = $latitude+$offsetLatitude;
            $novaLongitude = $longitude+$offsetLongitude;

            $coordenadas[] = ["latitude"=>$novaLatitude, "longitude"=>$novaLongitude];

            $latitude = $novaLatitude;
            $longitude = $novaLongitude;
        }

        return $coordenadas;
    }

    private function gerarCoordenada($inteiroMinimo, $inteiroMaximo, $decimalMinimo, $decimalMaximo, $numCasasDecimais)
    {
        $parteInteira = mt_rand($inteiroMinimo, $inteiroMaximo);
        $parteDecimal = mt_rand($decimalMinimo, $decimalMaximo);

        $casasFaltando = $numCasasDecimais - strlen($parteDecimal);

        $decimal = ".";
        for ($i = 0; $i < $casasFaltando; $i++) {
            $decimal .= "0";
        }

        return floatval($parteInteira.$decimal.$parteDecimal);

    }

    
        public function getCodigoPet()
    {
        return $this->cod_pet;
    }

    public function setCodigoPet($cod_pet)
    {
        $this->cod_pet = $cod_pet;
    }

    public function getDataHora()
    {
        return $this->data_hora;
    }

    public function setDataHora($data_hora)
    {
        $this->data_hora = $data_hora;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}