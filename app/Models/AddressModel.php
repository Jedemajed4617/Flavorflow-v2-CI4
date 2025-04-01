<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    public function getDeliveryaddress() {
        $db = \Config\Database::connect();
        $builder = $db->table('address');
        
        $user_id = session()->get('user_id');

        // Select all fields where user_id matches and address_type is 'bezorgadres'
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $builder->where('address_type', 'bezorgadres');
        $query = $builder->get();
    
        // Convert result to an array
        $deliveryaddresses = $query->getResultArray();
    
        return $deliveryaddresses;
    }

    public function getBillingaddress(){
        $db = \Config\Database::connect();
        $builder = $db->table('address');

        $user_id = session()->get('user_id');
        
        // Select all fields where user_id matches and address_type is 'factuuradres'
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $builder->where('address_type', 'factuuradres');
        $query = $builder->get();
    
        // Convert result to an array
        $billingaddresses = $query->getResultArray();
    
        return $billingaddresses;
    }
}