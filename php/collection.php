<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1931230     2020-04-26   create the class and 4 public methods(add, remove, get, count)

#create a class
Class collection
{
    #create an array to store tep data
    public $items = array();
    
    #create method add to add item with primary key to array
    public function add($primary_key, $item) 
    {
        #add item to array
        $this->items[$primary_key] = $item;     
    }
    
    #create method add to add item with primary key to array
    public function remove($primary_key) 
    {
        #if item with this primary key exist then
        if(isset($this->items[$primary_key]))
        {
            #remove the item from array
            unset($this->items[$primary_key]);
        }
    }
    
    #create method add to add item with primary key to array
    public function get($primary_key) 
    {
        #if item with this primary key exist then
        if(isset($this->items[$primary_key]))
        {
            #display the item from array
            return($this->items[$primary_key]);
        }
    }
    
    #create method add to add item with primary key to array
    public function count() 
    {
        #count all the iteam in the array
        return count($this->items); 
    }
    
}

