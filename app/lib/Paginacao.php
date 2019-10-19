<?php

namespace App\Lib;

class Paginacao
{
    public static function paginar($totalItens, $itensPorPagina, $indice, $urlBase)
    {
        $indice += 1;
        $paginas = ceil($totalItens / $itensPorPagina);

        if ($indice - 1 > 0) {
            $indiceAnterior = $indice - 1;
        } else {
            $indiceAnterior = 1;
        }

        if ($indice + 1 <= $paginas) {
            $proximoIndice = $indice + 1;
        } else {
            $proximoIndice = $paginas;
        }


        $html = "<a class=\"btn-paginacao btn btn-primary\" href=\"${urlBase}&indice=${indiceAnterior}\"><i class=\"fas fa-chevron-left\"></i></a>";
        for ($i = 1; $i <= $paginas; $i++) {
            $classe = '';
            if ( $i == $indice) {
                $classe = "disabled";
                $url="javascript:void(0)";
            } else {
                $url = $urlBase."&indice=${i}";
            }
            $html .= "<a class=\"btn btn-paginacao ${classe}\" href=\"${url}\" >${i}</a>";
        }
        $html .= "<a class=\"btn-paginacao btn btn-primary\" href=\"${urlBase}&indice=${proximoIndice}\"><i class=\"fas fa-chevron-right\"></i></a>";
        return $html;
    }
}