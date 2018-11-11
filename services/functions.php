<?php

    require_once ('multichainjson.php');
    require_once ('config.php');
    require_once ('config_mysql.php');

/* Establish the rpc-connection to the multichain  */

$multichain_conn = new Multichain($username,$password,$host,$port);


function sec_session_start() {

        //$old_session_id = session_id();

        $session_name = 'idem'; // Imposta un nome di sessione
        $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
        $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
        ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
        $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
        session_start(); // Avvia la sessione php.
        session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.

        //session_destroy($old_session_id);
}


function mysqlSaveToken($idemID, $token) {

    global $mysqlConn;
   
    try
    { 
        // ricordati di salvare il token con funzione SHA256
        $token = hash('sha512', $token);
        $stmt = $mysqlConn->prepare("INSERT INTO login_attempt (idemID, token) VALUES (:idemID, :token)");
        $stmt->bindParam(':idemID', $idemID);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

    }
    catch(PDOException $e)
    {
        
        echo "Error: Mysql error.";// COMUNICO ERRORE BLIND . $e->getMessage();
        die();

    }

}




// This function give back to the user the cyphered token and save it into the mariadb

function getCypherToken($idemID) {

   
    $token = bin2hex(openssl_random_pseudo_bytes(8));

    if($idemID == "14Sf3Q6VubB4BjbU2vukLY6hJAmnHgbGoeBngp") {
        $addressListstream = liststreamkeyitems('operators',$idemID); 
    } else {
        $addressListstream = liststreamkeyitems('people',$idemID);
    }

    $public_key = $addressListstream[0]['data']['json']['pubKey']; //file_get_contents('./1A5MAsf3Z4AxfBfU8J8HnyZFQGXfCoUp5Ba1PL.pub', true);

   
    // Encrypt using the public key
    
    openssl_public_encrypt($token, $encrypted, $public_key);

    $encrypted_64 = base64_encode($encrypted);
  
    mysqlSaveToken($idemID, $token); 


    /* TO TEST DECRIPTION     

    $private_key = file_get_contents('./<Insert-privkey-name>.priv', true);

    // Decrypt the data using the private key
    openssl_private_decrypt($encrypted, $decrypted, $private_key);


    */

    return array('encToken' => $encrypted_64);
}


// This function verify the user received token with the stored into mariadb

function matchToken($idemID, $token) {

    global $mysqlConn;
   
    try
    { 
        $token = hash('sha512', $token);
        $stmt = $mysqlConn->prepare("SELECT * FROM idem.login_attempt WHERE idemID = :idemID AND token = :token ORDER BY timestamp DESC LIMIT 1");
        $stmt->bindParam(':idemID', $idemID);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if($stmt->rowCount() == 1) {



            sec_session_start();
            $_SESSION['address'] = $idemID;
            
            return array('login' => "LOGGED");


        } else {
            echo "Error: Token not valid for this user.";
            die();
        }

    }
    catch(PDOException $e)
    {
        
        echo "Error: Mysql error.";// SEND BLIND ERROR . $e->getMessage();
        die();

    }

}



// Work in progress......

/* Returns general information about this node and blockchain. MultiChain adds some fields to Bitcoin Core’s response, giving the blockchain’s chainname, description, protocol, peer-to-peer port. There are also incomingpaused and miningpaused fields – see the pause command. The burnaddress is an address with no known private key, to which assets can be sent to make them provably unspendable. The nodeaddress can be passed to other nodes for connecting. The setupblocks field gives the length in blocks of the setup phase in which some consensus constraints are not applied.  */

function getinfo()
		{
		global $multichain_conn;
		$info = $multichain_conn->getinfo();
		return $info;
		}

/* Returns information about the other nodes to which this node is connected. If this is a MultiChain blockchain, includes handshake and handshakelocal fields showing the remote and local address used during the handshaking for that connection.  */

function peerinfo()
		{
		global $multichain_conn;
		$peerinfo = $multichain_conn->getpeerinfo();
		return $peerinfo;
		}

/* Returns information about the addresses in the wallet. all parameters are mandatory, for $arg1 provide one or more addresses (comma-delimited or as an array) to retrieve information about specific addresses only, or use * for all addresses in the wallet, for $arg2 provide verbosity an take value true or false, for $arg3 provide how many address you want to list, for $arg4 starting with negative value you can show the most recently created address.    */

function listaddresses() {

    global $multichain_conn;

    $listaddresses = $multichain_conn->listaddresses();
	
	return $listaddresses;
}

/* Returns a list of addresses in this node’s wallet. It take as argument the "true" value for more informations if not set give only the address  */

function getaddresses()
                {
                global $multichain_conn;
				if (is_null(func_get_arg(0))) {
				$myownaddress = $multichain_conn->getaddresses();
				return $myownaddress;
				} else {
				$options = func_get_arg(0);
				$myownaddress = $multichain_conn->getaddresses($options);
			return $myownaddress;
			}
		}


