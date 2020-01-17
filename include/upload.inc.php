<?php
	class Uploader {
		
		private $ext_ok = array();
		private $ext_no = array();
		private $ctrl_ext = false;
		private $owrite = true;
		private $max_size = 0;
		private $path_file = '';
		private $campo = '';
		private $errore = '';
		
		public function Uploader($campo)
		{
			$this->campo = $campo;
		}
		
		public function getError()
		{
			return $this->errore;
		}
		
		public function set_opt($opzione, $valore)
		{
			if($opzione == 'controllo estensione')
			{
				$this->ctrl_ext = (bool)$valore;
			}
			elseif($opzione == 'estensioni consentite')
			{
				$this->ext_ok = explode(',', $valore);
			}
			elseif($opzione == 'estensioni non consentite')
			{
				$this->ext_no = explode(',', $valore);
			}
			elseif($opzione == 'massima dimensione')
			{
				$this->max_size = (int)$valore;
			}
			elseif($opzione == 'sovrascrittura')
			{
				$this->owrite = (bool)$valore;
			}
		}
		
		public function upload($destinazione)
		{
			$file = $_FILES[$this->campo]['name'];
			$size = $_FILES[$this->campo]['size'];
			$temp = $_FILES[$this->campo]['tmp_name'];
			
			if($this->max_size != 0 && ($size > $this->max_size))
			{
				$this->errore = ERR_TOO_BIG;
				return false;
			}
			else
			{
				$err = 0;
				
				if($this->ctrl_ext)
				{
						// non consentite
						if(count($this->ext_no) != 0)
						{
							foreach($this->ext_no as $no)
							{
								if(trim(strtolower($no)) == $this->getExt($file))
								{
									$err = 1;
								}
							}
						}
					
					if($err == 0)
					{
						$ctrl = 0;
						
						if(count($this->ext_ok) != 0)
						{ 
							foreach($this->ext_ok as $ok)
							{
								if(trim(strtolower($ok)) == $this->getExt($file))
								{
									$ctrl = 1;
								}
							}
						}
						else
						{
							$ctrl = 1;
						}
						
						if($ctrl == 0)
						{
							$err = 1;
						}
					}
				}
				
				if($err == 0)
				{
					if($this->owrite)
					{
						$this->path_file = $file;
					}
					else
					{
						if(file_exists($destinazione.$file))
						{
							$cas = md5(rand(0, 9999999999));
							
							$nome = $this->dividi($file);
							
							$iniziali = substr($nome, 0, 3);
							
							$estensione = $this->getExt($file);
							
							$this->path_file = $iniziali.$cas.'.'.$estensione;
						}
						else
						{
							$this->path_file = $file;
						}
					}
					
					if(is_uploaded_file($temp))
					{
						if(move_uploaded_file($temp, $destinazione.$this->path_file))
						{
							return true;
						}
						else
						{
							$this->errore = ERR_UPLOAD;
							return false;
						}
					}
					else
					{
						$this->errore = ERR_UPLOAD;
						return false;
					}
				}
				else
				{
					$this->errore = ERR_WRONG_EXT;
					return false;
				}
			}
		}
		
		private function getExt($path)
		{
			$file_split = explode(".", $path);

			$estensione = array_pop($file_split);
			
			return strtolower($estensione);
		}
		
		private function dividi($nome)
		{
		   $file_split = explode(".", $nome);

			$estensione = array_pop($file_split);

			$len_ext = strlen($estensione);
			
			$nomef = substr($nome, 0, (strlen($nome) - ($len_ext + 1)));
	
			return $nomef;
		}
		
		public function getName()
		{
			return $this->path_file;
		}
		
	}
?>