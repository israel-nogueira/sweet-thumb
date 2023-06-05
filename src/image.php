<?php
	namespace IsraelNogueira\SweetThumb;

	abstract class image{
		private $image;
		private $name;
		private $folder;
		private $resize;
		private $infoImage;
		private $path;
		private $jpegQuality;
		private $pngQuality;
		private $gifQuality;
		public $newName = null;
		public function getImage()                  {return $this->image;}
		public function setImage($image)            {$this->image = $image;}
		public function getName()                   {return $this->name;}
		public function setName($name)              {$this->name = $name;}
		public function newName($newName)           {$this->newName = $newName;}
		public function getFolder()                 {return $this->folder;}
		public function setFolder($folder)          {$this->folder = $folder;}
		public function setInfoImage($infoImage)    {$this->infoImage = getimagesize( $infoImage );}
		public function getInfoImage($index=null)   {return ( is_numeric( $index ) and array_key_exists( $index, $this->infoImage ) ) ? $this->infoImage[$index] : $this->infoImage;}
		public function setJpegQuality($quality)    {$this->jpegQuality = ( $quality > 0 and $quality <= 100 ) ? $quality : "100";}
		public function getJpegQuality()            {return $this->jpegQuality;}
		public function setPngQuality($quality)     {$this->pngQuality = ( $quality > 0 and $quality <= 9 ) ? $quality : "9";}
		public function getPngQuality()             {return $this->pngQuality;}
		public function setGifQuality($quality)     {$this->gifQuality = ( $quality > 0 and $quality <= 100 ) ? $quality : "100";}
		public function getGifQuality()             {return $this->gifQuality;}
		public function getMimeType(){return $this->infoImage['mime'];}
		public function readImage(){
			//se o script estiver na mesma pasta da imagem
			if( file_exists( $this->getImage( ) ) ) {
				$this->setInfoImage( $this->getImage( ) );
			} else {
				//caso contrário, acessar a imagem através do caminho completo (pasta/imagem)
				$this->setInfoImage( $this->getFolder( ) . "/" . $this->getImage( ) );
				$this->setImage( $this->getFolder( ) . "/" . $this->getImage( ) );
			}
		}
	}

	
?>