<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Marc
 */
class Admin extends Application 
{

    function __construct() 
    {
        parent::__construct();
        $this->load->helper('formfields');
    }

    function index() 
    {
        $this->data['title'] = 'Quotations Maintenance';
        $this->data['quotes'] = $this->quotes->all();
        $this->data['pagebody'] = 'admin_list';
        $this->render();
    }
    
    function add()
    {
        $quote = $this->quotes->create();
        $this->present($quote);
    }
    
    function present($quote) 
    {
        $message = '';
        if (count($this->errors) > 0) {
            foreach ($this->errors as $booboo)
            $message .= $booboo . BR;
        } 
        $this->data['message'] = $message;
        $this->data['fid'] = makeTextField('ID#', 'id', $quote->id, "Unique quote identifier, system-assigned",10,10,true); 
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
        $this->data['pagebody'] = 'quote_edit';
        $this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click here to validate the quotation data", 'btn-success'); 
        $this->render();  
    }
    
    function confirm() 
    {
        $record = $this->quotes->create();
        $record->id = $this->input->post('id');
        $record->who = $this->input->post('who');
        $record->mug = $this->input->post('mug');
        // Extract submitted fields
        $record->what = $this->input->post('what');
        
        if (empty($record->who))
            $this->errors[] = 'You must specify an author.';
        if (strlen($record->what) < 20)
            $this->errors[] = 'A quotation must be at least 20 characters long.';
        
        if (count($this->errors) > 0) {
            $this->present($record);
            return; 
        }
        
        if (empty($record->id)) 
            $this->quotes->add($record);
        else 
            $this->quotes->update($record);
        

        redirect('/admin');
    } 

}