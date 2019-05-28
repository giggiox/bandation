<?php

use PHPMailer\PHPMailer\PHPMailer;
class Google {

    static $gmaps_key = "*********";
    static $public_recaptcha_key = "****";
    private static $secret_recaptcha_key = "*********";

    static function ValidatePlace($place) {
        $place = str_replace(' ', '', $place); //geocode accetta solo address senza spazi
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$place}&key=" . self::$gmaps_key;
        $url .= "&sensor=false";

        //dd($url);
        $resp_json = file_get_contents(urldecode($url));
        $resp = json_decode($resp_json, true);

        //dd($url);

        if ($resp['status'] == 'OK') {
            $lat = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $lng = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

            if ($lat && $lng && $formatted_address) {
                $data_arr = ["lat" => $lat, "lng" => $lng, "place" => $formatted_address];
                //array_push($data_arr,["lat"=>$lat,"lng"=>$lng,"place"=>$formatted_address]);
                return $data_arr;
            }
        } else {
            return false;
        }
    }

    static function isRecaptchaValid($captcha) {
        $url="https://www.google.com/recaptcha/api/siteverify?secret=". self::$secret_recaptcha_key."&response=".$captcha;
        $verifyResponse = file_get_contents($url);
        $responseData = json_decode($verifyResponse);
        return $responseData->success;
    }

}

class Mail {

    static $sender = "luigi.cennini@libero.it";
    static $host = "smtp.mailtrap.io";
    static $username = "853c9a0c2e6da7";
    static $password = "5a4790621723eb";
    
    //aruba credentials
    /*
    static $sender="info@bandation.it";
    static $host="smtps.aruba.it";
    static $username="postmaster@bandation.it";
    static $password="";
     */
    

    static function send($from, $to, $message, $subject = null) {
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer;


        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = Mail::$host;
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = false;
        $mail->Username = Mail::$username;
        $mail->Password = Mail::$password;



        $mail->setFrom($from);
        $mail->addAddress($to);

        $mail->isHTML(true);


        //$mail->Subject = 'Here is the subject';
        if (!is_null($subject))
            $mail->Subject = $subject;

        $mail->Body = $message;

        if (!$mail->send()) {
            return False;
        } else {
            return True;
        }
        
        
        //aruba config
        /*
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;


        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = Mail::$host;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = Mail::$username;
        $mail->Password = Mail::$password;

        $mail->setFrom($from);
        $mail->addAddress($to);

        $mail->isHTML(true);

        if (!is_null($subject))
            $mail->Subject = $subject;

        $mail->Body = $message;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



        if (!$mail->send()) {
            return False;
        } else {
            return True;
        }
        */
        
        
    }

}

class MySqlProvider {

    private static $host = '127.0.0.1';
    private static $username = 'root';
    private static $passwd = '';
    private static $dbname = 'maturita_1';

    static function Connect() {
        return new mysqli(self::$host, self::$username, self::$passwd, self::$dbname);
    }

}

class User implements JsonSerializable {

    private $id;
    private $nickname;
    private $name;
    private $surname;
    private $born_date;
    private $email;
    private $password;
    private $remember_token;
    private $verify_token;
    private $status;
    private $lat;
    private $lng;
    private $place;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $nickname = 'n/d', $name = 'n/d', $surname = 'n/d', $born_date = 'n/d', $email = 'n/d', $password = 'n/d', $remember_token = 'n/d', $verify_token = 'n/d', $status = -1, $lat = -1, $lng = -1, $place = 'n/d', $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->name = $name;
        $this->surname = $surname;
        $this->born_date = $born_date;
        $this->email = $email;
        $this->password = $password;
        $this->remember_token = $remember_token;
        $this->verify_token = $verify_token;
        $this->status = $status;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->place = $place;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetNickname() {
        return $this->nickname;
    }

    function GetName() {
        return $this->name;
    }

    function GetSurname() {
        return $this->surname;
    }

    function GetBorn_date() {
        return $this->born_date;
    }

    function GetEmail() {
        return $this->email;
    }

    function GetPassword() {
        return $this->password;
    }

    function GetRemember_token() {
        return $this->remember_token;
    }

    function GetVerify_token() {
        return $this->verify_token;
    }

    function GetStatus() {
        return $this->status;
    }

