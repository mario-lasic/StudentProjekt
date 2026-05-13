<?php

namespace StudentProjekt\Contracts;

interface IJsonModel{
    public function spremi(): void;
    public static function dohvatiSve(): array;
    public function getNextId(): int;
    public function obrisi(int $id): void;
}