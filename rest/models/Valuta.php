<?php
class Valuta {
    private $conn;
    private $table = 'valutnikodovi';

    public $id_valute;
    public $id_drzave;
    public $naziv_drzave;
    public $naziv_valute;
    public $kod;
    public $broj;

    // konstruktor sa bazom
    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
      // Create query
      $query =  'SELECT valutnikodovi.naziv_valute as valuta, valutnikodovi.id_valute, valutnikodovi.id_drzave,
      valutnikodovi.naziv_valute, valutnikodovi.kod, valutnikodovi.broj
      FROM '.$this->table .' LEFT JOIN drzave ON valutnikodovi.id_drzave = drzave.id_drzave';

      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute();
      return $stmt;
    }

    // Get single valuta
    public function read_single() {
        $query =  'SELECT valutnikodovi.naziv_valute as valuta, valutnikodovi.id_valute, valutnikodovi.id_drzave,
        valutnikodovi.naziv_valute, valutnikodovi.kod, valutnikodovi.broj
        FROM '.$this->table .' LEFT JOIN drzave ON valutnikodovi.id_drzave = drzave.id_drzave WHERE valutnikodovi.id_valute = ? LIMIT 0,1';
        // Prepare statement
              $stmt = $this->conn->prepare($query);

              // Bind ID
              $stmt->bindParam(1, $this->id_valute);

              // Execute query
              $stmt->execute();

              $row = $stmt->fetch(PDO::FETCH_ASSOC);

              // Set properties
              $this->naziv_valute = $row['naziv_valute'];
              $this->kod = $row['kod'];
              $this->broj = $row['broj'];
    }

    // Create Valuta
   public function create() {
         // Create query
         $query = 'INSERT INTO ' . $this->table . ' SET naziv_valute = :naziv_valute, kod = :kod, broj = :broj, id_drzave = :id_drzave';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Clean data
         $this->naziv_valute = htmlspecialchars(strip_tags($this->naziv_valute));
         $this->kod = htmlspecialchars(strip_tags($this->kod));
         $this->broj = htmlspecialchars(strip_tags($this->broj));
         $this->id_drzave = htmlspecialchars(strip_tags($this->id_drzave));

         // Bind data
         $stmt->bindParam(':naziv_valute', $this->naziv_valute);
         $stmt->bindParam(':kod', $this->kod);
         $stmt->bindParam(':broj', $this->broj);
         $stmt->bindParam(':id_drzave', $this->id_drzave);

         // Execute query
         if($stmt->execute()) {
           return true;
     }

     // Print error if something goes wrong
     printf("Error: %s.\n", $stmt->error);

     return false;
   }

   // Update Valuta
   public function update() {
         // Create query
         $query = 'UPDATE ' . $this->table . ' SET naziv_valute = :naziv_valute, kod = :kod, broj = :broj, id_drzave = :id_drzave
         WHERE id_valute = :id_valute';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Clean data
         $this->naziv_valute = htmlspecialchars(strip_tags($this->naziv_valute));
         $this->kod = htmlspecialchars(strip_tags($this->kod));
         $this->broj = htmlspecialchars(strip_tags($this->broj));
         $this->id_drzave = htmlspecialchars(strip_tags($this->id_drzave));
         $this->id_valute = htmlspecialchars(strip_tags($this->id_valute));

         // Bind data
         $stmt->bindParam(':naziv_valute', $this->naziv_valute);
         $stmt->bindParam(':kod', $this->kod);
         $stmt->bindParam(':broj', $this->broj);
         $stmt->bindParam(':id_drzave', $this->id_drzave);
         $stmt->bindParam(':id_valute', $this->id_valute);

         // Execute query
         if($stmt->execute()) {
           return true;
         }

         // Print error if something goes wrong
         printf("Error: %s.\n", $stmt->error);

         return false;
   }

   // Delete Valuta
   public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id_valute = :id_valute';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id_valute));

            // Bind data
            $stmt->bindParam(':id_valute', $this->id_valute);

            // Execute query
            if($stmt->execute()) {
              return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
      }
}


?>
