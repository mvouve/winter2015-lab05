<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
	$this->data['pagebody'] = 'justone';    // this is the view we want shown
	$choice = rand(1,$this->quotes->size());
        $quote = $this->quotes->get($choice);
        $this->data['average'] =
            ($quote->vote_count > 0) ?
            ($quote->vote_total / $quote->vote_count) : 0;
        $this->data = array_merge($this->data, (array) $this->quotes->get($choice)); 
        $this->caboose->needed('jrating','hollywood');
	$this->render();
    }

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */