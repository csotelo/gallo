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
 * $Id: so_exception.php 6 2009-09-09 05:12:21Z krlosaqp $
 */

class SO_Exception extends Exception
{
	 /**
	  * Redefine the exception so message isn't optional
	  */
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}

	// custom string representation of object */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		//return $this->code;
	}
	
	public function formatedMessage ($title = 'Error') 
	{
		$message = sprintf ("
		<h2>%s</h2>
		<ul>
		<li><strong>Message:</strong> %s</li>
		<li><strong>File:</strong> %s</li>
		<li><strong>Line:</strong> %s</li>
		<li><strong>Code:</strong> %s</li>
		</ul>",
		$title, 
		$this->getMessage(), 
		$this->getFile(), 
		$this->getLine(), 
		$this->getCode());
		return $message;
	} 
}