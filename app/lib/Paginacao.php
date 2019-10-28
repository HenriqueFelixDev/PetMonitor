<?php

namespace App\Lib;

class Paginacao
{
    public static function paginar($totalItens, $itensPorPagina, $indice, $urlBase)
    {

        if ($totalItens > 0) {
            $paginas = ceil($totalItens / $itensPorPagina);
  
            $indiceAnterior = ($indice - 1 >= 0) ? $indice - 1 : 0;
            $proximoIndice = ($indice + 1 < $paginas) ? $indice + 1 : $paginas - 1;

            $html = "<a class=\"btn-paginacao btn btn-primary\" href=\"${urlBase}&indice=${indiceAnterior}\"><i class=\"fas fa-chevron-left\"></i></a>";
            for ($i = 0; $i < $paginas; $i++) {
                $classe = "";
                if ( $i == $indice) {
                    $classe = "disabled";
                    $url="javascript:void(0)";
                } else {
                    $url = $urlBase."&indice=".($i+1);
                }
                $html .= "<a class=\"btn btn-paginacao ${classe}\" href=\"${url}\" >".($i+1)."</a>";
            }
            $html .= "<a class=\"btn-paginacao btn btn-primary\" href=\"${urlBase}&indice=${proximoIndice}\"><i class=\"fas fa-chevron-right\"></i></a>";
            return $html;
        }
        return null;
    }
}