<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/ab57c606dcdb2021e7b522aca69d68ca97150168/src/topo_README.png"/>
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

```sweet::crop('avatar.png',[100,100,100],true,true);```<br> 
Cropa a imagem no formato que você definir:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/97c5a70ea82f0d22d27198dfaa4ce0b70c548c6d/src/01.png"/>
</p>

```sweet::crop('avatar.png',[0,100,100],false,true);```<br> 
Redimencionará a altura para 100px e a largura proporcional:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/97c5a70ea82f0d22d27198dfaa4ce0b70c548c6d/src/02.png"/>
</p>

```sweet::crop('avatar.png',[100,0,100],false,true);```<br>
Redimencionará a largura para 100px e a altura proporcional:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/97c5a70ea82f0d22d27198dfaa4ce0b70c548c6d/src/03.png"/>
</p>

```sweet::crop('avatar.png',[100,100,100],true,false);```<br>
Cropa a imagem no formato que você definir porém sem redimencionar a imagm:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/8af8abdf61d90d31ed4f82bcf2f96c9143cee472/src/04.png"/>
</p>

## CONVERSÃO DE ARQUIVOS<br/>

Conversão de tipos de imagem.<br>
Comporta as exetensões: ```.jpg```, ```.gif```, ```.webp```, ```.png```.

```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;


    /* 
    |--------------------------------
    |  CONVERTE PARA JPG
    |--------------------------------
    */
	sweet::img2jpg(__DIR__.'/avatar.png',100);
    /* 
    |--------------------------------
    |  CONVERTE PARA GIF
    |--------------------------------
    */
	sweet::img2gif(__DIR__.'/avatar.png',9);
    /* 
    |--------------------------------
    |  CONVERTE PARA WEBP
    |--------------------------------
    */
	sweet::img2webp(__DIR__.'/avatar.png',100);
    /* 
    |--------------------------------
    |  CONVERTE PARA PNG
    |--------------------------------
    */
	sweet::img2png(__DIR__.'/avatar.jpg',9);

?>
```

## PRINT IMAGEM NO BROWSER<br/>

Simplesmente retorna uma imagem e printa no browser:
```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;

    sweet::printBrowser(__DIR__.'/original.webp');

?>
```

## THUMB REDONDO<br/>

Cropa e retorna uma thumb redonda
```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;

    /* 
    |-------------------------------------------------------
    |  CONVERTE PARA GIF
    |  @PARAM 1: Path da imagem
    |  @PARAM 2: Tamanho da thumb
    |  @PARAM 3: true:Salva um arquivo local, false: retorna o objeto
    |--------------------------------------------------------
    */
	sweet::thumbRedondo(__DIR__.'/avatar.jpg', 180,true);

?>
```
Este exemplo resultará em:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/f26033179b54e7cedf63495a4667b0c24bef2388/src/05.png"/>
</p>


## LISTANDO PALETA DE CORES<br/>
Nos retorna as cores disponiveis em uma imagem;
>ATENÇÃO!
>Essa função percorre cada pixel de uma imagem.
>Se a imagem for muito grande, pode travar o processamento
>Portanto, é viável para casos expecíficos ou imagens pequenas


```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;
    
    /* 
    |-------------------------------------------------------
    |  CAPTURA PALETA DE CORES
    |--------------------------------------------------------
    */
    $paleta = sweet::getColor(__DIR__.'/avatar.jpg');

    /* 
    |-------------------------------------------------------
    |  ORDENA A PALETA DE CORES
    |--------------------------------------------------------
    */
    $Ordem  = sweet::sortByColor($paleta);



?>
```
Este exemplo resultará em algo parecido com isso:
```plaintext
    Array
    (
        [0] => Array
            (
                [0] => 000000
                ...
                [30] => 0c0404
                [31] => 0b0303
                [32] => 050000
                [36] => 090100
                [37] => 0f0500
                ...
                ...
                [6361] => 1f1106
                [6367] => 582f0e
                [6368] => 623512
            )
    )


```

## COR PREDOMINANTE DE UMA IMAGEM<br/>

Nos retorna a cor principal de uma imagem;

```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;
    
    /* 
    |-------------------------------------------------------
    |  COR PRINCIPAL
    |--------------------------------------------------------
    */
    $paleta = sweet::corPredominante(__DIR__.'/avatar.jpg');

?>
```
Este exemplo resultará em algo parecido com isso:
```plaintext
        Array
        (
            [0] => Array
                (
                    [0] => 80
                    [1] => 61
                    [2] => 58
                )

            [1] => rgb(80, 61, 58)
        )

```
## PLACEHOLDER<br/>

Nos retorna a cor principal de uma imagem;

```php

<?php
    include "vendor\autoload.php";
    use  IsraelNogueira\sweetThumb;
    
    /* 
    |-------------------------------------------------------
    |  COR PRINCIPAL
    |--------------------------------------------------------
    */
    echo sweet::placeholderSVG([
            'SIZE'  =>'250x100',
            'TEXT'  =>'Olá mundo!',
            'BG'    =>'000000',
            'COLOR' =>'FFFFFF',
            'ID'    =>'demonstracao',
            'CLASS' =>'avatar',
            'FONTSIZE'=>30,
            'FONTFAMILY'=>__DIR__.'/fonte.ttf'
        ]);

?>
```
Que nos resultará em:
```html
    <svg xmlns="http://www.w3.org/2000/svg" id="demonstracao" class="avatar" width="250" height="100" viewBox="0 0 250 100">
        <rect fill="#000000" width="100%" height="100%"></rect>
        <text fill="#FFFFFF" font-family="sans-serif" font-size="30" dy="0" font-weight="bold" x="50%" y="50%" text-anchor="middle" dominant-baseline="middle">
            Olá mundo!
        </text> 
    </svg>
```

Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/4c18ac22d4e8f53d21e06f065b41ba0135998c00/src/06.jpg"/>
</p>