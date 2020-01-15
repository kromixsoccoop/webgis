<?php

/**
 * @name SQLManager
 * @description Classe per Gestire il Database
 * @author StefanoV
 * @copyright 2015
 */

class SQLManager
{
	var $risorsa; // risorsa del db
	var $dieerror = true; // esce con il mysql error
	var $mailerror = ""; // invia una mail con l'errore della query.
	var $logfile = ""; // percorso dove salvare il log delle query
	var $logall = false; // decide se mostrare anche le query che hanno avuto successo
	
	function SQLManager($dieerror = true, $mailerror = "", $logfile = "", $logall = false)
	{
		$this->dieerror = $dieerror;
		$this->mailerror = $mailerror;
		$this->logfile = $logfile;
		$this->logall = $logall;
	}
	/*********************************** Funzioni Base ****************************************/
	
	/**
	 * Permette di usare una risorsa già aperta
	 *
	 * Param: $res (resource) - risorsa da utilizzare
	 */
	function usaRisorsa($res)
	{
		// se $res è settata, non vuota, ed è una risorsa
		if(isset($res) && !empty($res) && is_resource($res))
		{
			// applicala come risorsa globale
			$this->risorsa = $res;
		}
	}
	
	/**
	 * Conta i campi utilizzati nella query
	 *
	 * Param: $query (resource) - risorsa da utilizzare
	 */
	function countField($query)
	{
		return $query->field_count;
	}
	
	/**
	 * Ottiene una singola riga
	 *
	 * Param: $query (resource) - risorsa da utilizzare
	 */
	function getRow($query)
	{
		return $query->fetch_row();
	}
	
	/**
	 * Ottiene la riga risultante
	 *
	 * Param: $query (resource) - risorsa da utilizzare
	 * Param: $offset (int) - numero di riga da prendere
	 * Param: $field (string) - nome del campo da prendere
	 */
	function getResult($query, $offset, $field)
	{
		$query->data_seek($offset);
		
		$datarow = $query->fetch_array();
		
		return $datarow[$field]; 
	}
	
	/**
	 * Ottiene il nome del campo
	 *
	 * Param: $query (resource) - risorsa da utilizzare
	 * Param: $campo (int) - numero del campo richiamato
	 */
	function getFieldName($query, $campo)
	{
		$a = $query->fetch_fields();
		
		return $a[$campo]->name;
	}
	
	/**
	 * Connette lo script al Database MySQL
	 *
	 * Param: $host (string) - server del database
	 * Param: $user (string) - username del database
	 * Param: $pass (string) - password del database
	 * Param: $db (string) - nome del database
	 */
	function Open($host, $user, $pass, $db, $newlink = false)
	{
		// se i campi sono inseriti
		if(empty($host) || empty($user) || empty($db))
			exit();
		
		// connetto al' host
		$ris = new mysqli($host, $user, $pass, $db) or $this->getErr("Nessuna", "Errore di connessione all'host!");
		
		// setto la risorsa come globale della classe
		$this->risorsa = $ris;
	}
	
	/**
	 * Cambia la selezione del db
	 *
	 * Param: $dbname (string) - nome del db da selezionare
	 */
	function changeDb($dbname)
	{
		$this->risorsa->select_db($dbname) or $this->getErr("Nessuna", "Errore di selezione del database!");
	}
	
