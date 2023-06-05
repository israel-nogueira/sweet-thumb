<?php
	namespace IsraelNogueira\SweetThumb;
	use IsraelNogueira\SweetThumb\thumb;
	use IsraelNogueira\SweetThumb\thumbbrowser;
	use IsraelNogueira\SweetThumb\image;
	use DateTime;

	class sweet{

		/*
		|-----------------------------------------------------
		| TRANSFORMA ARQUIVO EM LINK BASE64
		|-----------------------------------------------------
		|
		|	return sweetThumb::toBase64('path/path/image.png');
		|
		*/
		static public	function toBase64($image){
			if(!file_exists($image)){throw new Exception("IMAGEM NÃO EXISTE: ".$image, 1);}
			return('data:'.mime_content_type($image).';base64,'.base64_encode(file_get_contents($image)));
		}

		/*
		|-----------------------------------------------------
		| CONVERTE ARQUIVO PNG PARA JPG
		|-----------------------------------------------------
		|
		|	return sweetThumb::png2jpg('path/path/image.png');
		|
		*/
		static public function png2jpg($originalFile,$quality=100) {
			$image 		= imagecreatefrompng($originalFile);
			$_DIR		= dirname($originalFile);
			$_BASENAME	= basename($originalFile);
			$NEW_NAME	= str_replace('.png', '.jpg', $_BASENAME);
			imagejpeg($image, $_DIR.'/'.$NEW_NAME, $quality);
			imagedestroy($image);
		}

		/*
		|-----------------------------------------------------
		| CONVERTE ARQUIVO JPG PARA PNG  
		|-----------------------------------------------------
		|
		|	return sweetThumb::jpg2png('path/path/image.jpg');
		|
		*/
		static public function jpg2png($originalFile,$quality=9) {
			$image 		= imagecreatefromjpeg($originalFile);
			$_DIR		= dirname($originalFile);
			$_BASENAME	= basename($originalFile);
			$NEW_NAME	= str_replace(['.jpg','.jpeg'], '.png', strtolower($_BASENAME));
			imagepng($image, $_DIR.'/'.$NEW_NAME, $quality);
			imagedestroy($image);
		}

		/*
		|-----------------------------------------------------
		| CONVERTE CORES HEXADECIMAIS EM RGB  
		|-----------------------------------------------------
		|
		|	return sweetThumb::hexToRgb('#ff0000');
		|
		*/
		static public	function hexToRgb($color){
			if (substr($color, 0, 1) == '#') {
				$color = substr($color, 1);
			}

			if (strlen($color) == 3) {
				$red = str_repeat(substr($color, 0, 1), 2);
				$green = str_repeat(substr($color, 1, 1), 2);
				$blue = str_repeat(substr($color, 2, 1), 2);
			} else {
				$red = substr($color, 0, 2);
				$green = substr($color, 2, 2);
				$blue = substr($color, 4, 2);
			}
			$hex = array('r' => hexdec($red), 'g' => hexdec($green), 'b' => hexdec($blue));
			return $hex;
		}

		/*
		|-----------------------------------------------------
		| CRIA UM THUMB REDONDO  
		|-----------------------------------------------------
		|
		|	Ideal para sobrepor em outras imagens
		|
		*/

		static public function thumbRedondo( $sourcePath, $thumbSize = 500,$saveLocal=true){

			if ( mime_content_type($sourcePath) == 'image/jpg' || mime_content_type($sourcePath) == 'image/jpeg' ){
				$sourceImage = imagecreatefromjpeg( $sourcePath );
			}else{
				$sourceImage = imagecreatefrompng( $sourcePath );
			}
			
			list( $srcWidth, $srcHeight ) = getimagesize( $sourcePath );
			if ( $srcWidth > $srcHeight ){
				$y            = 0;
				$x            = ( $srcWidth - $srcHeight ) / 2;
				$smallestSide = $srcHeight;
			}else{
				$x            = 0;
				$y            = ( $srcHeight - $srcWidth ) / 2;
				$smallestSide = $srcWidth;
			}

			$destinationImage = imagecreatetruecolor($thumbSize, $thumbSize);
			imagecopyresampled( $destinationImage, $sourceImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide );
			$width		= imagesx             ( $destinationImage );
			$height		= imagesx             ( $destinationImage );
			$mask		= imagecreatetruecolor( $width, $height );
			imageantialias		( $mask,true);
			$black		= imagecolorallocate  ( $mask, 0, 0, 0 );
			imagefill( $mask, 0, 0, $black );
			$transparent = imagecolorallocatealpha( $mask, 0, 0, 0, 127 );
			imagealphablending	( $mask, false );
			imagefilledellipse	( $mask, round( $width / 2 ) , round( $height / 2 ) , $width, $height, $transparent );
			imagealphablending	( $destinationImage, true );
			imagecopyresampled	( $destinationImage, $mask, 0, 0, 0, 0, $width, $height, $width, $height );
			imageantialias		( $destinationImage , true );
			$black = imagecolorallocate($destinationImage, 0, 0, 0 );
			imagecolortransparent( $destinationImage, $black );	
            
			if($saveLocal){
				imagepng($destinationImage,dirname($sourcePath).'/'.basename($sourcePath).'_redondo.png');
				ImageDestroy($destinationImage);
				return true;
			}

			return $destinationImage;
		}
		/*
		|-----------------------------------------------------
		|	MOSTRA NO BROWSER A IMAGEM  
		|-----------------------------------------------------
		*/
        static public function printBrowser($imagem) {
            // Verifica se o parâmetro é um arquivo existente
            if (is_string($imagem) && file_exists($imagem)) {
                // Obtém a extensão do arquivo
                $extensao = pathinfo($imagem, PATHINFO_EXTENSION);

                // Define o tipo MIME apropriado com base na extensão
                $tipoMime = '';

                if ($extensao === 'jpg' || $extensao === 'jpeg') {
                    $tipoMime = 'image/jpeg';
                } elseif ($extensao === 'png') {
                    $tipoMime = 'image/png';
                } elseif ($extensao === 'gif') {
                    $tipoMime = 'image/gif';
                } else {
                    echo 'Extensão de arquivo inválida.';
                    return;
                }
                ob_clean();
                header("Content-Type: $tipoMime");
                readfile($imagem);
            } else {

                ob_clean();
                header('Content-Type: image/png');
                imagepng($imagem);
                imagedestroy($imagem);

            }
        }


		/*
		|-----------------------------------------------------
		| LISTA DE CORES DE CADA PIXEL DE UMA IMAGEM
		|-----------------------------------------------------
		*/
		static public function getColor($image){
			if (isset($image)) {
				$size = getimagesize($image);
				$image_resized = imagecreatetruecolor($size[0], $size[1]);
				if ($size[2] == 1) {
					$image_orig = imagecreatefromgif($image);
				}
				if ($size[2] == 2) {
					$image_orig = imagecreatefromjpeg($image);
				}
				if ($size[2] == 3) {
					$image_orig = imagecreatefrompng($image);
				}
				imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]); //WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS

				$im = $image_resized;
				$imgWidth = imagesx($im);
				$imgHeight = imagesy($im);
				for ($y = 0; $y < $imgHeight; $y++) {
					$Linha = [];
					for ($x = 0; $x < $imgWidth; $x++) {
						$index = imagecolorat($im, $x, $y);
						$Colors = imagecolorsforindex($im, $index);
						if ($Colors['red'] >= 256) {
							$Colors['red'] = 240;
						}

						if ($Colors['green'] >= 256) {
							$Colors['green'] = 240;
						}

						if ($Colors['blue'] >= 256) {
							$Colors['blue'] = 240;
						}

						$RGB_Array[] = [$Colors['red'],$Colors['green'],$Colors['blue']];
						$Linha[] = substr("0" . dechex($Colors['red']), -2) . substr("0" . dechex($Colors['green']), -2) . substr("0" . dechex($Colors['blue']), -2);
					}
					$hexarray[] = $Linha;
				}
				return ($hexarray);
			} else {
				die("You must enter a filename! (\$image parameter)");
			}
		}

		/*
		|-----------------------------------------------------
		|	RETORNA QUALIDADE MÁXIMA DE UMA IMAGEM  
		|-----------------------------------------------------
		*/
		static public function getQuality($image){
			switch (getimagesize($image)['mime']) {
				case 'image/jpg':	return 100;	break;
				case 'image/jpeg':	return 100;	break;
				case 'image/png':	return 9;	break;
				case 'image/gif':	return 100;	break;
				default:			return 100;	break;
			}
		}

		/*
		|-----------------------------------------------------
		|	COMPARA A DATA DE CRIAÇÃO ENTRE 2 ARQUIVOS  
		|-----------------------------------------------------
		|
		|	Isso é util para quando precisamos subscrever uma imagem 
		|	sem correr riscos de atualizar uma imagem já atualziada
		|
		*/

		static public function comparaDatas($_ORIGINAL=null, $_SOLICITADO=null){
			if(!is_null($_ORIGINAL) && !is_null($_SOLICITADO)){
				$_DATA_SOLICITADO	= date('d/m/Y H:i:s', filectime($_SOLICITADO));
				$_DATA_ORIGINAL		= date('d/m/Y H:i:s', filectime($_ORIGINAL));
				$_DATA_SOLICITADO	= DateTime::createFromFormat('d/m/Y H:i:s', $_DATA_SOLICITADO);
				$_DATA_ORIGINAL		= DateTime::createFromFormat('d/m/Y H:i:s', $_DATA_ORIGINAL);
				if (!($_DATA_SOLICITADO instanceof DateTime)) {die('Data de entrada invalida!!');}
				if (!($_DATA_ORIGINAL instanceof DateTime)) {die('Data de saida invalida!!');}
				if ($_DATA_ORIGINAL > $_DATA_SOLICITADO) {
					return true;
				}else{
					return false;
				}
			}
		}





		/*
		|-----------------------------------------------------
		|	  ORDENA PALETA DE CORES
		|-----------------------------------------------------
		*/
		static public function sortByColor($colors) {
			$reds = [];
			$greens = [];
			$blues = [];
			$otherColors = [];
			$sortedArray = [];
			foreach($colors as $color) {
				if($color[0] > $color[1] && $color[0] > $color[2]) {
					$reds[] = $color;
				}
				elseif($color[1] > $color[0] && $color[1] > $color[2]) {
					$greens[] = $color;
				}
				elseif($color[2] > $color[0] && $color[2] > $color[1]) {
					$blues[] = $color;
				}
				else {
					$otherColors[] =$color;
				}
			}
			$sortedArray = array_merge($sortedArray, $reds);
			$sortedArray = array_merge($sortedArray, $greens);
			$sortedArray = array_merge($sortedArray, $blues);
			$sortedArray = array_merge($sortedArray, $otherColors);
			return $sortedArray;
		}

		/*
		|-----------------------------------------------------
		|	  GERA UM PLACEHOLDER DE IMAGEM
		|-----------------------------------------------------
		*/
		static public function placeholderSVG($PARAM=[]){
			if(!is_array($PARAM)){
				throw new Exception('Formato incorreto em svg, utilize ARRAY');
			}
			$PARAM['SIZE']		= $PARAM['SIZE']		??	'100x100';
			$PARAM['TEXT']		= $PARAM['TEXT']		??	$PARAM['SIZE'];
			$PARAM['BG']		= $PARAM['BG']			??	'444444';
			$PARAM['COLOR']		= $PARAM['COLOR']		??	'CCCCCC';
			$PARAM['CLASS']		= $PARAM['CLASS']		??	'';
			$PARAM['ID']		= $PARAM['ID']			??	'';
			$PARAM['FONTSIZE']	= $PARAM['FONTSIZE']	??	25;
			$PARAM['FONTFAMILY']= $PARAM['FONTFAMILY']	?? 'Poppins,Roboto,sans-serif';

			$_SIZE					= explode('x',$PARAM['SIZE']);
			$_TEXT					= $PARAM['TEXT'];
			$fill					= $PARAM['BG'];
			$color					= $PARAM['COLOR'];
			$fontsize				= (int) $PARAM['FONTSIZE'];
			$DY				        = (($_SIZE[1]/2) - ($fontsize-6));

			return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$_SIZE[0].'" height="'.$_SIZE[1] .'" viewBox="0 0 '.$_SIZE[0].' '.$_SIZE[1] .'">
						<rect fill="#'.$fill.'" width="100%" height="100%"/>
						<text 
							fill="#'.$color.'" 
							font-family="sans-serif" 
							font-size="'.$fontsize.'" 
							dy="'.$DY.'" 
							font-weight="bold" 
							x="50%" 
							y="50%" 
							text-anchor="middle"
                            dominant-baseline="middle"
						>
							'.$_TEXT.'
						</text> 
					</svg>';
		} 


		/*
		|-----------------------------------------------------
		|	  RETORNA AS CORES PREDOMINANTES DE UMA IMAGEM
		|-----------------------------------------------------
		*/
		static public function corPredominante($image, $array = false, $format = 'rgb(%d, %d, %d)'){
			if(mime_content_type($image)=='image/png'){
				$i = imagecreatefrompng($image);
			}elseif(mime_content_type($image)=='image/jpg' || mime_content_type($image)=='image/jpeg'){
				$i = imagecreatefromjpeg($image);
			}
			$r_total=$g_total=$b_total=$total= 0;
			for ($x=0;$x<imagesx($i);$x++) {
				for ($y=0;$y<imagesy($i);$y++) {
					$rgb = imagecolorat($i,$x,$y);
					$r = ($rgb >> 16) & 0xFF; $g = ($rgb >> 8) & 0xFF; $b = $rgb & 0xFF;
					$r_total += $r;
					$g_total += $g;
					$b_total += $b;
					$total++;
				}
			}
			$r = round($r_total / $total);
			$g = round($g_total / $total);
			$b = round($b_total / $total);
			$rgb = ($array) ? array('r'=> $r, 'g'=> $g, 'b'=> $b) : sprintf($format, $r, $g, $b);
			return [[$r,$g,$b],$rgb];

		}


		/*
		|-----------------------------------------------------
		|	  RETORNSA UM PLACEHOLDER EM DATA:BASE64
		|-----------------------------------------------------
		*/
		static public function placeholderBase64($PARAM=[]){
			if(!is_array($PARAM)){
				throw new Exception('Formato incorreto em svgBase64, utilize ARRAY');
			}
			return 'data:image/svg+xml;base64,'.base64_encode(self::placeholderSVG($PARAM));
		}


		/*
		|-----------------------------------------------------
		|	  RETORNA UMA LISTA DE IMAGENS DA unsplash.com
		|-----------------------------------------------------
		|
		|	Documentação:
		|	https://unsplash.com/developers
		|
		*/
		public static function bancoDeImg($opt=[]){
			$param = (object)[
				'query' 	=> $opt['query'] 	?? 'people',
				'limit' 	=> $opt['limit'] 	?? 15,
				'w' 		=> $opt['w'] 		?? 0,
				'h' 		=> $opt['h'] 		?? 0,
				'q' 		=> $opt['q'] 		?? 100,
				'fit' 		=> $opt['fit'] 		?? 'crop',
			];
			$pesquisa = explode('|',$param->query);
			$retorno = [];
            $link ='https://unsplash.com/napi/search?query='.$param->query.'&per_page='.$param->limit;


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            if ($result === false) {
                $error = curl_error($ch);
                curl_close($ch);
                return $error;
            }
            curl_close($ch);
            return $result;








			// foreach(curl::multi($link) as $value){
			// 	$link =json_decode($value,true);
			// 	foreach($link['photos']['results'] as $row){
			// 		$retorno[] = substr($row['urls']['raw'],0,strpos($row['urls']['raw'],'?')).'?fit='.$param->fit.'&w='.$param->w.'&h='.$param->h.'&q='.$param->q.'';
			// 	};
			// }
			// return $retorno;
		}


		/*
		|-----------------------------------------------------
		|	  CRIA UM PLACEHOLDER SVG DE UMA IMAGEM COM BLUR 
		|-----------------------------------------------------
		|
		|	Transformamos os pixels de uma imagem em quadriculados 
		|	de um svg e colocamos um BLUR para utilizar como placeholder
		|
		*/
		static public function createLazyLoad($image){
			$_FILENAME_SEM_EXT	= substr(basename($image),0,-4);
			$_EXTENSION			= substr(basename($image),-3);
			$_PATHSERVER		= dirname($image);

			$TEMP_IMAGEM		= $_PATHSERVER . '/' . $_FILENAME_SEM_EXT . '-lazy.' . $_EXTENSION;
			if($_EXTENSION=='jpg' || $_EXTENSION=='jpeg'){$_Q =  '100';};
			if($_EXTENSION=='png'){$_Q = '9';};
			if($_EXTENSION=='gif'){$_Q = '100';};
			$N_thumb			= new thumb($image);
			$N_thumb->sufix		= false;
			$N_thumb->crop		= true;
			$N_thumb->setFolder($_PATHSERVER);
			$N_thumb->setDimensions(array(8, 0)); //largura e altura da thumb, aceita arrays multidimensionais
			$N_thumb->newName($TEMP_IMAGEM);
			$N_thumb->showBrowser(false);
			$N_thumb->setJpegQuality($_Q);
			$N_thumb->setPngQuality($_Q);
			$N_thumb->setGifQuality($_Q);
			$N_thumb->process();
			$colors = self::getColor($TEMP_IMAGEM);
			$_RGB 	= self::corPredominante($TEMP_IMAGEM);
			$BASE_SIZES = getimagesize($image);
			$BASE_W = $BASE_SIZES[0];
			$BASE_H = $BASE_SIZES[1];
			chmod($TEMP_IMAGEM, 0777);
			unlink($TEMP_IMAGEM);
			$fator = 5;
			$i_PCT = $fator / 100;
			$i_X = 0;
			$i_Y = 0;
			$filter = 'filter="url(#f1)"';
			$out = '<svg xmlns="http://www.w3.org/2000/svg" ' . $filter . ' viewBox="0 0 '.$BASE_W.' '.$BASE_H.'" width="'.$BASE_W.'px" height="'.$BASE_H.'px"  style="background-color: ' . $_RGB[1] . ';" ><defs><filter id="f1"  x="0" y="0"><feGaussianBlur in="SourceGraphic"   stdDeviation="70" /></filter></defs>';
			foreach ($colors as $_LINHA) {
				$X_PCT = (100 / count($_LINHA));
				$Y_PCT = (100 / count($colors));
				$i_X = 0;
				foreach ($_LINHA as $_COLUNA) {
					$out .= '<rect   y="' . ($i_Y * $Y_PCT) . '%" x="' . ($i_X * $X_PCT) . '%" width="' . $X_PCT . '%" height="' . $Y_PCT . '%" style="fill:#' . $_COLUNA . ';" />';
					$i_X++;
				}
				$i_Y++;
			}
			$out .= '</svg>';
			file_put_contents($_PATHSERVER . '/' . $_FILENAME_SEM_EXT.'-lazy.svg', $out);
			file_put_contents($_PATHSERVER . '/' . $_FILENAME_SEM_EXT.'-lazy.low.svg', '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"><rect width="100%" height="100%" fill="' . $_RGB[1] . '"/></svg>');
			return true;
		}


		/*
		|-----------------------------------------------------
		|	ADICIONA UM TEXTO POR CIMA DE UMA IMAGEM
		|-----------------------------------------------------
		*/
		static public function addTexto($DATA){
			$DATA['FINAL']			=	$DATA['FINAL']		??	null;
			$DATA['ORIGINAL']		=	$DATA['ORIGINAL']	??	null;
			$DATA['FONT_SIZE']		=	$DATA['FONT_SIZE']	??	30;
			$DATA['TEXT_Y'] 		=	$DATA['TEXT_Y']		?? 'center';
			$DATA['TEXT_X'] 		=	$DATA['TEXT_X']		?? 'center';
			$DATA['TEXTO'] 			=	$DATA['TEXTO']		?? 'LORIPSUM';
			$DATA['FONTE'] 			=	$DATA['FONTE']		?? null;
			$DATA['COR'] 			=	$DATA['COR'] 		?? '#FFFFFF';
			$DATA['COR'] 			=	self::hexToRgb($DATA['COR']);
			$_TEXT_SIZE				=	self::calcularTextBox($DATA['FONT_SIZE'],0,$DATA['FONTE'],$DATA['TEXTO']);
			$TEXT_W 				=	$_TEXT_SIZE['width'];
			$TEXT_H 				=	$_TEXT_SIZE['height'];
			$BASE_SIZES				=	getimagesize($DATA['ORIGINAL']);
			$BASE_W 				=	$BASE_SIZES[0];
			$BASE_H 				=	$BASE_SIZES[1];
			$DATA['ORIGINAL_FILE'] = @imagecreatefromjpeg($DATA['ORIGINAL']);
			if ( $DATA['ORIGINAL_FILE'] === false){
				$DATA['ORIGINAL_FILE'] = @imagecreatefromgif($DATA['ORIGINAL']);
				if ( $DATA['ORIGINAL_FILE'] === false){
					$DATA['ORIGINAL_FILE'] = @imagecreatefrompng($DATA['ORIGINAL']);
					if ( $DATA['ORIGINAL_FILE'] === false){ 
						echo  'Cannot load file as JPEG, GIF or PNG!';
					}
				}
			}
			$_FONTCOLOR 			=	imagecolorallocate($DATA['ORIGINAL_FILE'], $DATA['COR']['r'], $DATA['COR']['g'], $DATA['COR']['b']);
			$TEXT_X = ($DATA['TEXT_X']=='center') ? (($BASE_W / 2) - ($TEXT_W / 2)) : $DATA['TEXT_X'];
			$TEXT_Y = ($DATA['TEXT_Y']=='center') ? (($BASE_H / 2) + ($TEXT_H / 2)) : ($DATA['TEXT_Y']+$TEXT_H);
			imagettftext($DATA['ORIGINAL_FILE'], $DATA['FONT_SIZE'],0,intval($TEXT_X),intval($TEXT_Y),$_FONTCOLOR,$DATA['FONTE'],$DATA['TEXTO']);
			imagepng($DATA['ORIGINAL_FILE'], $DATA['FINAL'], 9);
			return true;
		}

		static public function calcularTextBox($size, $angle, $fontfile, $text) {
			$bbox = imagettfbbox($size, $angle, $fontfile, $text);
			if($bbox[0] >= -1) {
				$bbox['x'] = abs($bbox[0] + 1) * -1;
			} else {
				$bbox['x'] = abs($bbox[0] + 2);
			}
			$bbox['width'] = abs($bbox[2] - $bbox[0]);
			if($bbox[0] < -1) {
				$bbox['width'] = abs($bbox[2]) + abs($bbox[0]) - 1;
			}
			$bbox['y'] = abs($bbox[5] + 1);
			$bbox['height'] = abs($bbox[7]) - abs($bbox[1]);
			if($bbox[3] > 0) {    $bbox['height'] = abs($bbox[7] - $bbox[1]) - 1;}
			return $bbox;
		}

		/*
		|-----------------------------------------------------
		|	CROPA UMA IMAGEM
		|-----------------------------------------------------
		*/
        static public function crop($_IMG=null,$size=[50,50,100],$sufix=true,$crop=true,$resize=true,$showBrowser=false){
			
                $thumb = new thumb($_IMG); 							//link ou resource da imagem original
                $thumb->sufix=$sufix; 								//caso queira setar um sufixo -> imagem-750x320


                $thumb->crop=($size[0]==0 || $size[1]==0)?false:$crop;									//se a imagem deverá ser cropada ou não


                $thumb->resize=$resize; 							//redimenciona a imagem conforme cropa
                $thumb->setDimensions($size); 						//largura e altura da thumb, aceita arrays multidimensionais
                $thumb->setFolder(dirname($_IMG)); 					//caso queira que a thumb seja salva numa pasta

				
				$qualidade = (count($size)==3) ? $size[2] : null;


                $thumb->setJpegQuality(($qualidade??100));			//qualidade JPG (0-100)
                $thumb->setPngQuality(($qualidade??9)); 			//qualidade do PNG (0-9)
                $thumb->setGifQuality(($qualidade??100));			//qualidade do GIF (0-100)
                $thumb->forceDownload(false);						//true para setar a thumb para download
                $thumb->showBrowser($showBrowser);					//true para setar a thumb para mostrar no navegador
                $thumb->process();
                return true;
        }

		/*
		|-----------------------------------------------------
		|	MESCLA 2 IMAGENS
		|-----------------------------------------------------
		*/
		static public function mesclarIMG($_BASE,$_SOBREPOSICAO,$_X,$_Y,$_OUTPUT){
			if(getType($_BASE)=='string'	){		$_BASE			= (pathinfo($_BASE)['extension']	== 'jpg' || pathinfo($_BASE)['extension']	== 'jpeg') ? imagecreatefromjpeg($_BASE):  imagecreatefrompng($_BASE);}
			if(getType($_SOBREPOSICAO)=='string'){	$_SOBREPOSICAO	= (pathinfo($_SOBREPOSICAO)['extension']	== 'jpg' || pathinfo($_SOBREPOSICAO)['extension']	== 'jpeg') ? imagecreatefromjpeg($_SOBREPOSICAO):imagecreatefrompng($_SOBREPOSICAO);}
			$W_THUMB    = 	imagesx( $_SOBREPOSICAO );
			$H_THUMB    = 	imagesy( $_SOBREPOSICAO );
			imagealphablending($_BASE, true);
			imagesavealpha($_BASE, true);
			imagecopy($_BASE, $_SOBREPOSICAO, $_X, $_Y, 0, 0, $W_THUMB, $H_THUMB);
			imagepng($_BASE, $_OUTPUT);
			return true;
		}


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
		static public function processaImagem($_ARQUIVO=null,$_SIZES=[750,500,100,50],$_ROOT_SIZE=1000) {

			if(is_array($_ARQUIVO) && count($_ARQUIVO)>1){
				$_FULLPATH      =	$_ARQUIVO[0];
				$_HASH			=	$_ARQUIVO[1];		
			}else{
				$_HASH			=	substr(bin2hex(random_bytes(500)),0,32);
				$_FULLPATH      =	$_ARQUIVO;
			}

			if(file_exists($_FULLPATH)){
				//------------------------------------------------------------------
					$_RETURN 			=	[];
					$_EXTENSION			=	str_replace('jpeg','jpg',explode('/',mime_content_type($_FULLPATH))[1]);
					$NEW_PATH         	=	dirname($_FULLPATH);

				//------------------------------------------------------------------
				//	TRANSFORMA EM PNG CASO SEJA JPG
				//------------------------------------------------------------------
					if($_EXTENSION=='jpg'){
						self::jpg2png($_FULLPATH,9);
						$_EXTENSION = 'png';
					}
					$_FILENAME			=	$_HASH.'.'.$_EXTENSION;
				//------------------------------------------------------------------
				//	COPIAMOS E RENOMEAMOS
				//------------------------------------------------------------------
					copy($_FULLPATH,$NEW_PATH.'/original.'.$_EXTENSION);
					rename($_FULLPATH,$NEW_PATH.'/'.$_FILENAME);
				
					$_FULLPATH = $NEW_PATH.'/'.$_FILENAME;


				//------------------------------------------------------------------
				//	REDIMENCIONA O ORIGINAL PARA O TAMANHO MÁXIMO
				//------------------------------------------------------------------
					@mkdir($NEW_PATH,775,true);
					sweet::crop($_FULLPATH,false,[$_ROOT_SIZE,0],true,false);

				//------------------------------------------------------------------
				//	CRIAMOS O SVG DE PREVIEW
				//------------------------------------------------------------------
					sweet::createLazyLoad($NEW_PATH.'/'.$_FILENAME);
					$_RETURN['ORIGINAL']	=	$_FILENAME;
					$_RETURN['SIZES']		=	[];
					$_RETURN['LAZYLOW']		=	explode('.',$_FILENAME)[0].'-lazy.low.svg';
					$_RETURN['LAZY']		=	explode('.',$_FILENAME)[0].'-lazy.svg';

				//------------------------------------------------------------------
				//	DERIVAMOS OS TAMAHOS DA IMAGEM
				//------------------------------------------------------------------
					foreach ($_SIZES as $value) {
						$_QUAL 				= (is_array($value)) ? ( (isset($value[2]))?$value[2] : self::getQuality($_FULLPATH)) : self::getQuality($_FULLPATH);
						$_NAMESIZE			= (is_array($value)) ? implode('x',$value):$value.'x0x'.$_QUAL;
						$SIZES				= (is_array($value)) ? [$value[0],$value[1]] : [$value,0];
						$_RETURN['SIZES'][] = $_HASH.'-'.$_NAMESIZE.'.'.$_EXTENSION;
						sweet::crop($NEW_PATH.'/'.$_FILENAME,true,$SIZES,true,true,$_QUAL);
					}
				return $_RETURN;
			}else{
				return false;

			}
		}








	}

