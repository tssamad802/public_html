<?php


class Databaseconnection
{


    public $Host = '';
    public $Database = '';
    public $User = '';
    public $Password = '';

    public $Auto_Free = 0; //# Set to 1 for automatic mysqli_free_result()
    public $Debug = 0;     //# Set to 1 for debugging messages.
    public $Halt_On_Error = 'yes'; //# "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)
    public $Seq_Table = 'db_sequence';
    public $Record = array();
    public $Row;
    public $Errno = 0;
    public $Error = '';
    public $type = 'mysql';
    public $revision = '1.2';
    public $Link_ID = 0;
    public $Query_ID = 0;

    public function Encrypt($data, $filePath)
    {
        // Encrypt the data to $encrypted using the public key
        $pubKey = openssl_get_publickey(file_get_contents($filePath));
        $res = openssl_public_encrypt($data, $encrypted, $pubKey);

        if ($res === false) {
            return ' false ';
        } else {
            return base64_encode($encrypted);
        }
    }
/*
    public function Decrypt($data, $filePath)
    {
      
	    $data = base64_decode($data);
        // Encrypt the data to $encrypted using the public key
        $privateKey = openssl_get_privatekey(file_get_contents($filePath));
        $res = openssl_private_decrypt($data, $decrypted, $privateKey);
        if ($res === false) {
            return  ' false ';
        } else {
            return $decrypted;
        }
    }

  */
    public function __construct($query = '')
    {
        $this->SetDbParams();
    }

    private function SetDbParams()
    {
		/*
       // $ini_array = parse_ini_file('visaconfig.ini', true);
        $this->Host = $ini_array['Database']['DATABASE_HOST'];
        $this->Database = $ini_array['Database']['DATABASE_NAME'];
        $this->User = $ini_array['Database']['DATABASE_USER'];        
        $this->Password = $this->Decrypt($ini_array['Database']['DATABASE_PASSWORD'], 'privatekey.pem');
		*/
		$this->Host = DATABASE_HOST;
        $this->Database = DATABASE_NAME;
        $this->User = DATABASE_USER;        
        $this->Password = DATABASE_PASSWORD;
	
    }

    public function link_id()
    {
        return $this->Link_ID;
    }

    public function query_id()
    {
        return $this->Query_ID;
    }

    public function connect($Database = '', $Host = '', $User = '', $Password = '')
    {
        $this->SetDbParams();
        // Handle defaults
        if ('' == $Database) {
            $Database = $this->Database;
        }
        if ('' == $Host) {
            $Host = $this->Host;
        }
        if ('' == $User) {
            $User = $this->User;
        }
        if ('' == $Password) {
            $Password = $this->Password;
        }

        // establish connection, select database
        if (!$this->Link_ID) {
		
	
            $this->Link_ID = mysqli_connect($Host,$User,$Password,$Database);
    		if (!$this->Link_ID) 
			{
                $this->halt("connect($Host, $User, \$Password) failed.");
                return 0;
            }
        }

        return $this->Link_ID;
    }

    /* public: discard the query result */
    public function free()
    {
        @mysqli_free_result($this->Query_ID);
        $this->Query_ID = 0;
    }

    /**
     * @function   						query
     * @Purpose    						Methods for performing database  query
     * @Author   	  					Shehzad Asghar Saddiq
     * @Creation Date    				5th December , 2006
     * @Last Modified    				10th January , 2010
     **/
    public function query($Query_String)
    {
        /* No empty queries, please, since PHP4 chokes on them.
       * The empty query string is passed on from the constructor,
       * when calling the class without a query, e.g. in situations
       * like these: '$db = new DB_Sql_Subclass;'
       */
        if ($Query_String == '') {
            return 0;
        }

        if (!$this->connect()) {
            return 0;
            // we already complained in connect() about that.
        }

        // New query, discard previous result.
        if ($this->Query_ID) {
            $this->free();
        }

        if ($this->Debug) {
            printf("Debug: query = %s<br>\n", $Query_String);
        }
        $this->Query_ID = @mysqli_query($this->Link_ID,$Query_String);
       
		$this->Row = 0;
        $this->Errno = mysqli_errno($this->Link_ID);
		$this->Error = mysqli_error($this->Link_ID);
       

        if (!$this->Query_ID) {
            $this->halt('Invalid SQL: '.($Query_String), debug_backtrace(0));
        }
        // Will return nada if it fails. That's fine.
        return $this->Query_ID;
    }

