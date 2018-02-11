<?php
if(isset($_POST['email'])) {

	// CHANGE THE TWO LINES BELOW
	$email_to = "j.jarczok@gmail.com";

	$email_subject = "Pesante - wiadomość z formularza";


	function died($error) {
		// your error code can go here
		echo "Przykro nam, znaleźliśmy błędy w formularzu.<br /><br />";
		echo $error."<br /><br />";
		echo "Wróć proszę i napraw błędy.<br /><br />";
		die();
	}

	// validation expected data exists
	if(!isset($_POST['first_name']) ||
		!isset($_POST['last_name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['telephone']) ||
		!isset($_POST['comments'])) {
		died('Przepraszamy. Wystąpił problem z formularzem.');
	}

	$first_name = $_POST['first_name']; // required
	$last_name = $_POST['last_name']; // required
	$email_from = $_POST['email']; // required
	$telephone = $_POST['telephone']; // not required
	$comments = $_POST['comments']; // required

	$error_message = "";
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
  	$error_message .= 'Błędny adres e-mail.<br />';
  }
	$string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
  	$error_message .= 'Błędne imię.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
  	$error_message .= 'Błędne nazwisko.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'Błędny komentarz.<br />';
  }
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\n\n";

	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}

	$email_message .= "Imię: ".clean_string($first_name)."\n";
	$email_message .= "Nazwisko: ".clean_string($last_name)."\n";
	$email_message .= "Email: ".clean_string($email_from)."\n";
	$email_message .= "Telefon: ".clean_string($telephone)."\n";
	$email_message .= "Wiadomość: ".clean_string($comments)."\n";


// create email headers
$headers = 'Od: '.$email_from."\r\n".
'Odpowiedz do: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
?>

<!-- place your own success html below -->

Twoja wiadomość została wysłana.

<?php
}
die();
?>
