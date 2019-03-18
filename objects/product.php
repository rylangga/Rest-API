<?php
  class product{

    private $conn;
    private $table_name = "tb_guru";

    // MENDEKLARASIKAN FIELD YANG ADA DI TABLE TB_GURU
    public $id_guru;
    public $firstname;
    public $lastname;
    public $username;
    public $password;
    public $nip;

    public function __construct($db){
      $this->conn = $db;
    }

    
    // UNTUK MEMBACA DATA
    function read(){
      // MEMILIH SEMUA QUERY
      // $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
      //           FROM " . $this->table_name . " 
      //           p LEFT JOIN categories c
      //           ON p.category_id = c.id
      //           ORDER BY p.created DESC";
   
      $query = "SELECT * FROM ". $this->table_name ." 
                ORDER BY id_guru DESC"; 
     
      // MENYIAPKAN QUERY
      $stmt = $this->conn->prepare($query);
   
      // execute query
      $stmt->execute();
   
      return $stmt;
    } 


    // MEMBUAT DATA JSON YANG TERBARU
    function create(){
 
      // $query = "INSERT INTO
      //           " . $this->table_name . "
      //           SET
      //           name=:name, price=:price, description=:description, 
      //           category_id=:category_id, created=:created";

      $query = "INSERT INTO ". $this->table_name ." 
                SET 
                firstname=:firstname,
                lastname=:lastname,
                username=:username,
                password=:password,
                nip=:nip,
                ";
   
      $stmt = $this->conn->prepare($query);
   
      // BIAR TAG SPESIAL SEPERTI &BNSP; AKAN DIEKSEKUSI
      $this->firstname=htmlspecialchars(strip_tags($this->firstname));
      $this->lastname=htmlspecialchars(strip_tags($this->lastname));
      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->nip=htmlspecialchars(strip_tags($this->nip));
   
      // BELUM TAU KEGUNAANYA
      $stmt->bindParam(":firstname", $this->firstname);
      $stmt->bindParam(":lastname", $this->lastname);
      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":nip", $this->nip);
   
      if($stmt->execute()){
          return true;
      }
   
      return false;
       
    }


    // MEMANGGIL DATA BERDASARKAN ID
    function readOne(){
      // $query = "SELECT c.name as category_name, 
      //           p.id, p.name, p.description, p.price, p.category_id, p.created
      //           FROM " . $this->table_name . " p
      //           LEFT JOIN categories c ON p.category_id = c.id
      //           WHERE p.id = ?
      //           LIMIT 1
      //           ";
  
      $query = "SELECT * FROM ". $this->table_name ."
                WHERE tb_guru.id_guru = ?
                LIMIT 1
                "; 

      $stmt = $this->conn->prepare( $query );
  
      $stmt->bindParam(1, $this->id_guru);  
  
      // MENGAMBIL DATA PADA DATABASE
      $stmt->execute();
  
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
      // MENGAMBIL NILAI YG ADA DI DATABASE UNTUK DITAMPILKAN
      $this->firstname = $row['firstname'];
      $this->lastname  = $row['lastname'];
      $this->username  = $row['username'];
      $this->password  = $row['password'];
      $this->nip       = $row['nip'];

    
    }


    // UNTUK MENGUPDATE DATA
    function update(){
              // :firstname merupakan variabel
      $query = "UPDATE " . $this->table_name . "
              SET
                firstname = :firstname,
                lastname  = :lastname,
                username  = :username,
                password  = :password
                nip       = :nip
              WHERE
                id_guru   = :id_guru";
   
      $stmt = $this->conn->prepare($query);
   
      /* SCRIPT_TAGS(), HTMLSPECIALCHARS() : 
        UNTUK MENGUBAH CODE UNIK SEPERTI &COPY; TIDAK DIEKSEKUSI */
      $this->firstname = htmlspecialchars(strip_tags($this->firstname));
      $this->lastname = htmlspecialchars(strip_tags($this->lastname));
      $this->username = htmlspecialchars(strip_tags($this->username));  
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->nip = htmlspecialchars(strip_tags($this->nip));
      $this->id_guru= htmlspecialchars(strip_tags($this->id_guru));
   
      /* :NAME, :PRICE, :DESCRIPTION ADALAH STRING
        JIKA $NAME ADALAH STRING, INT AKAN SEPERTI ":NAME, :PRICE"  
        */
      $stmt->bindParam(':firstname' , $this->firstname);
      $stmt->bindParam(':lastname'  , $this->lastname);
      $stmt->bindParam(':username'  , $this->username);
      $stmt->bindParam(':password'  , $this->password);
      $stmt->bindParam(':nip'       , $this->password);
      $stmt->bindParam(':id_guru'   , $this->id_guru);
   
      if($stmt->execute()){
          return true;
      }
      return false;
    }


    // MENGHAPUS PRODUK
    function delete(){
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
   
      $stmt = $this->conn->prepare($query);
   
      $this->id=htmlspecialchars(strip_tags($this->id));
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
          return true;
      }
      return false;
    }


  // MENCARI PRODUK
  function search($keywords){
    // BELUM TAU DIMANA DAPET C.NAME
    // ARTI HURUF C PADA CATEORIES
    // HANYA BISA MENCARI BERDASARKAN PRODUK DESKRIPSI DAN ID 
    // $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
    //           FROM
    //             " . $this->table_name . " p
    //           INNER JOIN
    //             categories c
    //           ON 
    //             p.category_id = c.id
    //           WHERE
    //             p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?  
    //           ORDER BY
    //             p.created DESC";

    //  mencari berdasarkan frstname, lastname dan username
    $query = "SELECT * FROM ". $this->table_name ." 
              WHERE tb_guru.firstname LIKE ? 
              OR tb_guru.lastname LIKE ?
              OR tb_guru.username LIKE ?
              ORDER BY id_guru DESC
              ";

      $stmt = $this->conn->prepare($query);

      $keywords = htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";

      // bind
      $stmt->bindParam(1, $keywords);
      $stmt->bindParam(2, $keywords);
      $stmt->bindParam(3, $keywords);

      $stmt->execute();

      return $stmt;
    }  
    
    
    // BELUM TAU KEGUNAAN READ_PAGGING()
    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
      // select query
      $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                " . $this->table_name . " p
                LEFT JOIN
                categories c
                ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";

      $stmt = $this->conn->prepare( $query );

      $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
      $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

      $stmt->execute();

      return $stmt;
    }


    // BELUM  TAU KEGUNAANYA
    // used for paging products
    public function count(){
      $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

      $stmt = $this->conn->prepare( $query );
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      return $row['total_rows'];
    } 
    
  }
?>