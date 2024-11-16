# Zadatak za Backend developera

Ovaj repozitorijum sadrži refaktorisano rešenje za test zadatak namenjen backend developerima. Originalni kod je preuređen i optimizovan koristećenjem **S.O.L.I.D principa**, **objektno orijentisanog programiranja (OOP)** i **dizajn paterna**, sa ciljem poboljšanja čitljivosti, održivosti i skalabilnosti.

## Pregled

Zadatak je zahtevao refaktorisanje proceduralnog PHP koda za registraciju korisnika u čisti i robusniji sistem. Implementacija uključuje:

- Validaciju ulaznih podataka sa mogućnošću proširenja pravila.
- Decoupling (razdvajanje) baze podataka kroz **repository pattern**.
- Implementaciju **strategy pattern-a** za SQL upite.
- Simulaciju eksternih provera (npr. MaxMind detekcija prevara).
- Poštovanje najboljih sigurnosnih praksi, poput korišćenja pripremljenih upita i sanitizacije ulaza.

## Funkcionalnosti

1. **Sistem validacije**:
   - Provera obaveznih polja.
   - Validacija formata email adrese.
   - Provera jačine lozinke i njene usklađenosti.
   - Provera da li email već postoji u bazi.
   - Simulacija eksterne validacije sa MaxMind-om.

2. **Sloj za rad sa bazom podataka**:
   - Koristi **repository pattern** za apstrakciju rada sa bazom.
   - Omogućava dinamičko kreiranje SQL izraza za `SELECT`, `INSERT` i `UPDATE` upite.

3. **Primena dizajnerskih principa**:
   - **S.O.L.I.D principi**:
     - *Single Responsibility*: Svaka klasa ima tačno definisanu odgovornost.
     - *Open/Closed*: Kod je lako proširiv bez potrebe za modifikacijom postojećeg.
     - *Liskov Substitution*: Osigurana kompatibilnost izvedenih klasa.
     - *Interface Segregation*: Male i specifične interfejse.
     - *Dependency Inversion*: Visok nivo zavisi od apstrakcija, ne od konkretnih implementacija.




## Kod koji je trebalo refaktorisati

<?php
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$password2 = $_REQUEST['password2'];
if (empty($email)) {
echo json_encode([
'success' => false,
'error' => 'email'
]);
exit;
}
if
(!preg_meatch('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,
})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x
23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x
1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x
2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x
5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0
-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a
-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f
0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-
9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*
[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-
9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:
\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',$emai
l)) {
echo json_encode([
'success' => false,
'error' => 'email_format'
]);
exit;
}

if (empty($password) || mb_strlen($password) < 8) {
echo json_encode([
'success' => false,
'error' => 'password'
]);
exit;
}
if (empty($password2) || mb_strlen($password) < 8) {
echo json_encode([
'success' => false,
'error' => 'password2'
]);
exit;
}
if ($password != $password2) {
echo json_encode([
'success' => false,
'error' => 'password_mismatch'
]);
exit;
}
$link = mysqli_connect("127.0.0.1", "my_user", "my_password", "my_db");
if (!$link) {
echo json_encode([
'success' => false,
'error' => 'DB_error'
]);
exit;
}
$result = mysqli_query($link, "SELECT * FROM user WHERE email = '$email'");
if ($result && mysqli_num_rows($result)) {
echo json_encode([
'success' => false,
'error' => 'password_mismatch'
]);

exit;
}
mysqli_query($link, "INSERT INTO user SET email = '$email', password =
'$password'");
$userId = mysqli_insert_id($link);
mail($email, 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite
email adresu ...', 'adm@kupujemprodajem.com');
mysqli_query($link, "INSERT INTO user_log SET `action` = 'register', user_id =
$userId, log_time = NOW()");
$_SESSION['userId'] = $userId;
echo json_encode([
'success' => true,
'userId' => $userId
]);
?>