/* Returns a list of values of this blockchain’s parameters. Use display-names to set whether parameters are shown with display names (with hyphens) or canonical names (without hyphens). Use with-upgrades to set whether to show the chain’s latest parameters (after any upgrades) or its original parameters (in the genesis block). Note that as of MultiChain 1.0.1, only the protocol version can be upgraded.  */

function getblockchainparams()
                {
                global $multichain_conn;
                $blockchainparams = $multichain_conn->getblockchainparams();
		return $blockchainparams;
		}		

/* Returns a selection of this node’s runtime parameters, which are set when the node starts up. Some parameters can be modified while MultiChain is running using setruntimeparam.  */

function getruntimeparams()
                {
                global $multichain_conn;
                $runtimeparams = $multichain_conn->getruntimeparams();
		return $runtimeparams;
		}		


/* Returns information about address, or the address corresponding to the specified privkey private key or pubkey public key, including whether this node has the address’s private key in its wallet.  */

function validateaddress()
                {
                global $multichain_conn;
		$arg1 = func_get_arg(0);
                $validateaddress = $multichain_conn->validateaddress($arg1);
		return $validateaddress;
		}		

/* Returns a list of all permissions which have been explicitly granted to addresses. To list information about specific global permissions, set permissions to one of connect, send, receive, issue, mine, activate, admin, or a comma-separated list thereof. Omit or pass * or all to list all global permissions. For per-asset or per-stream permissions, use the form entity.issue, entity.write,admin or entity.* where entity is an asset or stream name, ref or creation txid. Provide a comma-delimited list in addresses to list the permissions for particular addresses or * for all addresses. If verbose is true, the admins output field lists the administrator/s who assigned the corresponding permission, and the pending field lists permission changes which are waiting to reach consensus.  */

function listpermissions()
                {
                global $multichain_conn;
                $listpermissions = $multichain_conn->listpermissions();
		return $listpermissions;
		}		

		
		
/* This works like liststreamitems, but listing items with the given key only. */

function liststreamkeyitems()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $liststreamkeyitems = $multichain_conn->liststreamkeyitems($arg1 , $arg2 , true);
    return $liststreamkeyitems;
}


/* Generates one or more public/private key pairs, which are not stored in the wallet or drawn from the node’s key pool, ready for external key management. For each key pair, the address, pubkey (as embedded in transaction inputs) and privkey (used for signatures) is provided. */

function createkeypairs() {
    global $multichain_conn;
    $newkeypairs = $multichain_conn->createkeypairs();
    return $newkeypairs;
}

/* Adds address (or a full public key, or an array of either) to the wallet, without an associated private key. This creates one or more watch-only addresses, whose activity and balance can be retrieved via various APIs (e.g. with the includeWatchOnly parameter), but whose funds cannot be spent by this node. The rescan parameter controls whether and how the blockchain is rescanned for transactions relating to all wallet addresses, including these new ones. Pass true to rescan the entire chain, false to skip rescanning, and from version 1.0.5, a positive integer to rescan from that block number or a negative integer to rescan that many recent blocks. Returns null if successful. */

function importaddress()
{
    global $multichain_conn;
    $arg1 = func_get_arg(0);
    $importaddress = $multichain_conn->importaddress($arg1, '', false);
    return $importaddress;
}    

/* Returns information about the node’s wallet, including the number of transactions (txcount) and unspent transaction outputs (utxocount), the pool of pregenerated keys. If the wallet has been encrypted and unlocked, it also shows when it is unlocked_until. */

function getwalletinfo()
{
    global $multichain_conn;
    $getwalletinfo = $multichain_conn->getwalletinfo();
    return $getwalletinfo;
}

/* This uses passphrase (as set in earlier calls to encryptwallet or walletpassphrasechange) to unlock the node’s wallet for signing transactions for the next timeout seconds. In a permissioned blockchain, this will also need to be called before the node can connect to other nodes or sign blocks that it has created. First argument passphrase second argument timeout in seconds */

function walletpassphrase()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $walletpassphrase = $multichain_conn->walletpassphrase($arg1, $arg2);
    
    return $walletpassphrase;
}


function grant()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $result = $multichain_conn->grant($arg1, $arg2);
    
    return $result;
}



function getaddresstransaction()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $result = $multichain_conn->grant($arg1, $arg2);
    
    return $result;
}


function publish()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $arg3 = $args[2];
    $result = $multichain_conn->publish($arg1, $arg2, $arg3);
    
    return $result;
}

function generateRSA() {


	$config = array(
	    "digest_alg" => "sha512",
	    "private_key_bits" => 2048,
	    "private_key_type" => OPENSSL_KEYTYPE_RSA,
	);
	   
	// Create the private and public key
	$res = openssl_pkey_new($config);

	// Extract the private key from $res to $privKey
	openssl_pkey_export($res, $privKey);

	// Extract the public key from $res to $pubKey
	$pubKey = openssl_pkey_get_details($res);
	$pubKey = $pubKey["key"];
	// $privKey
	$keys = [];
	$keys['priv'] = $privKey;
	$keys['pub'] = $pubKey;
	return $keys;

}

