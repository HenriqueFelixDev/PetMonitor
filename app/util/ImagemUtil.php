<?php

namespace App\Util;

class ImagemUtil
{
    public static function moverImagem($imagem, $novoDir, $novoNome)
    {
        $caminhoImagem = $imagem["tmp_name"];
        $extensao = self::obterExtensao($imagem["name"]);
        $novoCaminho = $novoDir.$novoNome.".".$extensao;

        if (@move_uploaded_file($imagem["tmp_name"], $novoCaminho)) {
            return true;
        }

        return $novoNome.".".$extensao;
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