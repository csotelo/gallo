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
 * $Id: connection.php 16 2009-09-13 05:42:28Z krlosaqp $
 */

class GfwConnection
{
	public function __construct($driver, $database, $username = FALSE, $password = FALSE, $hostname = FALSE, $port = FALSE)
	{
		global $so_path;
		switch ($driver)
		{
			case "sqlite3":
				$this->driver = new SqliteConnection($database);
				break;
			case "mysql":
				$this->driver = new MysqlConnection($database, $username, $password, $hostname);
				break;
			case "pgsql":
				$this->driver = new PostgresqlConnection($database, $username, $password, $hostname);
				break;
		}
	}

	public function __destruct()
	{
		//parent::__destruct();
	}

	public function open ()
	{
		try
		{
			$this->driver->open();
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
			$this->driver->close();
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
			return $this->driver->escapeString ($string);
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
			return $this->driver->execute ($query);
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
			return $this->driver->fetch ();
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}

	public function id ()
	{
		try
		{
			return $this->driver->id ();
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}

	public function rows ()
	{
		try
		{
			return $this->driver->rows ();
		}
		catch ( Exception $e )
		{
			throw new Exception($e->getMessage());
		}
	}
}