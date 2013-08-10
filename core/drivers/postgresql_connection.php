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
 * $Id: postgresql_connection.php 6 2009-09-09 05:12:21Z krlosaqp $
 */
class PostgresqlConnection extends SO_Driver
{
	public function __construct($database)
	{
		parent::__construct();
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	public function open ()
	{
		try
		{
			$this->_link = pg_open( $this->_database );
			return true;
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

	public function close ()
	{
		try
		{
			pg_close( $this->_link );
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

	public function execute ($query)
	{
		try
		{
			$this->_result = pg_query( $query );
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

	public function fetch ()
	{
		try
		{
			$registers = array();
			while($row = pg_fetch_object  ( $this->_result ))
			{
				$registers[] = $row;
			}
			return $registers;
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

	public function id ()
	{
		try
		{
			return pg_last_insert_rowid  ( $this->_link );
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

	public function rows ()
	{
		try
		{
			return pg_num_rows  ( $this->_result );
		}
		catch ( SO_Exception $e )
		{
			echo $e;
		}
	}

}