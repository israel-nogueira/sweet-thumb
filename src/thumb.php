<?php

	namespace IsraelNogueira\SweetThumb;
	use IsraelNogueira\SweetThumb\thumbbrowser;
	use IsraelNogueira\SweetThumb\image;

	class thumb extends thumbbrowser{
		public $crop;
		public $sufix;
		public $resize = true;
		private $dimensions;
		private $proporcional = true;
		private $x;
		private $y;
		private $stream;
		private $thumbWidth;
		private $thumbHeight;
		private $resource;
		
		public function __construct( $image ) {
			image::setImage( $image );
			image::setJpegQuality( 100 );
			image::setPngQuality( 9 );
			image::setGifQuality( 100 );
			thumbbrowser::showBrowser( false );
			thumbbrowser::forceDownload( false );   
		}
		
		public function setDimensions( array $dimensions ) {
			$this->dimensions = $dimensions;
		}
		
		public function getDimensions( ) {
			return $this->dimensions;
		}
		
		public function process( ) {
			image::readImage(); //ler a imagem
			$thumb = null;
			
			//se for múltiplas thumbs
			if( isset( $thumb[0][0] ) ) {
				$thumb = $this->getDimensions();
			} else {
				$thumb[] = $this->getDimensions();
			}

			foreach( $thumb as $t ) {
				
				// altura proporcional
				if( is_numeric( $t[0] ) and empty( $t[1] ) ) {
					$this->crop = isset( $t[2] ) ? true : false; // caso queira cropar imagens proporcionais, que por padrão são apenas redimensionadas
					$this->thumbWidth = $t[0];
					$this->thumbHeight = round( ( image::getInfoImage( 1 ) * $this->thumbWidth ) / image::getInfoImage( 0 ) ); 
				} 
				
				// largura proporcional
				else if( empty( $t[0] ) and is_numeric( $t[1] ) ) {
					$this->crop = isset( $t[2] ) ? true : false;
					$this->thumbHeight = $t[1];
					$this->thumbWidth = round( ( image::getInfoImage( 0 ) * $this->thumbHeight ) / image::getInfoImage( 1 ) ); 
				}
				
				// altura e largura setados
				else if( is_numeric( $t[0] ) and is_numeric( $t[1] ) ) {
					$this->crop = $this->crop;
					$this->thumbWidth = $t[0];
					$this->thumbHeight = $t[1];
				}
				
				// Só gerar a thumb caso a imagem seja grande o suficiente
				// Se a largura da thumb for maior que a original, reduzí-la até o tamanho original
				// Se a altura da thumb for maior que a original, reduzí-la até o tamanho original
				$this->thumbWidth = ( $this->thumbWidth > image::getInfoImage( 0 ) ) ? image::getInfoImage( 0 ) : $this->thumbWidth;
				$this->thumbHeight = ( $this->thumbHeight > image::getInfoImage( 1 ) ) ? image::getInfoImage( 1 ) : $this->thumbHeight;

				$this->makeThumb();
			}
		}
		
		private function sufix() {
			preg_match( "/(.*)(\.[a-z0-9]+)$/", image::getImage(), $r );
			$nome       = $r[1];
			$extensao   = $r[2];
			if($this->newName!=null){
				if( $this->sufix ) { 
					switch( image::getMimeType() ) {
						case "image/jpg":	image::setName( $this->newName . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
						case "image/jpeg":	image::setName( $this->newName . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
						case "image/png":	image::setName( $this->newName . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getPngQuality().$extensao); break;
						case "image/gif":	image::setName( $this->newName . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getGifQuality().$extensao); break;
						default: 			image::setName( $this->newName . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
					}
				} else {
					image::setName( ($this->newName));
				}
			}elseif( $this->sufix ) { 
				switch( image::getMimeType() ) {
					case "image/jpg":	image::setName( $nome . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
					case "image/jpeg":	image::setName( $nome . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
					case "image/png":	image::setName( $nome . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getPngQuality().$extensao); break;
					case "image/gif":	image::setName( $nome . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getGifQuality().$extensao); break;
					default: 			image::setName( $nome . "-" . ceil( $this->dimensions[0] ) . "x" . ceil( $this->dimensions[1] ) . 'x' . image::getJpegQuality().$extensao); break;
				}
			} else {
				image::setName($nome.$extensao);
			}
		}

		private function imageCreate( ) {
			switch( image::getMimeType() ){
				case "image/jpeg": $this->stream = imagecreatefromjpeg( image::getImage() ); break;
				case "image/png": $this->stream = imagecreatefrompng( image::getImage() ); break;
				case "image/gif": $this->stream = imagecreatefromgif( image::getImage() ); break;
				default: $this->stream = imagecreatefromjpeg( image::getImage() );
			}
			
			$this->y = imagesy( $this->stream );
			$this->x = imagesx( $this->stream );
				
			//Salvar corretamente as transparências do PNG
			if( image::getMimeType() == 'image/png' ) {
				$trueColor = imageistruecolor( $this->stream );
				
				//Se a imagem é uma True Color
				if( $trueColor ) {
					$this->resource = imagecreatetruecolor( $this->thumbWidth, $this->thumbHeight );
					imagealphablending( $this->resource, false );
					imagesavealpha( $this->resource, true );
				//Se a imagem é indexada
				} else {
					$this->resource = imagecreate( $this->thumbWidth, $this->thumbHeight );
					imagealphablending( $this->resource, false );
					$transparent = imagecolorallocatealpha( $this->resource, 0, 0, 0, 127 );
					imagefill( $this->resource, 0, 0, $transparent );
					imagesavealpha( $this->resource, true );
					imagealphablending( $this->resource, true );
				}
			//Caso for JPG ou GIF (Não funciona com GIF Animado =P)
			} else {
				$this->resource = imagecreatetruecolor( $this->thumbWidth, $this->thumbHeight );
			}
			$this->crop( );
		}
		
		private function crop( ) {
			
			//dimensões originais
			$largura_original = image::getInfoImage( 0 );
			$altura_original = image::getInfoImage( 1 );
			
			
			// CROPA + REDIMENCIONA
			if( $this->crop && $this->resize ) {
				//Eixos iniciais
				$thumbX = 0;
				$thumbY = 0;
				
				//Largura e altura iniciais
				$thumbLargura = $largura_original;
				$thumbAltura = $altura_original;
				
				//Proporção inicial (paisagem, retrato ou quadrado)
				$proporcaoX = $largura_original / $this->thumbWidth;
				$proporcaoY = $altura_original / $this->thumbHeight;
				
				//Imagem paisagem
				if( $proporcaoX > $proporcaoY ) {
					
					$thumbLargura   = round( $largura_original / $proporcaoX * $proporcaoY );
					$thumbX         = round( ( $largura_original - ( $largura_original / $proporcaoX * $proporcaoY ) ) / 2 );
					
				} 
				//Imagem retrato
				else if( $proporcaoY > $proporcaoX ){
					//   $thumbLargura = round( $largura_original / $proporcaoX * $proporcaoY );
					$thumbAltura = round( $altura_original / $proporcaoY * $proporcaoX );
					$thumbY     = round( ( $altura_original - ( $altura_original / $proporcaoY * $proporcaoX ) ) / 2 );
				}
				//Cropar a imagem no ponto ideal
				imagecopyresampled ( $this->resource, $this->stream, 0, 0, $thumbX, $thumbY,    $this->thumbWidth, $this->thumbHeight, $thumbLargura, $thumbAltura);
				
				// APENAS CROPA E CENTRALIZA
			}elseif($this->crop && !$this->resize) { 
				$centerXthumb		= $this->thumbWidth/2;
				$centerYthumb		= $this->thumbHeight/2;
				$centerXOriginal	= $largura_original/2;
				$centerYOriginal	= $altura_original/2;
				$thumbLargura   	= $this->thumbWidth;
				$thumbAltura    	= $this->thumbHeight;
				$thumbX         	= - ( $centerXthumb - $centerXOriginal );
				$thumbY         	= - ( $centerYthumb - $centerYOriginal );
				imagecopyresampled ( $this->resource, $this->stream, 0, 0, $thumbX, $thumbY,    $this->thumbWidth, $this->thumbHeight, $thumbLargura, $thumbAltura);
			} else { 
				// APENAS REDIMENCIONA PROPORCIONALMENTE
				imagecopyresampled( $this->resource, $this->stream, 0, 0, 0, 0,$this->thumbWidth, $this->thumbHeight, $this->x, $this->y );
			}
			thumbbrowser::prepare( $this->resource );
		}
		private function makeThumb( ) { 
			//Usuário não quer redimensionar, manter a mesma dimensão
			if( is_null( $this->getDimensions() ) or ( $this->thumbWidth == image::getInfoImage( 0 ) and $this->thumbHeight == image::getInfoImage( 1 ) ) ) {
				$this->thumbWidth = image::getInfoImage( 0 );
				$this->thumbHeight = image::getInfoImage( 1 );
			}
			$this->sufix();
			$this->imageCreate();
		}
	}
?>