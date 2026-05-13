<?php

namespace StudentProjekt\Core;

abstract class JsonModelBase{
    protected static string $basePath = __DIR__."/../storage/";
    protected static string $fileName;

    protected static function getPutanja(): string{
        return static::$basePath . static::$fileName;
    }

    protected static function osigurajStorage(): void{
        if(!is_dir(static::$basePath)){
            mkdir(static::$basePath, 0777, true);
        }
    }

    protected static function readData(): array{
        static::osigurajStorage();
        $putanja = static::getPutanja();

        if (!file_exists($putanja)){
            return [];
        }

        return json_decode(file_get_contents($putanja), true) ?? [];
    }

    protected static function writeData(array $data): void{
        static::osigurajStorage();
        file_put_contents(static::getPutanja(), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    protected static function nextIdFromCoulmn(string $column): int{
        $data = static::readData();
        $ids = array_column($data,$column);
        return empty($ids) ? 1 : (max($ids)+1);
    }

    protected static function redirect(string $url): void {
        header ("refresh:1; url=".$url);
    }
}