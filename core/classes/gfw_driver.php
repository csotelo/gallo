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
 * $Id: so_driver.php 16 2009-09-13 05:42:28Z krlosaqp $
 */
abstract class GfwDriver
{
	/**
	 * Database hostname 
	 * @var string
	 */
	protected $_hostname;
	
	/**
	 * Database user name
	 * @var string
	 */
	protected $_username;
	
	/**
	 * Database password
	 * @var string
	 */
	protected $_password;
	
	/**
	 * Database name
	 * @var string
	 */
	protected $_database;
	
	/**
	 * Database connection status
	 * true => Connected
	 * false => No connected
	 * @var boolean
	 */
	protected $_status;
	
	/**
	 * Link to the connected database
	 * @var resource
	 */
	protected $_link;
	
	/**
	 * Store for the select query string
	 * @var resource
	 */
	protected $_result;
	
	/**
	 * Open a new database connection
	 * When the database connection is done, the method returns 
	 * true, when it doen't do the connectin, the methos returns
	 * false. 
	 * 
	 * @return integer status
	 */
	public abstract function open ();
	
	/**
	 * Close an opened connection
	 * @return unknown_type
	 */
	public abstract function close ();
	
	/**
	 * Execute an sql string into a opened database connection
	 * and returns true if the query was executed
	 * @param $query the sql string
	 * @return boolean 
	 */
	public abstract function execute ($query);
	
	/**
	 * Fech data froma  select query executed and fetch it
	 * into an array, returning this array result
	 * @return array
	 */
	public abstract function fetch ();
	
	/**
	 * Returns the id for the last inserted item into de database
	 * on a table with autonumeric id
	 * @return integer
	 */
	public abstract function id ();
	
	/**
	 * Returns the rows number affected after a update or delete
	 * query execution
	 * @return integer
	 */
	public abstract function rows ();
	
	/**
	 * Returns string cleaned value from a values for avoiding
	 * sql injection
	 * @param $string
	 * @return string
	 */
	public abstract function escapeString ($string);
	
	/**
	 * 
	 * @param $databse
	 * @param $username
	 * @param $password
	 * @param $hostname
	 * @param $port
	 * @return unknown_type
	 */
	protected function __construct($database = FALSE, $username = FALSE, $password = FALSE, $hostname = FALSE, $port = FALSE)
	{
		try
		{
			$this->_initAttributes();
			($database) ? $this->_database = $database : $this->_database = FALSE;
			($username) ? $this->_username = $username : $this->_username = FALSE;
			($password) ? $this->_password = $password : $this->_password = FALSE;
			($hostname) ? $this->_hostname = $hostname : $this->_hostname = FALSE;
			($port) ? $this->_port = $port : $this->_port = FALSE;
			if (!$this->_status)
			{
				$this->open();
			}
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	protected function __destruct()
	{
		try
		{
			if ($this->_status)
			{
				return $this->close();				
			}
			else
			{
				return FALSE;
			} 
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
	
	protected function _initAttributes()
	{
		try
		{
			$this->_hostname = NULL;
			$this->_username = NULL;
			$this->_password = NULL;
			$this->_database = NULL;
			$this->_port = NULL;
			$this->_status = FALSE;
			$this->_link = NULL;
			$this->_result = NULL;
			return true;
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
}