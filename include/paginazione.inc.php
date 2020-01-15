<?php
	class Paginazione
	{
		private $xpage = 0;
		private $tot = 0;
		private $varq = "";
		private $totpag = 0;
		private $cpage = 0;
		private $query = "";
		private $record = array();
	
		public function Paginazione($query, $xpage, $varq)
		{
			global $db;
			
			// le rendo globali
			$this->xpage = $xpage;
			$this->varq = $varq;
			$this->query = trim($query);
			
			// pagina corrente sia get che post
			$this->cpage = (isset($_REQUEST[$varq])) ? (int)$_REQUEST[$varq] : 1;
			
			// inizio record
			$inizio = $xpage * ($this->cpage - 1);
			
			// eseguo la query per contare i record
			$ct = $db->Query($this->query);
			
			// record totali
			$this->tot = $db->Count($ct);
			
			// se ci sono record
			if($this->tot > 0)
			{
				// pagine totali
				$this->totpag = ceil($this->tot / $xpage);
				
				// scrivo ed eseguo la query mirata
				$target = " LIMIT " . $inizio . ", " . $xpage;
				$ex = $db->Query($this->query . $target);
				
				while($ft = $db->getAssoc($ex))
				{
					$record[] = $ft;
				}
				
				$this->record = $record;
			}
			else
			{
				$this->record = array();
			}
		}
		
		public function Show()
		{
			if(count($this->record) > 0)
			{
				return $this->record;
			}
			else
			{
				return false;
			}
			
		}
		
		public function Link($nlink = 4)
		{
			$before = array();
			$after = array();
			
			if($this->cpage < $nlink)
			{
				$nlink *= 2;
				$nlink -= ($this->cpage - 1);
			}
			elseif($this->cpage > ($this->totpag - $nlink))
			{
				$nlink *= 2;
				$nlink -= ($this->totpag - $this->cpage);
			}
			
			
			
			for($i = $nlink; $i>=1; $i--)
			{
				if(($this->cpage - $i) >= 1)
				{
					$before[] = $this->cpage - $i;
				}
			}
			
			for($i = 1; $i<=$nlink; $i++)
			{
				if(($this->cpage + $i) <= $this->totpag)
				{
					$after[] = $this->cpage + $i;
				}
				
				if($this->cpage == $nlink)
					$nlink += 1;
			}
			
			$link["first"] = 1;
			$link["before"] = $before;
			$link["current"] = $this->cpage;
			$link["after"] = $after;
			$link["last"] = $this->totpag;
			
			if($this->cpage <= $this->totpag && $this->totpag > 1)
			{
				return $link;
			}
			else
			{
				return false;
			}
		}
	}
?>