<?php

namespace App\Util;

class ImagemUtil
{
    public static function moverImagem($imagem, $novoDiretorio, $novoNome)
    {
        $caminhoImagem = $imagem["tmp_name"];
        $extensao = self::obterExtensao($imagem["name"]);
        $novoCaminho = $novoDiretorio.$novoNome.".".$extensao;

        if (@move_uploaded_file($imagem["tmp_name"], $novoCaminho)) {
            return $novoNome.".".$extensao;
        }

        return false;
    }

    public static function validarFormato($nomeImagem, array $formatos)
    {
        $extensao = self::obterExtensao($nomeImagem);
        return !is_bool(array_search($extensao, $formatos));
    }

    public static function validarTamanho($imagem, $tamanhoMax)
    {
        $tamanho = $imagem["size"];
        return $tamanho <= $tamanhoMax;
    }

    public static function obterExtensao($nomeImagem)
    {
        return pathinfo($nomeImagem, PATHINFO_EXTENSION);
    }
}