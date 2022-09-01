<?php declare(strict_types=1);

namespace omarinina\infrastructure\converting;

use Exception;
use SplFileObject;
use omarinina\infrastructure\exception\FileExistException;
use omarinina\infrastructure\exception\FileOpenException;
use omarinina\infrastructure\exception\HeaderColumsException;

class CsvToSqlConverter
{
    private string $csvFile;
    private string $sqlFile;
    private string $usedTable;
    private array $colums = [];
    private SplFileObject $utilsFile;
    private array $parseData = [];

    public function __construct(
        string $csvFile,
        string $sqlFile,
        string $usedTable,
        array $colums
    )
    {
        $this->csvFile = $csvFile;
        $this->sqlFile = $sqlFile;
        $this->usedTable = $usedTable;
        $this->colums = $colums;
    }

    public function import() : ?array
    {
        if (!file_exists($this->csvFile)) {
            throw new FileExistException;
        }

        $this->utilsFile = new SplFileObject($this->csvFile, 'r');
        if (!$this->utilsFile) {
            throw new FileOpenException;
        }

        $headerColums = $this->getHeaderColums();

        if (count($headerColums) !== count($this->columns)) {
            throw new HeaderColumsException;
        }

        foreach ($this->getNextLine() as $line) {
            $this->parseData[] = $line;
        }

        return $this->parseData;
    }

    public function writeSql(): bool
    {
        if (!file_exists($this->sqlFile)) {
            throw new FileExistException;
        }

        $file = new SplFileObject($this->sqlFile, 'w');
        if (!$file) {
            throw new FileOpenException;
        }

        return $file->fwrite($this->useSqlInstruction());
    }

    private function getHeaderColums(): array | false {
        $this->utilsFile->rewind();
        return $this->utilsFile->fgetcsv();
    }

    private function getNextLine(): ?iterable
    {
        $result = null;
        while (!$this->utilsFile->eof()) {
            yield $this->utilsFile->fgetcsv();
        }
        return $result;
    }

    private function useSqlInstruction(): string
    {
        return 'INSERT '.$this->usedTable.'('.$this->getLineColumns().') VALUES ('.$this->getData().');';
    }

    private function getLineColumns(): string
    {
        $columnsInLine = array_reduce($this->columns, function ($carry, $column) {
            return $carry.key($column).', ';
        });
        return mb_substr($columnsInLine, 0, mb_strlen($columnsInLine) - 2);
    }

    private function getData(): string
    {
        //не подходит reduce, потому что нам надо не одну строчку из всех строчек получить
        // а каждый раз получать одну строчку через yield?
        $oneLineData = array_reduce($this->parseData, function ($carry, $data) {
            return $carry.$this->getLineCsv($data).', ';
        });
        return mb_substr($oneLineData, 0, mb_strlen($oneLineData) - 2);
    }

    private function getLineCsv(array $data): string
    {


        $counter = 0;
        $result = array_reduce($data, function ($carry, $item) use (&$counter) {
            $type = current($this->columns[$counter]);
            $counter += 1;
            switch ($type) {
                case self::TYPE_INT:
                    return $carry. $item.",";
                default:
                    return $carry."'".addslashes($item)."',";
            }
        });

        return mb_substr($result, 0, mb_strlen($result) - 1);
    }
}
