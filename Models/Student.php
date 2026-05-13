<?php

    namespace StudentProjekt\Models;

    use Exception;
    use StudentProjekt\Contracts\IJsonModel;
    use StudentProjekt\Core\JsonModelBase;
    use StudentProjekt\Exceptions\SmjerException;
    use StudentProjekt\Exceptions\ValidationException;
    use StudentProjekt\Models\Smjer;

    class Student extends JsonModelBase implements IJsonModel
    {
        protected static string $fileName = "studenti.json";

        private int $id;
        private string $firstName;
        private string $lastName;
        private string $jmbag;
        private int $godinaStudija;
        private float $prosjek;
        private Smjer $smjer;

        public function __construct(string $firstName, string $lastName, string $jmbag, int $godinaStudija, float $prosjek, Smjer $smjer, ?int $id = null)
        {
            $this->validateName($firstName, "ime", "Ime");
            $this->validateName($lastName, "prezime", "Prezime");
            $this->validateJmbag($jmbag);
            $this->validateGodinaStudija($godinaStudija);
            $this->validateProsjek($prosjek);
            $this->validateSmjer($smjer, $godinaStudija);
            $this->id = $id ?? $this->getNextId();
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->jmbag = $jmbag;
            $this->godinaStudija = $godinaStudija;
            $this->prosjek = $prosjek;
            $this->smjer = $smjer;
        }

        // VALIDACIJE //

        private function validateName(string $value, string $polje, string $naziv): void
        {
            if (trim($value) === "") {
                throw new ValidationException("$polje", "$naziv nemože biti prazno!");
            }
            if (strlen(trim($value)) <= 2) {
                throw new ValidationException("$polje", "$naziv mora imati više od 2 znaka!");
            }
            if (mb_strtolower($value) == mb_substr($value, 0, 1)) {
                throw new ValidationException("$polje", "$naziv mora započeti sa velikim slovom!");
            }
        }

        private function validateJmbag(string $value): void
        {
            if (trim($value) === "") {
                throw new ValidationException("jmbag", "JMBAG nesmije biti prazno!");
            }
            if (!(strlen(trim($value)) == 10)) {
                throw new ValidationException("jmbag", "JMBAG mora sadržavati točno 10 znakova!");
            }
        }

        private function validateGodinaStudija(string $value): void
        {
            if ($value < 1 && $value > 5) {
                throw new ValidationException("godina_studija", "Godina studija mora biti između 1 i 5!");
            }
        }

        private function validateProsjek(string $value): void
        {
            if ($value < 1.0 && $value > 5) {
                throw new ValidationException("prosjek", "Prosjek mora biti između 1.0 i 5.0!");
            }
        }

        private function validateSmjer(Smjer $smjer, int $godinaStudija): void
        {
            if ($smjer->getNaziv() == "Smjer 2" && $godinaStudija < 3) {
                throw new SmjerException($smjer, "Smjer 2 mogu upisati samo studenti 3 ili veće godine!");
            }
            if (!$smjer->isAktivan()) {
                throw new SmjerException($smjer, "{$smjer->getNaziv()} nije aktivan!");
            }
        }

        public function getNextId(): int
        {
            return self::nextIdFromCoulmn("id");
        }


        public function spremi(): void
        {
            try {
                $data = self::readData();
                $data [] = [
                    "id" => $this->id,
                    "ime" => $this->firstName,
                    "prezime" => $this->lastName,
                    "jmbag" => $this->jmbag,
                    "godinaStudija" => $this->godinaStudija,
                    "prosjek" => $this->prosjek,
                    "smjerId" => $this->smjer->getId()
                ];
                self::writeData($data);
        } catch (Exception $e) {
                throw new Exception("Greška kod spremanja studenta: " . $e->getMessage());
            }
    }

        public static function dohvatiSve(): array
        {
            try {
                return self::readData();
            } catch (Exception $e) {
                throw new Exception("Greška kod čitanja studenata: " . $e->getMessage());
            }
        }

        public function obrisi(int $id): void
        {

        }

        public static function brojStudenata(): int {
            return count(self::readData());
        }

        public static function redirect(string $url): void
        {
            parent::redirect($url);
        }

        public static function dohvatiSaSmjerom(): array{
            $studenti = self::readData();
            $smjerovi = Smjer::dohvatiSve();

            $mapaSmjerova = [];
            foreach ($smjerovi as $smjer) {
                $mapaSmjerova[$smjer["id"]] = $smjer["naziv"];
            }
            $rezultat = [];

            foreach ($studenti as $student){
                $rezultat[] = [
                    "id" => $student["id"],
                    "student" => $student["ime"]." ".$student["prezime"],
                    "jmbag" => $student["jmbag"],
                    "godinaStudija" => (int)$student["godinaStudija"],
                    "prosjek" => (float)$student["prosjek"],
                    "smjer" =>$mapaSmjerova[$student["id"]] ?? "Nepoznat smjer"
                ];
            }
            return $rezultat;
        }

        public function getProsjek(): float{
            return $this->prosjek;
        }

        public static function findById(int $id): ?Student
        {
            $studenti = self::readData();
            foreach ($studenti as $student) {
                if ((int)$student["id"] === $id) {
                    return new Student($student["ime"], $student["prezime"], $student["jmbag"], $student["godinaStudija"], $student["prosjek"], Smjer::findById($student["smjerId"]), $student["id"]);
                }
            }
            return null;
        }

        // Dodatne Metode
        public static function jeOdlikas($id) : bool {
            $student = self::findById($id);
            return ($student->getProsjek() >= 4.5);
        }

        public function getPunoIme(): string
        {
            return $this->firstName . " " . $this->lastName;
        }

        public static function dohvatiOdlikase(): array {
            $studenti = self::readData();
            $rezultat = [];
            foreach ($studenti as $student) {
                $s = self::findById($student["id"]);
                if ($s->getProsjek() >= 4.5) {
                    $rezultat[] = [
                        "student" => $s->getPunoIme()
                    ];
                }
            }
            return $rezultat;
        }

        public static function dohvatiStudentePoSmjeru(): array {
            $studenti = self::readData();
            $smjerovi = Smjer::dohvatiSve();
            $rezultat = [];
            foreach ($smjerovi as $smjer) {
                $rezultat[$smjer["id"]] = 0;
            }
            foreach ($studenti as $student) {
                $rezultat[$student["smjerId"]] += 1;
            }
            return $rezultat;
        }
    }