    public function next_record()
    {
        if (!$this->Query_ID) {
            $this->halt('next_record called with no query pending.');

            return 0;
        }
        $this->Record = @mysqli_fetch_array($this->Query_ID);
        $this->Row += 1;
        $this->Errno = mysqli_errno($this->Link_ID);
        $this->Error = mysqli_error($this->Link_ID);

        $stat = is_array($this->Record);
        if (!$stat && $this->Auto_Free) {
            $this->free();
        }

        return $stat;
    }
    /* public: position in result set */
    public function seek($pos = 0)
    {
        $status = @mysqli_data_seek($this->Query_ID, $pos);
        if ($status) {
            $this->Row = $pos;
        } else {
            $this->halt("seek($pos) failed: result has ".$this->num_rows().' rows');

            /* half assed attempt to save the day,
             * but do not consider this documented or even
             * desireable behaviour.
             */
            @mysqli_data_seek($this->Query_ID, $this->num_rows());
            $this->Row = $this->num_rows;

            return 0;
        }

        return 1;
    }

    /* public: table locking */
    public function lock($table, $mode = 'write')
    {
        $this->connect();

        $query = 'lock tables ';
        if (is_array($table)) {
            while (list($key, $value) = each($table)) {
                if ($key == 'read' && $key != 0) {
                    $query .= "$value read, ";
                } else {
                    $query .= "$value $mode, ";
                }
            }
            $query = substr($query, 0, -2);
        } else {
            $query .= "$table $mode";
        }
        $res = @mysqli_query($this->Link_ID, $query);
        if (!$res) {
            $this->halt("lock($table, $mode) failed.");

            return 0;
        }

        return $res;
    }

    public function unlock()
    {
        $this->connect();

        $res = @mysqli_query($this->Link_ID, 'unlock tables');
        if (!$res) {
            $this->halt('unlock() failed.');

            return 0;
        }

        return $res;
    }

    public function getLastInsertId()
    {
        return mysqli_insert_id($this->Link_ID);
    }
    /* public: evaluate the result (size, width) */
    public function affected_rows()
    {
        return @mysqli_affected_rows($this->Link_ID);
    }

    public function num_rows()
    {
        return @mysqli_num_rows($this->Query_ID);
    }
    public function list_fields()
    {
        //      return @mysqli_list_fields($this->Database, $table);`
        // echo $table;
    }

    public function num_fields()
    {
        return @mysqli_num_fields($this->Query_ID);
    }

    /* public: shorthand notation */
    public function nf()
    {
        return $this->num_rows();
    }

    public function np()
    {
        echo $this->num_rows();
    }

    public function f($Name)
    {
        if (isset($this->Record[$Name])) {
            return $this->Record[$Name];
        } else {
            return '';
        }
    }

    public function f_escape($Name)
    {
        if (isset($this->Record[$Name])) {
            return mysqli_real_escape_string($this->Link_ID ,  $this->Record[$Name]);
        } else {
            return '';
        }
    }

    public function p($Name)
    {
        echo $this->Record[$Name];
    }

    /* public: sequence numbers */
    public function nextid($seq_name)
    {
        $this->connect();

        if ($this->lock($this->Seq_Table)) {
            /* get sequence number (locked) and increment */
            $q = sprintf("select nextid from %s where seq_name = '%s'", $this->Seq_Table, $seq_name);
            $id = @mysqli_query($this->Link_ID, $q);
            $res = @mysqli_fetch_array($id);

            /* No current value, make one */
            if (!is_array($res)) {
                $currentid = 0;
                $q = sprintf("insert into %s values('%s', %s)", $this->Seq_Table, $seq_name, $currentid);
                $id = @mysqli_query($this->Link_ID, $q);
            } else {
                $currentid = $res['nextid'];
            }
            $nextid = $currentid + 1;
            $q = sprintf("update %s set nextid = '%s' where seq_name = '%s'", $this->Seq_Table, $nextid, $seq_name);
            $id = @mysqli_query($this->Link_ID, $q);
            $this->unlock();
        } else {
            $this->halt('cannot lock '.$this->Seq_Table.' - has it been created?');

            return 0;
        }

        return $nextid;
    }

    /* public: return table metadata */
    public function metadata($table = '', $full = false)
    {
        $count = 0;
        $id = 0;
        $res = array();
        if ($table) {
            $this->connect();
            $id = @mysqli_list_fields($this->Database, $table);
            if (!$id) {
                $this->halt('Metadata query failed.');
            }
        } else {
            $id = $this->Query_ID;
            if (!$id) {
                $this->halt('No query specified.');
            }
        }

        $count = @mysqli_num_fields($id);

        // made this IF due to performance (one if is faster than $count if's)
        if (!$full) {
            for ($i = 0; $i < $count; ++$i) {
                $res[$i]['table'] = @mysqli_field_table($id, $i);
                $res[$i]['name'] = @mysqli_field_name($id, $i);
                $res[$i]['type'] = @mysqli_field_type($id, $i);
                $res[$i]['len'] = @mysqli_field_len($id, $i);
                $res[$i]['flags'] = @mysqli_field_flags($id, $i);
            }
        } else { // full
            $res['num_fields'] = $count;

            for ($i = 0; $i < $count; ++$i) {
                $res[$i]['table'] = @mysqli_field_table($id, $i);
                $res[$i]['name'] = @mysqli_field_name($id, $i);
                $res[$i]['type'] = @mysqli_field_type($id, $i);
                $res[$i]['len'] = @mysqli_field_len($id, $i);
                $res[$i]['flags'] = @mysqli_field_flags($id, $i);
                $res['meta'][$res[$i]['name']] = $i;
            }
        }

        // free the result only if we were called on a table
        if ($table) {
            @mysqli_free_result($id);
        }

        return $res;
    }

