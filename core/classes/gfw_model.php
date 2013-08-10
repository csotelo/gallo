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
 * $Id: model.php 16 2009-09-13 05:42:28Z krlosaqp $
 */

class GfwModel
{
    var $_table = FALSE;
    var $__connection = FALSE;
    
	public function __construct()
	{
		global $config;
		$this->__connection = new GfwConnection ($config['driver'], 
                                              $config['database'], 
                                              $config['username'], 
                                              $config['userpass'], 
                                              $config['hostname']);
        
	}
	
	public function __destruct() {
        
    }
	
	public function query ($string) {
        $this->__connection->execute ($string);
    }
	
	public function find ($type = 'all', $options) {
        $sql = "SELECT ";
        if(array_key_exists('fields', $options)) {
            $sql .= $this->_generateFieldString ($options['fields']);   
        } else {
        	$sql .= '*';
        }
        $sql .= ' FROM ' . $this->_table;
        if(array_key_exists('where', $options)) {
            $sql .= $this->_generateWhereString ($options['where']);
        }
        if(array_key_exists('order', $options)) {
            $sql .= $this->_generateOrderString ($options['order']);
        }
        if ($type == 'first') {
            $sql .= ' LIMIT 0,1';
            $sql .= ';';
            $this->query($sql);
            $list = $this->__connection->fetch();
            if (count($list) == 1) {
            	return $list[0];
            } else {
            	return FALSE; 
            }
            
        }
		if(array_key_exists('limit', $options)) {
            $sql .= " LIMIT {$options['limit'][0]}, {$options['limit'][1]} ";
        }
        $sql .= ';';
        $this->query($sql);
        return $this->__connection->fetch();
    }
    
    function find_first($options) {
        return $this->find('first', $options);
    }

    function find_all($options) {
        return $this->find('all', $options);
    }

    function find_id($id) {
        if ($id == NULL) {
            return NULL;
        }
        return $this->find('first', array('where'=>array('id'=>$id)));
    }

	public function read ($id, $options)
	{
        if ($id == NULL) {
            return NULL;
        }
        return $this->find('first', array('where'=>array('id'=>$id)));
    }
	
	public function update ($id, $data) {
        return $this->query($this->_generateUpdateString($id, $data));
    }
	
	public function safeField ($options)
	{}
	
	public function save ($data) {
		return $this->query($this->_generateSaveString($data));
    }
	
	public function delete ($id) {
        return $this->query("DELETE FROM $this->_table WHERE id = $id");
    }

	protected function _generateFieldString ($sequence) {
        $tmp = array ();
        foreach ($sequence as $field){
            $tmp[] = $this->__connection->escapeString($field);
        }
        return implode(",", $tmp);
    }
	
	protected function _generateWhereString ($sequence) {
        $tmp = array();
        foreach ($sequence as $key=>$value) {
                if (!is_array($value)) {
                    $tmp[] .= "$key = '$value' ";
                } else {
                    $tmp[] .= "$key in ('".implode("', '", $value)."')";
                }
        }
        return ' WHERE ' . implode (' AND ', $tmp);
    }
	
	protected function _generateOrderString ($sequence) {
        $tmp = array ();
        foreach ($sequence as $key=>$value) {
                $tmp[] = "`$key` $value";
        }
        return ' ORDER BY ' . implode (', ', $tmp);
    }
	
	protected function _generateSaveString ($sequence) {
		$fields = array ();
		$values = array ();
		foreach ($sequence as $field => $value) {
			$fields[] = $field;
			$values[] = $value; 
		}
		$fields[] = 'created';
		$fields[] = 'modified';
		$values[] = date("Y-m-d h:i:s");
		$values[] = date("Y-m-d h:i:s");
		return sprintf("INSERT INTO {$this->_table} (`%s`) VALUES ('%s');", implode("`, `", $fields), implode("', '", $values));
    }
	
	protected function _generateUpdateString ($id, $sequence) {
		$values = array ();
		foreach ($sequence as $field => $value) {
			$values[] = sprintf ("`%s` = '%s'", $field, $value); 
		}
		$values[] = sprintf ("`%s` = '%s'", 'modified', date("Y-m-d h:i:s"));
		return sprintf("UPDATE {$this->_table} SET %s WHERE id=%s;", implode(", ", $values), $id); 
    }
    
    protected function _generateListResults ($result) {
        $rows = array();
        while ($row = mysql_fetch_object($result)){
            $rows[] = $row;
        }
        return $rows;
    }
}