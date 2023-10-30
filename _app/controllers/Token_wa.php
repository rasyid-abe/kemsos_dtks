<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_wa extends Backend_Controller {

	// function update_token_wa() {
    //     $data = ['username' => 'ronal' , 'password' => 'ronal123'];
    //     $ch   = curl_init();
        
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  
    //     curl_setopt($ch, CURLOPT_URL, "http://202.157.177.157/api/client/auth/login");          
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 		'Content-Type: application/json',
	// 		'Content-Length: ' . strlen(json_encode($data))
	// 	));        
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
    //     $output = curl_exec($ch);
        
    //     curl_close($ch);
        
    //     $result = json_decode($output, true);
	// 	$token  = $result['_token_'];
		
	// 	$upd_data = [
	// 		'token' => $token
	// 	];
    //     $update = $this->db->update('_token_wa', $upd_data);

    //     $this->session->set_flashdata('tab', 'wa');
	// 	if ($update) {
	// 		$this->session->set_flashdata('status', '1');
	// 		return redirect('config/user');
	// 	} else {
	// 		$this->session->set_flashdata('status', '2');
	// 		return redirect('config/user');
	// 	}
    // }

    function token_wa_post() {
        $data = ['username' => 'ronal' , 'password' => 'ronal123'];
        $ch   = curl_init();
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  
        curl_setopt($ch, CURLOPT_URL, "http://202.157.177.157/api/client/auth/login");          
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen(json_encode($data))
		));        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($ch);
        
        curl_close($ch);
        
        $result = json_decode($output, true);
		$token  = $result['_token_'];
		
		$upd_data = [
			'token' => $token
		];
        $update = $this->db->update('_token_wa', $upd_data);
        
        echo json_encode($update);           
    }
}