<?php

    namespace StudentProjekt\Models;

    use Exception;
    use StudentProjekt\Contracts\IJsonModel;
    use StudentProjekt\Core\JsonModelBase;
    use StudentProjekt\Exceptions\ValidationException;

    class Smjer extends JsonModelBase implements IJsonModel
    {
        protected static string $fileName = "smjerovi.json";

        private int $id;
        private string $naziv;
        private int $trajanjeGodina;
        private bool $aktivan;

        public function __construct(string $naziv, int $trajanjeGodina, bool $aktivan, ?int $id = null)
        {
            $this->validateNaziv($naziv);
            $this->validateGodine($trajanjeGodina);
            $this->naziv = $naziv;
            $this->trajanjeGodina = $trajanjeGodina;
            $this->aktivan = $aktivan;
            $this->id = $id ?? $this->getNextId();
        }

        // VALIDACIJA //

        private function validateNaziv(string $naziv): void
        {
            if (trim($naziv) === "") {
                throw new ValidationException("naziv", "Naziv nemože biti prazno!");
            }
            if (strlen(trim($naziv)) <= 3) {
                throw new ValidationException("naziv", "Naziv mora imati više od 3 znaka!");
            }
        }

        private function validateGodine(int $trajanjeGodina): void
        {
            if ($trajanjeGodina < 1 || $trajanjeGodina > 5) {
                throw new ValidationException("trajanje_godina", "Trajanje godina mora biti između 1 i 5");
            }
        }

        public function isAktivan(): bool{
            return $this->aktivan;
        }

        public function getNextId(): int
        {
            return self::nextIdFromCoulmn("id");
        }

        public static function findById(int $id): ?Smjer
        {
            $smjerovi = self::readData();
            foreach ($smjerovi as $smjer) {
                if ((int)$smjer["id"] === $id) {
                    return new Smjer($smjer["naziv"], (int)$smjer["trajanjeGodina"], (bool)$smjer["aktivan"], (int)$smjer["id"]);
                }
            }
            return null;
        }

        public static function dohvatiSve(): array
        {
            try {
                return self::readData();
            } catch (Exception $e) {
                throw new Exception("Greška kod čitanja smjerova: " . $e->getMessage());
            }
        }

        public function getNaziv(): string
        {
            return $this->naziv;
        }

        public function spremi(): void
        {
            try {
                $data = self::readData();

                $data [] = [
                    "id" => $this->id,
                    "naziv" => $this->naziv,
                    "aktivan" => $this->aktivan,
                    "trajanjeGodina" => $this->trajanjeGodina
                ];
                self::writeData($data);
            } catch (Exception $e) {
                throw new Exception("Greška kod spremanja smjera: " . $e->getMessage());
            }
        }

        public function obrisi(int $id): void
        {
            // TODO: Implement obiris() method.
        }

        public function getId(): int
        {
            return $this->id;
        }

        public static function redirect(string $url): void
        {
            parent::redirect($url);
        }
    }