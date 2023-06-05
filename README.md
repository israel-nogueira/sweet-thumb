<p align="center">
    <img src="https://raw.githubusercontent.com/israel-nogueira/sweet-thumb/main/src/topo_README.png"/>
</p>
<p align="center">
    <a href="#instalação" target="_Self">Instalação</a> |
    <a href="#configurando-a-base" target="_Self">Config a base</a> |
    <a href="#snippets-para-vscode" target="_Self">Snippets</a> |
    <a href="#criando-models" target="_Self">Models</a> |
    <a href="#exemplos-de-uso" target="_Self">Exemplos de uso</a><br>
    <a href="#funções-na-model" target="_Self">Functions</a> |
    <a href="#criptografia" target="_Self">Crypt</a> |
    <a href="#stored-procedures" target="_Self">Store Procedures</a> |
    <a href="#versionamento" target="_Self">Versionamento</a> 
</p>
<p align="center">
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb">
        <img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/v/stable.svg">
    </a>
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb"><img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/downloads"></a>
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb"><img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/license.svg"></a>
</p>

Classe para controlar a sua base de dados no PHP com facilidade e segurança.<br/>


## Instalação

Instale via composer.

```plaintext
    composer require israel-nogueira/sweet-thumb
```

## EXEMPLOS DE USO<br/>

Crop simples de uma imagem
```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;

    /* 
    |--------------------------------
    |  Parâmetros:
    |   @SOURCE => Caminho da imagem
    |   @SIZE = Array com Largura e Altura  (ex: [w,h] )
    |   @SUFIX => Será adicionado as medidas da imagem ao final do nome (ex: avatar-{w}-{h}-{q}.png)
    |   @CROP = Bolean, habilita o crope da imagem
    |   @RESIZE = Habilita se quer redimencionar a imagem
    |   @QUALIDADE = 1 - 100  
    |   @SHOW_BROSWER = Ao invés de salvar a imagem, retorna a imagem para o browser
    |--------------------------------
    */
    sweet::crop(
        $_IMG=null,
        $sufix=true,
        $size=[50,50],
        $crop=true,
        $resize=true,
        $qualidade=null,
        $showBrowser=false
    );


    /* 
    |--------------------------------
    |  EXEMPLO PRÁTICO
    |--------------------------------
    */
    $_IMAGEM = __DIR__.'/avatar.jpg';
    sweet::crop($_IMAGEM,[100,100],true,true,true,100);


?>
```