    /* private: error handling */
    public function halt($msg, $tracemsg = '')
    {
        $this->Error = @mysqli_error($this->Link_ID);
        $this->Errno = @mysqli_errno($this->Link_ID);
        if ($this->Halt_On_Error == 'no') {
            return;
        }

        $this->haltmsg($msg, $tracemsg);

        if ($this->Halt_On_Error != 'report') {
            die('Session halted, please retry!<br><a href=javascript:history.go(-1)>Go Back</a>');
        }
    }

    public function haltmsg($msg, $othermsg = '')
    {
        $othermsgstring = '';
        if (is_array($othermsg)) {
            foreach ($othermsg as $key => $value) {
                $othermsgstring .= ' ' . $key  . ' - ' . implode(' , ', $value);
            }
        }
        //mail('rafi@hfza.ae, atif.majeed@hfza.ae, mkashif.latif@hfza.ae', 'You have an error in query'.APPLICATION_URL_MAIN, $msg.$othermsgstring);
   
		    printf("<b>Error</b>: %s (%s)<br>\n".$msg, $this->Errno, ' You have an error in query');
        
		return $this->Errno;
    }

    public function table_names()
    {
        $this->query('SHOW TABLES');
        $i = 0;
        while ($info = mysqli_fetch_row($this->Query_ID)) {
            $return[$i]['table_name'] = $info[0];
            $return[$i]['tablespace_name'] = $this->Database;
            $return[$i]['database'] = $this->Database;
            ++$i;
        }

        return $return;
    }

    /**
     * @Function						EncodeString()
     * @Purpose    						This function is used for encoding any kind of string
     * @Author   	  					Shehzad Asghar Saddiq
     * @Creation Date    				13th May , 2010
     * @Aurguments						Plain Text(String)
     * @Return Type						Encoded Encoded(String)
     **/
    public function EncodeString($Text)
    {
        $Text = base64_encode($Text);
        $Text = base64_encode($Text);

        return $Text;
    }

    /**
     * @Function						DecodeString()
     * @Purpose    						This function is used for decoding the string
     * @Author   	  					Shehzad Asghar Saddiq
     * @Creation Date    				13th May , 2010
     * @Aurguments						Plain (String)
     * @Return Type						Encoded (String)
     **/
    public function DecodeString($Text)
    {
        $Text = base64_decode($Text);
        $Text = base64_decode($Text);

        return $Text;
    }
	
	private $Query;
			//$Query
			function setQuery($Query)
			{
				$this->Query=$Query;
			}
			function GetQuery()
			{
				return $this->Query;
			}
			
			
			
				function GetRecordDataObject()
			{
				$resultset=$this->query($this->Query);
				$count=mysqli_num_fields($resultset);
				$i=0;
				while($this->next_Record())
				{
					while($i<$count)
					{
						$fieldName = mysqli_fetch_field_direct($resultset, $i)->name;
						$RecordDataObject[$fieldName]=$this->f($i);
						$i++;
					}
				}
				return $RecordDataObject;
			}
			

    /**
     * @Function							DecodeString()
     * @Purpose    						This function is used for decoding the string
     * @Author   	  					Shehzad Asghar Saddiq
     * @Creation Date    				13th May , 2010
     * @Aurguments						Plain (String)
     * @Return Type						Encoded (String)
     */
    public function getAlphanumOnly($val)
    {
        $alphaStr = preg_replace('/[^a-zA-Z0-9 ]+/', ' ', $val);

        return $alphaStr;
    }
    public function GetAlphaNumberOnly($val)
    {
        $alphaStr = preg_replace('/[^a-zA-Z0-9]+/', '', $val);

        return $alphaStr;
    }

    public function dbEscapeString($string)
    {
        if ($this->Link_ID) {
            return mysqli_real_escape_string($this->Link_ID, $string);
        } else {
            $this->connect();
            return mysqli_real_escape_string($this->Link_ID, $string);
        }
    }
}
