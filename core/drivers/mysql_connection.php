<?php
/**
 * SQLObject is an object-relational mapper for Php5
 *
 * PhpSqlObject Copyright (C) 2009,  Carlos Eduardo Sotelo Pinto
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * $Id: mysql_connection.php 16 2009-09-13 05:42:28Z krlosaqp $
 */
class MysqlConnection extends GfwDriver
{
	/**
	 * Class constructor
	 * 
	 * @return none
	 */
	public function __construct($database, $username, $password, $hostname = '127.0.0.1', $port = '3306')
	{
		parent::__construct($database, $username, $password, $hostname, $port);
	}
	
	/**
	 * Class destructor
	 * 
	 * @return unknown_type
	 */
	public function __destruct()
	{
		parent::__destruct();
	}
	
	public function open ()
	{
		try
		{
			if (!$this->_status)
			{
				$this->_link = mysql_connect(sprintf('%s:%s', $this->_hostname, $this->_port), $this->_username, $this->_password, true);
				if ($this->_link)
				{
					$this->_status = true;
					if (mysql_select_db ($this->_database))
					{
						return $this->_status;
					}
					else
					{
						throw new Exception('MySQL Connection Database Error: ' . mysql_error());
					}
				}
				else
				{
					throw new Exception('MySQL Connection Host Error: ' . mysql_error());
				}
			}
			else
			{
				throw new Exception('MySQL Connection Error: There are an opened connection to the host');
			}
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	public function close ()
	{
		try
		{
			if ($this->_status)
			{
				mysql_close( $this->_link );
			}
			else
			{
				throw new Exception('MySQL Connection Error: There are not an opened connection to the host');
			}
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	public function escapeString ($string)
	{
		try
		{
			return mysql_real_escape_string($string, $this->_link);
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	public function execute ($query)
	{
		try
		{
			$this->_result = @mysql_query( $query );
            if ($this->_result)
			{
                return true;
			}
			else
			{
				throw new Exception('MySQL Query Execute Error: ' . mysql_error());
			}
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	public function fetch ()
	{
		try
		{
			$registers = array();
			while($row = mysql_fetch_array  ( $this->_result ))
			{
				$registers[] = $row;
			}
            return $registers;
		}
		catch ( Exception $e )
		{
			throw new Exception( 'MySQL Fetch Records Error: ' . mysql_error () );
		}
	}
	
	public function id ()
	{
		try
		{
			return mysql_last_insert_rowid  ( $this->_link );
		}
		catch ( Exception $e )
		{
			throw new Exception('MySQL Last Inserted Error: ' . mysql_error());
		}
	}
	
	public function rows ()
	{
		try
		{
			return mysql_num_rows ( $this->_result );
		}
		catch ( Exception $e )
		{
			throw new Exception('MySQL Num Rows Error: ' . mysql_error());
		}
	}

}