function sym_encrypt($symetric_key, $plain_text) {


    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);

    $iterations = 999;  
    $key = hash_pbkdf2("sha512", $symetric_key, $salt, $iterations, 64);

    $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));

    return base64_encode(json_encode($data));


}

function cleanRSA($key) {

	$key = substr($key, 27); // remove -----BEGIN PUBLIC KEY-----
	$key = substr($key, 0, -26); // remove -----END PUBLIC KEY-----
	
	return $key;

}

function newDrivingLicense($userAddress,$typeOfLicense,$country,$state,$expireDate,$owner) {
    global $multichain_conn;

    $drivingLicense = array(
                                'country'=>$country,
                                'state'=>$state,
                                'owner'=>$owner,
                                'expireDate'=>$expireDate
                            );

    $txId = $multichain_conn->issuemorefrom($_SESSION['address'],$userAddress,$typeOfLicense,20,0,$drivingLicense);

    return $txId;
}

function newUser($name,$surname,$birthDate,$birthPlace,$gender,$citizenship,$street,$streetNumber,$city,$state,$postalCode,$country)
{
    global $multichain_conn;

    $result = $multichain_conn->createkeypairs();
    
    $address = $result[0]['address'];
    $privkey = $result[0]['privkey'];
    $pubkey = $result[0]['pubkey'];

    $multichain_conn->importaddress($address);

// unlock wallet with password if needed
//    $multichain_conn->walletpassphrase('$walletpass','$time');

    $txIdGrant = $multichain_conn->grant($address,'receive,send');

    $getaddresstransaction = $multichain_conn->getaddresstransaction($address,$txIdGrant);



    $keysRSA = generateRSA();

    $symetric_key = base64_encode(openssl_random_pseudo_bytes(128));


	$name = sym_encrypt($symetric_key, $name);
	$surname = sym_encrypt($symetric_key, $surname);
	$birthDate = sym_encrypt($symetric_key, $birthDate);
	$birthPlace = sym_encrypt($symetric_key, $birthPlace);
	$gender = sym_encrypt($symetric_key, $gender);
	$citizenship = sym_encrypt($symetric_key, $citizenship);
	$street = sym_encrypt($symetric_key, $street);
	$streetNumber = sym_encrypt($symetric_key, $streetNumber);
	$city = sym_encrypt($symetric_key, $city);
	$state = sym_encrypt($symetric_key, $state);
	$postalCode = sym_encrypt($symetric_key, $postalCode);
	$country = sym_encrypt($symetric_key, $country);
	
    //$pubkeyClean = cleanRSA($keysRSA['pub']);
    $pubkey = $keysRSA['pub'];

	$json = array('json'=> array(
								'id'=>'did:'.$address,
								'type'=>['Identity', 'Person'],
								'name'=>$name,
								'surname'=>$surname,
								'birthDate'=>$birthDate,
								'birthPlace'=>$birthPlace,
								'gender'=>$gender,
								'citizenship'=>$citizenship,
								"address"=> array(
							    	"type"=> "PostalAddress",
								"street"=> $street,
								"streetNumber"=> $streetNumber,
							    	"city"=> $city,
							    	"state/region"=> $state,
							    	"postalCode"=> $postalCode,
							    	"country"=> $country
							   	),
							   	'pubKey'=>$pubkey
			));


	$txIdPublish = publish('people', $address, $json);

	$result = array(
			"Address"=>$address,
			"ECDSA private key"=>$privkey,
			"ECDSA public key"=>$pubkey,
			"RSA private key"=>$keysRSA['priv'],
			"RSA public key"=>$keysRSA['pub'],
			"Symetric key"=>$symetric_key
	); 
    return $result;
}






function verify_issue()
{
    global $multichain_conn;
    $args = func_get_args();
    $arg1 = 'issue';
    $arg2 = $args[0];
    $result = $multichain_conn->listpermissions($arg1, $arg2);
	if(isset($result[0]['type']) && $result[0]['type'] == "issue"){
		return TRUE;
	} else {
		return FALSE;
	}
}



function create_asset($address,$name,$country,$state,$issuer)
{

	if(verify_issue($address) == FALSE) {
		return 'This address can\'t create a new asset. Verify permissions.';
	} else {

	    global $multichain_conn;
	    
	    $json1 = array(
						"name"=>$name,
						"open"=>TRUE
		);

	    $number1 = 0;
	    $number2 = 1;
	    $number3 = 0;

		$json2 = array(
						"country"=>$country,
						"state"=>$state,
						"issuer"=>$issuer
		);

	    $result = $multichain_conn->issuefrom($address, $address, $json1, $number1, $number2, $number3, $json2);
	    
	    return $result;

	}
    
}

function issuemorefrom() {

	global $multichain_conn;

    $args = func_get_args();
    $arg1 = $args[0];
    $arg2 = $args[1];
    $arg3 = $args[2];
    $arg4 = $args[3];
    $arg5 = $args[4];
    $arg6 = $args[5];
    $result = $multichain_conn->issuemorefrom($arg1, $arg2, $arg3, $arg4, $arg5, $arg6);

	return $result;
	
}



?>