    function GetLat() {
        return $this->lat;
    }

    function GetLng() {
        return $this->lng;
    }

    function GetPlace() {
        return $this->place;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetNickname($value) {
        return $this->nickname = $value;
    }

    function SetName($value) {
        return $this->name = $value;
    }

    function SetSurname($value) {
        return $this->surname = $value;
    }

    function SetBorn_date($value) {
        return $this->born_date = $value;
    }

    function SetEmail($value) {
        return $this->email = $value;
    }

    function SetPassword($value) {
        return $this->password = $value;
    }

    function SetRemember_token($value) {
        return $this->remember_token = $value;
    }

    function SetVerify_token($value) {
        return $this->verify_token = $value;
    }

    function SetStatus($value) {
        return $this->status = $value;
    }

    function SetLat($value) {
        return $this->lat = $value;
    }

    function SetLng($value) {
        return $this->lng = $value;
    }

    function SetPlace($value) {
        return $this->place = $value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class userCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class UserProvider {

    private static function fillrecord($row) {
        return new User($row['id'], $row['nickname'], $row['name'], $row['surname'], $row['born_date'], $row['email'], $row['password'], $row["remember_token"], $row['verify_token'], $row['status'], $row['lat'], $row['lng'], $row['place'], $row['created_at'], $row['updated_at']);
    }

    static function Login($email, $password, $remember_me = false) {
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM users where email ='$email' AND status=1";
        $result = $link->query($query);
        if ($result->num_rows > 0) {
            $user = self::FillRecord($result->fetch_array());
            if (password_verify($password, $user->GetPassword())) {
                if ($remember_me) {
                    self::SetRememberMeCookies($user);
                }
                return $user;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /*
     * chiamata quando si esegue il login(solo con spunta remember me)
     * setta i cookie (remember_id,remember_token) e mette l'hash(sha256) del token nel db
     */

    private static function SetRememberMeCookies($user) {
        $_COOKIE["user_id"] = $user->GetId();
        setcookie("remember_id", $user->GetId(), time() + 3600, "/");
        $token = bin2hex(random_bytes(30));
        $hashed_token = hash('sha256', $token); //da salvare nel db
        setcookie("remember_token", $token, time() + 3600, "/");

        //9f219be7fdef76d4d85ace164494b9326d5fd5a6835f8a1c659b4300013a
        //
        $link = MySqlProvider::Connect();
        $id = $user->GetId();
        $query = "UPDATE users SET remember_token='$hashed_token' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

    /*
     * uso questo metodo come "middlewere" dove all'inizio di ogni pagina lo chiamo per vedere se ci sono i cookie
     * 
     */

    static function CheckRememberMe() {
        if (!isset($_SESSION["user"]) && isset($_COOKIE["remember_id"])) {
            $id = $_COOKIE["remember_id"];
            $token = $_COOKIE["remember_token"];

            $link = MySqlProvider::Connect();
            $hashed_token = hash('sha256', $token);
            $query = "SELECT * FROM users where id ='$id' AND remember_token='$hashed_token'";
            $result = $link->query($query);
            if ($result->num_rows > 0) {
                $user = self::FillRecord($result->fetch_array());
                $_SESSION["user"] = $user;
            } else {
                return FALSE;
            }
        }
    }

    static function Logout() {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            if (isset($_COOKIE["remember_id"]) && isset($_COOKIE["remember_token"])) {
                unset($_COOKIE['remember_id']);
                unset($_COOKIE['remember_token']);
                setcookie("remember_id", null, -1, '/');
                setcookie("remember_token", null, -1, '/');
            }
        }
    }

    /*
     * verifica che l'user ha ricevuto la mail e ha cliccato su verifica, viene fatto l'update dlla tabella users mettendo status = 1 
     * 
     */

    static function VerifyUser($email, $verifyToken) {
        $link = MySqlProvider::Connect();
        //$query = "SELECT * FROM users where email ='$email' and verify_token='$verifyToken'";
        $query = "UPDATE users SET status=1,verify_token=NULL WHERE email='$email' AND verify_token='$verifyToken'";
        $result = $link->query($query);
        if ($link->affected_rows != 1) {
            return False;
        } else {
            return True;
        }
    }

    static function Register($obj) {
        $link = MySqlProvider::Connect();
        $nickname = $obj->GetNickname();
        $name = $obj->GetName();
        $surname = $obj->GetSurname();
        $born_date = $obj->GetBorn_date();
        $email = $obj->GetEmail();
        $password = password_hash($obj->GetPassword(), PASSWORD_DEFAULT);
        $remember_token = $obj->GetRemember_token();
        $verify_token = $obj->GetVerify_token();
        $status = $obj->GetStatus();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $place = $obj->GetPlace();

        $query = "INSERT INTO users(nickname,name,surname,born_date,email,password,remember_token,verify_token,status,lat,lng,place) VALUES('$nickname','$name','$surname','$born_date','$email','$password','$remember_token','$verify_token','$status','$lat','$lng','$place')";
        $link->query($query);
        return $link->insert_id;
    }

    static function CheckUniqueEmail($email) {
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $link->query($query);
        if ($result->num_rows == 0) {
            return True;
        }
        return False;
    }

    static function UpdateUserPasswordByMail($email, $password) {
        $link = MySqlProvider::Connect();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password='$password' WHERE email='$email'";
        $link->query($query);
        return true;
    }

    static function RetriveGroupAccepted($user) {
        $link = MySqlProvider::Connect();
        $id = $user->GetId();
        $list = new groupCollection();
        $query = "SELECT groups.* FROM groups inner join group_user on groups.id=group_user.group_id where group_user.user_id = '$id' and group_user.privilege in('creator','accepted') ";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(GroupProvider::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }
    
    static function GetGroupCreator($group){
        $link = MySqlProvider::Connect();
        $gid = $group->GetId();

        $query = "select users.*  
                from groups  
                    inner join users on users.id = groups.creator_id 
                where groups.id='$gid'";
        $list = new userCollection();
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            return self::fillrecord($row);
        }
        return false;
        
        
    }

    static function GetUsersAccepted($group) {
        $link = MySqlProvider::Connect();
        $gid = $group->GetId();

        $query = "select users.*
                from users 
                    inner join group_user on users.id=group_user.user_id
                where group_user.group_id='$gid' and group_user.privilege in('creator','accepted')";
        $list = new userCollection();
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function GetUsersRequests($group) {
        $link = MySqlProvider::Connect();
        $gid = $group->GetId();
        $query = "select users.*
                from users 
                    inner join group_user on users.id=group_user.user_id
                where group_user.group_id='$gid' and group_user.privilege in('request')";
        $list = new userCollection();
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function GetUserPrivilege($group, $user) {
        $link = MySqlProvider::Connect();
        $gid = $group->GetId();
        $uid = $user->GetId();
        $query = "select group_user.privilege 
                from users 
                    inner join group_user on users.id=group_user.user_id
                where group_user.group_id='$gid' and group_user.user_id='$uid'";
        $result = $link->query($query);
        $row = $result->fetch_array();
        $result->close();
        $link->close();
        return $row["privilege"];
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new userCollection();
        $query = "SELECT * FROM users";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM users WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function RetriveEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM users WHERE id= '$pk'";
        $ok = $link->query($query);
        $user = null;
        while ($row = $ok->fetch_array()) {
            $user = self::fillrecord($row);
        }
        $link->close();
        return $user;
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $nickname = $obj->GetNickname();
        $name = $obj->GetName();
        $surname = $obj->GetSurname();
        $born_date = $obj->GetBorn_date();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $place = $obj->GetPlace();
        $query = "UPDATE users SET nickname='$nickname',name='$name',surname='$surname',born_date='$born_date',lat='$lat',lng='$lng',place='$place' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }
    
    
    static function GetUserByMail($email){
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM users where email ='$email'";
        $result = $link->query($query);
        if ($result->num_rows == 1) {
            return self::FillRecord($result->fetch_array());
        } else {
            return FALSE;
        }
        
    }
    
    
    static function GetEventCreator($event){
        $eid=$event->GetId();
        $event= EventProvider::GetEntityById($eid);
        if(!$event) return False;
        
        $group_user_id=$event->GetGroup_user()->GetId();
        //ho il guid e adesso devo trovare il group_user 
        $group_user= Group_userProvider::GetEntityByPk($group_user_id);
        if(!$group_user) return False;
        
        return new User($group_user->GetUser()->GetId());
        
        
        //con il group_user return
        
        
    }

}

class Group implements JsonSerializable {

    private $id;
    private $name;
    private $lat;
    private $lng;
    private $place;
    private $creator;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $name = 'n/d', $lat = -1, $lng = -1, $place = 'n/d',$creator=null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->place = $place;
        if($creator==null){
            $this->creator=new User();
        }else{
            $this->creator=$creator;
        }
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }
    
    function GetCreator(){
        return $this->creator;
    }

    function GetName() {
        return $this->name;
    }

    function GetLat() {
        return $this->lat;
    }

    function GetLng() {
        return $this->lng;
    }

    function GetPlace() {
        return $this->place;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetName($value) {
        return $this->name = $value;
    }

    function SetLat($value) {
        return $this->lat = $value;
    }

    function SetLng($value) {
        return $this->lng = $value;
    }

    function SetPlace($value) {
        return $this->place = $value;
    }
    
    function SetCreator($value){
        return $this->creator=$value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class groupCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class GroupProvider {

    static function fillrecord($row) {
        return new Group($row['id'], $row['name'], $row['lat'], $row['lng'], $row['place'],$row['creator_id'], $row['created_at'], $row['updated_at']);
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $name = $obj->GetName();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $place = $obj->GetPlace();
        $cid=$obj->GetCreator()->GetId();
        $query = "INSERT INTO groups(name,lat,lng,place,creator_id) VALUES('$name','$lat','$lng','$place','$cid')";
        $link->query($query);
        return $link->insert_id;
    }

    static function GetEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "SELECT *FROM groups WHERE id= '$pk'";
        $ok = $link->query($query);
        $group = null;
        while ($row = $ok->fetch_array()) {
            $group = GroupProvider::fillrecord($row);
        }
        $link->close();
        return $group;
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new groupCollection();
        $query = "SELECT * FROM groups";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(GroupProvider::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        
        
        Group_userProvider::DeleteEntityByGroupId($pk);
        $query = "DELETE FROM groups WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $name = $obj->GetName();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $place = $obj->GetPlace();
        $query = "UPDATE groups SET name='$name',lat='$lat',lng='$lng',place='$place' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

}

class G_photo implements JsonSerializable {

    private $id;
    private $path;
    private $description;
    private $group;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $path = 'n/d', $description = 'n/d', $group = null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->path = $path;
        $this->description = $description;
        if ($group == null) {
            $this->group = new Group();
        } else {
            $this->group = $group;
        }
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetPath() {
        return $this->path;
    }

    function GetDescription() {
        return $this->description;
    }

    function GetGroup() {
        return $this->group;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetPath($value) {
        return $this->path = $value;
    }

    function SetDescription($value) {
        return $this->description = $value;
    }

    function SetGroup($value) {
        return $this->group = $value;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

}

class g_photoCollection extends ArrayObject {

    private $key = 0;

    function Add($obj) {
        $key = $this->key;
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
            $this->key++;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class G_photoProvider {

    private static function fillrecord($row) {
        return new G_photo($row['id'], $row['path'], $row['description'], new Group($row['group_id']), $row['created_at'], $row['updated_at']);
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $path = $obj->GetPath();
        $description = $obj->GetDescription();
        $group = $obj->Getgroup()->GetId();
        $query = "INSERT INTO g_photos(path,description,group_id) VALUES('$path','$description','$group')";
        $link->query($query);
        return $link->insert_id;
    }

    static function DeletEntityByPathGid($path, $gid) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM g_photos WHERE path= '$path' AND group_id='$gid'";
        $ok = $link->query($query);
        $link->close();
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new g_photoCollection();
        $query = "SELECT * FROM g_photos";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function RetriveListForGroup($group) {
        $id = $group->GetId();
        $link = MySqlProvider::Connect();
        $list = new g_photoCollection();
        $query = "SELECT * FROM g_photos WHERE group_id = '$id'";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM g_photos WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $path = $obj->GetPath();
        $description = $obj->GetDescription();
        $group = $obj->GetGroup()->GetId();
        $query = "UPDATE g_photos SET path='$path',description='$description',group='$group' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

}

class U_photo implements JsonSerializable {

    private $id;
    private $path;
    private $description;
    private $user;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $path = 'n/d', $description = 'n/d', $user = null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->path = $path;
        $this->description = $description;
        if ($user == null) {
            $this->user = new User();
        } else {
            $this->user = $user;
        }
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetPath() {
        return $this->path;
    }

    function GetDescription() {
        return $this->description;
    }

    function GetUser() {
        return $this->user;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetPath($value) {
        return $this->path = $value;
    }

    function SetDescription($value) {
        return $this->description = $value;
    }

    function SetUser($value) {
        return $this->user = $value;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

}

class u_photoCollection extends ArrayObject {

    private $key = 0;

    function Add($obj) {
        $key = $this->key;
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
            $this->key++;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

    public function Reverse() {
        
    }

}

class U_photoProvider {

    private static function fillrecord($row) {
        return new U_photo($row['id'], $row['path'], $row['description'], new User($row['user_id']), $row['created_at'], $row['updated_at']);
    }

    static function RetriveListForUser($user) {
        $uid = $user->GetId();
        $link = MySqlProvider::Connect();
        $list = new u_photoCollection();
        $query = "SELECT * FROM u_photos WHERE user_id='$uid'";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $path = $obj->GetPath();
        $description = $obj->GetDescription();
        $user = $obj->Getuser()->GetId();
        $query = "INSERT INTO u_photos(path,description,user_id) VALUES('$path','$description','$user')";
        $link->query($query);
        return $link->insert_id;
    }

    static function RetriveEntityList() {
        $link = MySqlProvider::Connect();
        $list = new u_photoCollection();
        $query = "SELECT * FROM u_photos";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function RetriveEntityListForUser($user) {
        $user_id = $user->GetId();
        $link = MySqlProvider::Connect();
        $list = new u_photoCollection();
        $query = "SELECT * FROM u_photos WHERE user_id='$user_id'";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPathUid($path, $uid) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM u_photos WHERE path= '$path' AND user_id='$uid'";
        $ok = $link->query($query);
        $link->close();
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $path = $obj->GetPath();
        $description = $obj->GetDescription();
        $user = $obj->GetUser()->GetId();
        $query = "UPDATE u_photos SET path='$path',description='$description',user='$user' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

}

class Group_user implements JsonSerializable {

    private $id;
    private $privilege;
    private $user;
    private $group;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $privilege = -1, $user = null, $group = null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->privilege = $privilege;
        if ($user == null) {
            $this->user = new User();
        } else {
            $this->user = $user;
        }
        if ($group == null) {
            $this->group = new Group();
        } else {
            $this->group = $group;
        }
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetPrivilege() {
        return $this->privilege;
    }

    function GetUser() {
        return $this->user;
    }

    function GetGroup() {
        return $this->group;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetPrivilege($value) {
        return $this->privilege = $value;
    }

    function SetUser($value) {
        return $this->user = $value;
    }

    function SetGroup($value) {
        return $this->group = $value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class group_userCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class Group_userProvider {

    private static function fillrecord($row) {
        return new Group_user($row['id'], $row['privilege'], new User($row['user_id']), new Group($row['group_id']), $row['created_at'], $row['updated_at']);
    }

    static function RetriveEntityByUserGroup($user, $group) {
        $link = MySqlProvider::Connect();
        $uid = $user->GetId();
        $gid = $group->GetId();
        $query = "SELECT * FROM group_user WHERE user_id='$uid' AND group_id='$gid'";
        $result = $link->query($query);
        $group_user = FALSE;
        while ($row = $result->fetch_array()) {
            $group_user = self::FillRecord($row);
        }
        $result->close();
        $link->close();
        return $group_user;
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $privilege = $obj->GetPrivilege();
        $user = $obj->Getuser()->GetId();
        $group = $obj->Getgroup()->GetId();
        $query = "INSERT INTO group_user(privilege,user_id,group_id) VALUES('$privilege','$user','$group')";
        $link->query($query);
        return $link->insert_id;
    }

    static function AddUserToGroup($user, $group) {
        $link = MySqlProvider::Connect();
        $uid = $user->GetId();
        $gid = $group->GetId();
        $query = "UPDATE group_user SET privilege='accepted' WHERE user_id='$uid' AND group_id='$gid'";
        $link->query($query);
        $link->close();
    }

    static function RefuseUserToGroup($user, $group) {
        $link = MySqlProvider::Connect();
        $uid = $user->GetId();
        $gid = $group->GetId();
        $query = "UPDATE group_user SET privilege='refused' WHERE user_id='$uid' AND group_id='$gid'";
        $link->query($query);
        $link->close();
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new group_userCollection();
        $query = "SELECT * FROM group_user";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM group_user WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function GetEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM group_user WHERE id= '$pk'";
        $ok = $link->query($query);
        $group_user = null;
        while ($row = $ok->fetch_array()) {
            $group_user = self::fillrecord($row);
        }
        $link->close();
        return $group_user;
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $privilege = $obj->GetPrivilege();
        $user = $obj->GetUser()->GetId();
        $group = $obj->GetGroup()->GetId();
        $query = "UPDATE group_user SET privilege='$privilege',user='$user',group='$group' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }
    
    
    static function DeleteEntityByGroupId($gid){
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM group_user WHERE group_id= '$gid'";
        $link->query($query);
        $link->close();
    }

}

class Event implements \JsonSerializable {

    private $id;
    private $title;
    private $description;
    private $event_date;
    private $start_hour;
    private $end_hour;
    private $place;
    private $lat;
    private $lng;
    private $group_user;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $title = 'n/d', $description = 'n/d', $event_date = 'n/d', $start_hour = 'n/d', $end_hour = 'n/d', $place = 'n/d', $lat = -1, $lng = -1, $group_user = null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->event_date = $event_date;
        $this->start_hour = $start_hour;
        $this->end_hour = $end_hour;
        $this->place = $place;
        $this->lat = $lat;
        $this->lng = $lng;
        if ($group_user == null) {
            $this->group_user = new Group_user();
        } else {
            $this->group_user = $group_user;
        }


        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetTitle() {
        return $this->title;
    }

    function GetDescription() {
        return $this->description;
    }

    function GetEvent_date() {
        return $this->event_date;
    }

    function GetStart_hour() {
        return $this->start_hour;
    }

    function GetEnd_hour() {
        return $this->end_hour;
    }

    function GetPlace() {
        return $this->place;
    }

    function GetLat() {
        return $this->lat;
    }

    function GetLng() {
        return $this->lng;
    }

    function GetGroup_user() {
        return $this->group_user;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetTitle($value) {
        return $this->title = $value;
    }

    function SetDescription($value) {
        return $this->description = $value;
    }

    function SetEvent_date($value) {
        return $this->event_date = $value;
    }

    function SetStart_hour($value) {
        return $this->start_hour = $value;
    }

    function SetEnd_hour($value) {
        return $this->end_hour = $value;
    }

    function SetPlace($value) {
        return $this->place = $value;
    }

    function SetLat($value) {
        return $this->lat = $value;
    }

    function SetLng($value) {
        return $this->lng = $value;
    }

    function SetGroup_user($value) {
        return $this->group_user = $value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class eventCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class EventProvider {

    private static function fillrecord($row) {
        return new Event($row['id'], $row['title'], $row['description'], $row['event_date'], $row['start_hour'], $row['end_hour'], $row['place'], $row['lat'], $row['lng'], new Group_user($row['group_user_id']), $row['created_at'], $row['updated_at']);
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $title = $obj->GetTitle();
        $description = $obj->GetDescription();
        $event_date = $obj->GetEvent_date();
        $start_hour = $obj->GetStart_hour();
        $end_hour = $obj->GetEnd_hour();
        $place = $obj->GetPlace();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $group_user = $obj->Getgroup_user()->GetId();
        $query = "INSERT INTO events(title,description,event_date,start_hour,end_hour,place,lat,lng,group_user_id) VALUES('$title','$description','$event_date','$start_hour','$end_hour','$place','$lat','$lng','$group_user')";
        $link->query($query);
        return $link->insert_id;
    }
    
    static function GetEntityById($id){
        $query="SELECT * FROM events WHERE id='$id'";
        $link = MySqlProvider::Connect();
        $result = $link->query($query);
        $event=false;
        if($result->num_rows == 1){
            $event = self::fillrecord($result->fetch_assoc());
        }
        $result->close();
        $link->close();
        return $event;
    }

    static function RetriveEntityList() {
        $link = MySqlProvider::Connect();
        $list = new eventCollection();
        $query = "SELECT * FROM events";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM events WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $title = $obj->GetTitle();
        $description = $obj->GetDescription();
        $event_date = $obj->GetEvent_date();
        $start_hour = $obj->GetStart_hour();
        $end_hour = $obj->GetEnd_hour();
        $place = $obj->GetPlace();
        $lat = $obj->GetLat();
        $lng = $obj->GetLng();
        $query = "UPDATE events SET title='$title',description='$description',event_date='$event_date',start_hour='$start_hour',end_hour='$end_hour',place='$place',lat='$lat',lng='$lng' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

    static function RetriveListForGroup($group) {
        $gid = $group->GetId();
        $query = "SELECT events.*"
                . " from events"
                . " inner join group_user on events.group_user_id=group_user.id"
                . " where group_user.group_id = '$gid'";
        $link = MySqlProvider::Connect();
        $list = new eventCollection();
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

}

class Instrument implements JsonSerializable {

    private $id;
    private $name;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $name = 'n/d', $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetName() {
        return $this->name;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetName($value) {
        return $this->name = $value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class instrumentCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class InstrumentProvider {

    private static function fillrecord($row) {
        return new Instrument($row['id'], $row['name'], $row['created_at'], $row['updated_at']);
    }
    

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $name = $obj->GetName();
        $query = "INSERT INTO instruments(name) VALUES('$name')";
        $link->query($query);
        return $link->insert_id;
    }

    static function RetriveListForUser($user) {
        $uid = $user->GetId();
        $query = "";
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new instrumentCollection();
        $query = "SELECT * FROM instruments";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }
    
    static function GetEntityById($id){
        $link = MySqlProvider::Connect();
        $query = "SELECT * FROM instruments WHERE id='$id'";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            return self::fillrecord($row);
        }
        
    }
    

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM instruments WHERE id= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $name = $obj->GetName();
        $query = "UPDATE instruments SET name='$name' WHERE id='$id'";
        $link->query($query);
        $link->close();
    }

}

class Instrument_user implements JsonSerializable {

    private $id;
    private $start_date;
    private $note;
    private $user;
    private $instrument;
    private $created_at;
    private $updated_at;

    public function __construct($id = -1, $start_date = 'n/d', $note = 'n/d', $user = null, $instrument = null, $created_at = 'n/d', $updated_at = 'n/d') {
        $this->id = $id;
        $this->start_date = $start_date;
        $this->note = $note;
        if ($user == null) {
            $this->user = new User();
        } else {
            $this->user = $user;
        }
        if ($instrument == null) {
            $this->instrument = new Instrument();
        } else {
            $this->instrument = $instrument;
        }
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    function GetId() {
        return $this->id;
    }

    function GetStart_date() {
        return $this->start_date;
    }

    function GetNote() {
        return $this->note;
    }

    function GetUser() {
        return $this->user;
    }

    function GetInstrument() {
        return $this->instrument;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function GetUpdated_at() {
        return $this->updated_at;
    }

    function SetId($value) {
        return $this->id = $value;
    }

    function SetStart_date($value) {
        return $this->start_date = $value;
    }

    function SetNote($value) {
        return $this->note = $value;
    }

    function SetUser($value) {
        return $this->user = $value;
    }

    function SetInstrument($value) {
        return $this->instrument = $value;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

class instrument_userCollection extends ArrayObject {

    function Add($obj) {
        $key = $obj->GetId();
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class Instrument_userProvider {

    private static function fillrecord($row) {
        return new Instrument_user($row['id'], $row['start_date'], $row['note'], new User($row['user_id']), InstrumentProvider::GetEntityById($row['instrument_id']), $row['created_at'], $row['updated_at']);
    }
    

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $start_date = $obj->GetStart_date();
        $note = $obj->GetNote();
        $user = $obj->Getuser()->GetId();
        $instrument = $obj->Getinstrument()->GetId();
        $query = "INSERT INTO instrument_user(start_date,note,user_id,instrument_id) VALUES('$start_date','$note','$user','$instrument')";
        $link->query($query);
        return $link->insert_id;
    }

    static function RetriveEntityListForUser($user) {
        $link = MySqlProvider::Connect();
        $uid=$user->GetId();
        
        $list = new instrument_userCollection();
        $query = "SELECT * FROM instrument_user WHERE user_id='$uid'";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }
    
    


    
    static function DeleteEntityByIdAndUid($id,$uid) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM instrument_user WHERE id= '$id' AND user_id ='$uid'";
        $ok = $link->query($query);
        $link->close();
    }
    
    
    static function UpdateEntity($obj) {
        $link = MySqlProvider::Connect();
        $id = $obj->GetId();
        $start_date = $obj->GetStart_date();
        $note = $obj->GetNote();
        $instrument = $obj->GetInstrument()->GetId();
        $uid=$obj->GetUser()->GetId();
        //echo "$id $start_date $note $instrument $uid";
        $query = "UPDATE instrument_user SET start_date='$start_date',note='$note',instrument_id='$instrument' WHERE id='$id' and user_id='$uid'";
        $link->query($query);
        $link->close();
    }

}

class Password_reset {

    private $email;
    private $token;
    private $user;
    private $created_at;
    

    
    static $pw_reset_max_time=120; //in secondi, 1800 = 30 minuti

    function __construct($email = "n/d", $token = "n/d", $user=null,$created_at = "n/d") {
        $this->email = $email;
        $this->token = $token;
        $this->created_at = $created_at;
        if($user==null){
            $this->user=new User();
        }else{
            $this->user=$user;
        }
            
    }
    
    function GetUser(){
        return $this->user;
    }

    function GetEmail() {
        return $this->email;
    }

    function GetToken() {
        return $this->token;
    }

    function GetCreated_at() {
        return $this->created_at;
    }

    function SetEmail($value) {
        $this->email = $value;
    }

    function SetToken($value) {
        $this->token = $value;
    }

    function SetCreated_at($value) {
        return $this->created_at;
    }
    
    function SetUser($value){
        return $this->user=$value;
    }
    
    /*static function cmp($a,$b){
        return strcmp($a->GetCreated_at(), $b->GetCreated_at());
    }*/

}

class Password_resetCollection extends ArrayObject {

    private $key = 0;

    function Add($obj) {
        $key = $this->key;
        if (isset($this[$key])) {
            return FALSE;
        } else {
            $this[$key] = $obj;
            $this->key++;
        }
    }

    function ToString() {
        $tmp = '';
        foreach ($this as $item) {
            $tmp .= '$' . $item->ToString();
        }
        return substr($tmp, 1);
    }

}

class Password_resetProvider {

    private static function fillrecord($row) {
        return new Password_reset($row["email"], $row["token"],new User($row["user_id"]), $row["created_at"]);
    }

    static function AddEntity($obj) {
        $link = MySqlProvider::Connect();
        $uid=$obj->GetUser()->GetId();
        $email = $obj->GetEmail();
        $token = $obj->GetToken();
        //$created_at=$obj->GetCreated_at();
        $query = "INSERT INTO password_resets(email,token,user_id) VALUES('$email','$token','$uid')";
        $link->query($query);
        return $link->insert_id;
    }

    static function RetriveForEmailToken($email, $token) {
        //per email e token c'è un solo record
        $link = MySqlProvider::Connect();
        $time=time();
        $max_time= Password_reset::$pw_reset_max_time;
        $query = "SELECT * FROM password_resets"
                . " WHERE email='$email' AND token='$token'"
                . " AND  '$time' - UNIX_TIMESTAMP(created_at) < '$max_time'";
        $result = $link->query($query);
        while($row = $result->fetch_array()){
            $link->close();
            return  self::fillrecord($row);
        }
        $link->close();
        return False;
    }

    static function RetriveEntiryList() {
        $link = MySqlProvider::Connect();
        $list = new Password_resetCollection();
        $query = "SELECT * FROM password_resets";
        $result = $link->query($query);
        while ($row = $result->fetch_array()) {
            $list->Add(self::FillRecord($row));
        }
        $result->close();
        $link->close();
        return $list;
    }

    static function DeletEntityByPk($pk) {
        $link = MySqlProvider::Connect();
        $query = "DELETE FROM password_resets WHERE email= '$pk'";
        $ok = $link->query($query);
        $link->close();
    }

}

//echo password_hash("root", PASSWORD_DEFAULT);
//echo "<pre>", print_r(Instrument_userProvider::RetriveEntityListForUser(new User(1))),"</pre>";
?>