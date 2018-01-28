<?php

class UserContact {
		
	//Properties
	private $name;
		
	private $email;
		
	private $reason;
		
	private $comments;
		
	private $mailingList;
		
	private $productInfo;
		
	private $contactDate;
	
	private $mailMsg;
	
	private $htmlMsg;
	
	//SET Methods
	function set_name($inName)
	{
		$this->name = $inName; 
	}
	
	function set_email($inEmail)
	{
		$this->email = $inEmail; 
	}
	
	function set_reason($inReason)
	{
		$this->reason = $inReason;
	}
	
	function set_comments($inComments)
	{
		$this->comments = $inComments;
	}
	
	function set_mailingList($inMailingList)
	{
		$this->mailingList = $inMailingList;
	}
	
	function set_moreInfo($inMoreInfo)
	{
		$this->moreInfo = $inMoreInfo;
	}
	
	function set_contactDate($inContactDate)
	{
		$this->contactDate = $inContactDate;
	}

	//GET Methods
	function get_name()
	{
		return $this->name;
	}
	
	function get_email()
	{
		return $this->email;
	}
	
	function get_reason()
	{
		return $this->reason;
	}
	
	function get_comments()
	{
		return $this->comments;
	}
	
	function get_mailingList()
	{
		return $this->mailingList;
	}
	
	function get_moreInfo()
	{
		return $this->moreInfo;
	}
	
	function get_contactDate()
	{
		return $this->contactDate;
	}

	//Processing Methods
	function formatHTMLMessage()
	{
		
		$msg1 = "<p>Dear $this->name,</p><p>Thank you very much for your recent contact regarding $this->reason.</p><p>Your comment ($this->comments) is valuable to us.</p><p>We're excited to have you as part of our mailing list! You'll receive offers and information in the near future at the email address you provided for us.</p><p>For further communication, we have $this->email as your email.</p>";
		
		$msg2 = "<p>Dear $this->name,</p><p>Thank you very much for your recent contact regarding $this->reason.</p><p>Your comment ($this->comments) is valuable to us.</p><p>We're excited to have you as part of our mailing list! You'll receive offers and information in the near future at the email address you provided for us.</p><p>We appreciate your interest in recieving more information on our products, and will send you exciting news at the email address you provided for us.</p><p>For further communication, we have $this->email as your email.</p>";
		
		$msg3 = "<p>Dear $this->name,</p><p>Thank you very much for your recent contact regarding $this->reason.</p><p>Your comment ($this->comments) is valuable to us.</p><p>We appreciate your interest in recieving more information on our products, and will send you exciting news at the email address you provided for us.</p><p>For further communication, we have $this->email as your email.</p>";
				
		$msg4 = "<p>Dear $this->name,</p><p>Thank you very much for your recent contact regarding $this->reason.</p><p>Your comment ($this->comments) is valuable to us.</p><p>For further communication, we have $this->email as your email.</p>";
		
		
		if ($this->mailingList == true && $this->moreInfo == false) 
			$htmlMsg = $msg1;
			
		if ($this->mailingList == true && $this->moreInfo == true) 
			$htmlMsg = $msg2;
		
		if ($this->mailingList == false && $this->moreInfo == true) 
			$htmlMsg = $msg3;
		
		if ($this->mailingList == false && $this->moreInfo == false) 
			$htmlMsg = $msg4;
		
			return $htmlMsg;
	}
	
		function formatMailMessage()
		{
			$msg = $this->formatHTMLMessage();
			
			$mailMsg = str_replace("<p>", "\r\n", $msg);
		
			$mailMsg = str_replace("</p>", "\r\n", $mailMsg);
			
			$mailMsg = wordwrap($mailMsg, 70, "\r\n");
			
			return $mailMsg;
		}
	
	
		function sendEmail()
		{
		$emailMsg = $this->formatMailMessage();
		
		$to = $this->email;
		$subject = "UserContactClass Email";
		$message = $emailMsg;
		$from = "From: web@joekanauss.info";
		
		if (mail($to, $subject, $message, $from)) 
	{
   		echo("<p>Message successfully sent!</p>");
  	} 
	else 
	{
   		echo("<p>Message delivery failed...</p>");
  	}
		
		}
		
	


}



?>