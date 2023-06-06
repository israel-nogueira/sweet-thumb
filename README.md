<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/22af3dce8a1a4d9807f80adecb40d394da73b203/src/topo_README.png"/>
</p>
<p align="center">
    <a href="#instalação" target="_Self">Instalação</a> |
    <a href="#exemplos-de-uso" target="_Self">Exemplos de Uso</a> |
    <a href="#conversão-de-arquivos" target="_Self">Conversão</a> |
    <a href="#print-imagem-no-browser" target="_Self">Print no browser</a> |
    <a href="#thumb-redondo" target="_Self">Thumb Redondo</a><br>
    <a href="#paleta-de-cores" target="_Self">Paleta de Cores</a> |
    <a href="#cor-predominante-de-uma-imagem" target="_Self">Cor predominante</a> |
    <a href="#placeholder" target="_Self">Placeholder</a> |
    <a href="#placeholder-blur-de-uma-imagem" target="_Self">Placeholder com Blur</a>  |
    <a href="#add-texto-por-cima-de-uma-imagem" target="_Self">Add Textos</a> |
    <a href="#mesclando-imagens" target="_Self">Mesclando imagens</a> |
    <a href="#processa-uma-imagem" target="_Self"> uma imagens</a> |
</p>
<p align="center">
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb">
        <img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/v/stable.svg">
    </a>
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb"><img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/downloads"></a>
    <a href="https://packagist.org/packages/israel-nogueira/sweet-thumb"><img src="https://poser.pugx.org/israel-nogueira/sweet-thumb/license.svg"></a>
</p>

Esta é uma super classe super simples para criação de miniaturas. Sem fru-fru, apenas o que realmente é útil em um sistema/website.<br/>


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
	use IsraelNogueira\SweetThumb\sweet;

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
	use IsraelNogueira\SweetThumb\sweet;


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
	sweet::img2gif(__DIR__.'/avatar.png',100);
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
	use IsraelNogueira\SweetThumb\sweet;

    sweet::printBrowser(__DIR__.'/original.webp');

?>
```

## THUMB REDONDO<br/>

Cropa e retorna uma thumb redonda
```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;

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
	use IsraelNogueira\SweetThumb\sweet;
    
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
	use IsraelNogueira\SweetThumb\sweet;
    
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
	use IsraelNogueira\SweetThumb\sweet;
    
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
    
    /* 
    |-------------------------------------------------------
    |  OU SE QUISER INSERIR EM UMA TAG DE IMAGEM
    |--------------------------------------------------------
    */
    $placeholder = sweet::placeholderBase64([
            'SIZE'  =>'250x100',
            'TEXT'  =>'Olá mundo!',
            'BG'    =>'000000',
            'COLOR' =>'FFFFFF',
            'ID'    =>'demonstracao',
            'CLASS' =>'avatar',
            'FONTSIZE'=>30,
            'FONTFAMILY'=>__DIR__.'/fonte.ttf'
        ]);
    
    echo ' <img src="'.$placeholder.'">';

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

    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGlkPSJkZW1vbnN0cmFjYW8iIGNsYXNzPSJhdmF0YXIiIHdpZHRoPSIyNTAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMjUwIDEwMCI+DQoJCQkJCQkJPHJlY3QgZmlsbD0iIzAwMDAwMCIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPg0KCQkJCQkJCTx0ZXh0IA0KCQkJCQkJCQlmaWxsPSIjRkZGRkZGIiANCgkJCQkJCQkJZm9udC1mYW1pbHk9InNhbnMtc2VyaWYiIA0KCQkJCQkJCQlmb250LXNpemU9IjMwIiANCgkJCQkJCQkJZHk9IjAiIA0KCQkJCQkJCQlmb250LXdlaWdodD0iYm9sZCIgDQoJCQkJCQkJCXg9IjUwJSIgDQoJCQkJCQkJCXk9IjUwJSIgDQoJCQkJCQkJCXRleHQtYW5jaG9yPSJtaWRkbGUiDQoJCQkJCQkJCWRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiDQoJCQkJCQkJPg0KCQkJCQkJCQlPbMOhIG11bmRvIQ0KCQkJCQkJCTwvdGV4dD4gDQoJCQkJCQk8L3N2Zz4=">
```

Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/4c18ac22d4e8f53d21e06f065b41ba0135998c00/src/06.jpg"/><br>
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/4c18ac22d4e8f53d21e06f065b41ba0135998c00/src/06.jpg"/>
</p>

## PLACEHOLDER BLUR DE UMA IMAGEM<br/>

Aqui criamos uma imagem em BLUR para placeholder em SVG;<br>
Será criado um arquivo SVG com o sufixo ```-lazy.svg ```
Tambem um placeholder mais simples, com apenas a cor predominante com o sufixo ```-lazy.low.svg``` 
```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;
    
    /* 
    |-------------------------------------------------------
    |  CRIA BLUR IMAGE
    |--------------------------------------------------------
    */
   echo sweet::createLazyLoad(__DIR__.'/avatar.png')


?>
```
Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/64a67b00198722fc30c3acd013bc3baffeba5e62/src/07.png"/>
</p>

## ADD TEXTO POR CIMA DE UMA IMAGEM<br/>

Veja como é simples adicionar um texto sob uma imagem;<br>

```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;
    
    /* 
    |-------------------------------------------------------
    |  ADICIONA TEXTO
    |--------------------------------------------------------
    */
    sweet::addTexto([
						'ORIGINAL'	=>	__DIR__.'/bg.png',
						'FINAL'		=>	__DIR__.'/bg_texto.png',
						'FONT_SIZE'	=>	30,
						'TEXT_Y'	=>	'center';
						'TEXT_X'	=>	'center';
						'TEXTO'		=>	'PROMOÇÃO AGORA!';
						'FONTE'		=>	__DIR__.'/FONTE.ttf',
						'COR'		=>	'#FFFFFF'
					]);

?>
```
Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/65d8511a15a8a189ccbdf6a8909bd77e254efdcc/src/08.png"/>
</p>


## MESCLANDO IMAGENS<br/>

Com essa função poderemos mesclar imagens programaticamente;
```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;
    
    /* 
    |-------------------------------------------------------
    |  MESCLA O AVATAR 
    |--------------------------------------------------------
    */
	sweet::mesclarIMG(__DIR__.'/bg.png',__DIR__.'/mulher.png',22,22,__DIR__.'/bg1.png');

    /* 
    |-------------------------------------------------------
    |  MESCLA O ICONE DO SONIC 
    |--------------------------------------------------------
    */
	sweet::mesclarIMG(__DIR__.'/bg1.png',__DIR__.'/sonic.png',230,100,__DIR__.'/banner.png');

?>
```
Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/9eac847243714507fe2be59176ef53a621d2e5a5/src/09.png"/>
</p>


## PROCESSA UMA IMAGEM<br/>

Podemos utilizar essa função para gerar vários formatos de uma só imagem;
```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;

	/*
	|-----------------------------------------------------
	|	FAZ O PROCESSO COMPLETO
	|-----------------------------------------------------
	|
	|	@_ARQUIVO:  string:PathFile | array[PathFile,HashName]
	|	@_SIZES:    [w|h,[w,h],[w,h],[w,h,q]]  
	|	@_ROOT_SIZE: tamanho maximo do original
	|
	|-----------------------------------------------------
	*/

	sweet::processaImagem([__DIR__.'/imagens/avatar.png','nova-imagem'],[50,[100,150,100],[200,250,100],300],1300);

?>
```
Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/290adc84d05d5c0e068730ea6e8dbeff9537cb30/src/11.png"/>
</p>

Caso não queira dar um bnome pra imagem, será gerado uma HASH randômica;
```php

<?php
    include "vendor\autoload.php";
	use IsraelNogueira\SweetThumb\sweet;

	/*
	|-----------------------------------------------------
	|	FAZ O PROCESSO COMPLETO
	|-----------------------------------------------------
	|
	|	@_ARQUIVO:  string:PathFile | array[PathFile,HashName]
	|	@_SIZES:    [w|h,[w,h],[w,h],[w,h,q]]  
	|	@_ROOT_SIZE: tamanho maximo do original
	|
	|-----------------------------------------------------
	*/

	sweet::processaImagem(__DIR__.'/avatar.png',[50,[200,100,100],[200,100,100],300],1300);

?>
```
Que visualmente é ficaria assim:
<p align="center">
    <img src="https://github.com/israel-nogueira/sweet-thumb/blob/d45bf1c328d2107368c9e2838858c7845a1fe5f8/src/10.png"/>
</p>