	/**
	 * Libera le risorse della risorsa risultante dalla query
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 */
	function Free($query)
	{
		if($query->close())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Restituisce l'ID generato dall' ultima query INSERT
	 */
	function lastID()
	{
		return $this->risorsa->insert_id;
	}
	
	/**
	 * Restituisce le righe contate nella query
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 */
	function Count($query)
	{
		return (int)$query->num_rows;
	}
	
	/**
	 * Restituisce le righe contate nell'ultima query
	 */
	function righeInteressate()
	{
		return (int)$this->risorsa->affected_rows;
	}
	
	
	/**
	 * Restituisce true se trova almeno un record
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 */
	function Found($query)
	{
		if($this->Count($query) != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Mostra l'errore o manda la mail con l'errore
	 *
	 * Param: $errore (string) - stringa di errore restituita da MySQL
	 * Param: $mErr (string) - stringa di errore da mostrare scelta da noi
	 */
	private function getErr($query, $errore = "")
	{
		
		if(empty($errore)) $errore = $this->risorsa->error;
		
		// se bisogna mandare la mail
		if(!empty($this->mailerror))
		{
			// testo mail
			$testo = "Si è verificato un errore: ".$errore." \r\n \r\n Indirizzo del file chiamato: ".$_SERVER['REQUEST_URI'];
			
			// destinatario
			$to = $this->mailerror;
			
			// soggetto
			$subject = "SQLManager: Errore query.";
			
			// headers
			$headers = "From: $to\r\n";
			$headers .= "Reply-To: $to\r\n";
			$headers .= "Return-Path: $to\r\n";
			
			// manda la mail
			if (!mail($to, $subject, $testo, $headers))
			{
				// se non va a buon fine, mostra l'errore
			   die("Errore durante l'invio della Segnalazione!");
			}
			
		}
		
		if(!empty($this->logfile))
		{
			$fp = @fopen($this->logfile, "a");
			@fwrite($fp, $tipo . date("d/m/Y H:i:s")." - Si è verificato un errore: $errore - Query: ".$query."\r\n");
			@fclose($fp);
		}
		
		if($this->dieerror)
		{
			// mostra errore personale
			die($errore);
		}
	}
	
	/**
	 * Esegue la query al database
	 *
	 * Param: $query (string) - la query da eseguire al database
	 * Param: $manualError (string) - errore personalizzato in caso di fallimento della query
	 */
	function Query($query, $manualError = "")
	{
		// inizio conteggio tempo
		$msc=microtime(true);
		
		// eseguo la query
		$rs = $this->risorsa->query($query) or $this->getErr($query, $manualError);
		
		// fine conteggio query
		$msc=round(microtime(true)-$msc, 3);
		
		// se è andata bene
		if($rs)
		{
			
			if(!empty($this->logfile) && $this->logall)
			{
				$fp = @fopen($this->logfile, "a");
				@fwrite($fp, $tipo . date("d/m/Y H:i:s")." - Query eseguita correttamente: $query - Durata $msc secondi\r\n");
				@fclose($fp);
			}
			// restituisco il link di risorsa
			return $rs;
			
		}
	}
	
	/**
	 * Ottiene i dati come oggetti (da usare come mysql_fetch_object)
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 */
	function getObject($query)
	{
		// ottiene le righe come oggetto
		$rig = $query->fetch_object();
		
		// restituisce il tutto
		return $rig;
	}
	
	/**
	 * Ottiene i dati come oggetti (da usare come mysql_fetch_object)
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 */
	function getAssoc($query)
	{
		// ottiene le righe come oggetto
		$rig = $query->fetch_array(MYSQLI_ASSOC);
		
		// restituisce il tutto
		return $rig;
	}
	
	/**
	 * Chiude la connessione al Database
	 */
	function Close()
	{
		$this->risorsa->close();
	}
	
	/*********************************** Funzioni Utili ****************************************/
	
	/**
	 * Ottiene i dati ottenuti da una query SELECT in un array
	 *
	 * Param: $query (resource link) - la risorsa ottenuta dalla funzione doQuery
	 * Param: $associativo (boolean) - determina se creare un sotto-array associativo per ogni riga, oppure no
	 */
	function getArray($query, $associativo = true)
	{
		// dichiaro e svuoto l'array
		$arrayCampi = array();
		
		// ciclo i nomi dei campi nella SELECT e li metto in array
		for($i = 0; $i < $query->field_count; $i++)
		{
			$arrayCampi[] = $query->fetch_field()->name;
		}
		
		// dichiarazione e svuotamento array $dati
		$dati = array();
		
		// ciclo per ottenere i valori associativi in $linea
		while($linea = $query->fetch_array(MYSQLI_ASSOC))
		{
			
			// dichiaro e svuoto l'array $par
			$par = array();
			
			// ciclo i nomi passati nell'array $arrayCampi
			foreach($arrayCampi as $nomi)
			{
				// se è impostato l'associativo
				if($associativo)
				{
					// mette in $par i valori come array associativo
					$par[$nomi] = $linea[$nomi];
				}
				else // ... altrimenti ... 
				{
					// mette in $par i valori come array numerato
					$par[] = $linea[$nomi];
				}
				
			}
			
			// aggiunge all'array $dati, l'array $par
			$dati[] = $par;
		}
		
		// restituisce i dati
		return $dati;
	}
	
	/**
	 * Muove il puntatore interno ad una riga
	 *
	 * Param: $query (resource) - la risorsa della query
	 * Param: $riga (int) - la riga da cui iniziare - Default: 0
	 */
	function dataSeek($query, $riga = 0)
	{
		return $query->data_seek($riga);
	}
	
	/**
	 * Inserisce un array (chiave => valore) nel database
	 *
	 * Param: $table (string) - la tabella del database
	 * Param: $array (array) - l'array da cui prendere i valori
	 */
	function insertArray($table, $array)
	{
		$keys = array_keys($array);
		
		$values = array_values($array);
		
		$sql = 'INSERT INTO ' . $table . '(' . implode(', ', $keys) . ') VALUES ("' . implode('", "', $values) . '")';
		
		return($this->Query($sql));
	}
	
	/**
	 * Resetta l'ultimo ID autoincrement
	 *
	 * Param: $table (string) - la tabella del database
	 */
	function resetIncrement($table)
	{
		$get = $this->Query("SELECT MAX(id) as mxid FROM $table");
		
		if($this->Found($get))
		{
			$max = $this->getObject($get);
			
			$mxid = (int)$max->mxid;
			
			$mxid++;
			
			$this->Query("ALTER TABLE $table AUTO_INCREMENT = $mxid");
		}
	}
	
	/**
	 * Ottiene un campo specifico
	 *
	 * Param: $campo (string) - il campo da restituire
	 * Param: $table (string) - la tabella da cui estrarre il campo
	 * Param: $where (string) - la clausula where
	 */
	function getField($campo, $table, $where)
	{ 

		// eseguo la query
		$query = $this->Query("SELECT $campo FROM $table WHERE $where LIMIT 1");
		
		$risultato = $this->getObject($query);
		
		return $risultato->$campo;
	}
}

?>