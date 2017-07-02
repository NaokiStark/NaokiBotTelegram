<?php

class Requests{

	public $cookies;
	var $c;

	public function Requests(){
		$this->cookies= getcwd().'/cookie_clever.cookie';
		if (file_exists($this->cookies)) { unlink ($this->cookies); }
	}

	public function postRequest($url,$params){
		$this->c = curl_init();
		$toSend='';

		foreach ($params as $key => $value) {
			$toSend.=$key.'='.$value.'&';
		}

		$toSend=rtrim($toSend);
		
		curl_setopt($this->c,CURLOPT_URL, $url);
		curl_setopt($this->c,CURLOPT_POST , 1);
		curl_setopt($this->c,CURLOPT_POSTFIELDS, $toSend);
		curl_setopt($this->c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->c, CURLOPT_USERAGENT, 'NikuBot/1.1');
		curl_setopt($this->c, CURLOPT_SSL_VERIFYPEER , false);
		$result = curl_exec($this->c);
	
		if(!$result){
			$err = curl_error($this->c);
			curl_close($this->c); 
			return $err;
		}


		curl_close($this->c);
		return $result;
	}

	public function getRequest($url){
		$this->c = curl_init();/*
		curl_setopt($this->c, CURLOPT_COOKIEJAR, $this->cookies);
		curl_setopt($this->c, CURLOPT_COOKIEFILE, $this->cookies);*/
		curl_setopt($this->c, CURLOPT_URL, $url);
		curl_setopt($this->c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->c, CURLOPT_TIMEOUT, 30);
		//curl_setopt($this->c, CURLOPT_REFERER, "https://www.google.com.ar/");
		curl_setopt($this->c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36 OPR/30.0.1835.59');
		curl_setopt($this->c, CURLOPT_SSL_VERIFYPEER , false);
		$result = curl_exec($this->c);
		if(!$result)
			return curl_error($this->c).'get: '.$url;
		curl_close($this->c);
		return $result;
	}

	public function UploadFile($url, $params, $filename, $paramForFilename){


		$cfile = curl_file_create($filename); //Add File

		$params[$paramForFilename] = $cfile;

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'NikuBot/1.1');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);

        $data = curl_exec ($ch);
        curl_close($ch);

        return $data;

	}

	public function DownloadFile($url, $fileName, $method = "GET"){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, str_replace(" ", '%20', $url));
	    //curl_setopt($ch, CURLOPT_URL, $url);


	    if(strtolower($method) == "post"){
	    	curl_setopt($ch, CURLOPT_POST, true);

		    $toSend='';

			foreach ($params as $key => $value) {
				$toSend.=$key.'='.$value.'&';
			}

			$toSend=rtrim($toSend);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	    }

	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.75 Safari/537.36 OPR/42.0.2393.85');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $data = curl_exec ($ch);
	    $error = curl_error($ch); 
	    
	    curl_close ($ch);

	    $destination = $fileName;
	    $file = fopen($destination, "w+");
	    fputs($file, $data);
	    fclose($file);
	}
}

?>