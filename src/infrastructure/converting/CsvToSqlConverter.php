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

    public function runParseCsvToSql(): void{
        $this->parseCsvToArray();
        $this->openSqlAndWriteCsvArray();
    }

    private function parseCsvToArray(): void
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

        array_shift($this->parseData);

        $this->parseData = array_filter($this->parseData, function ($data) {
            $FilledItems = array_walk($data, function ($item) {
                return isset($item);
            });
            $ItemsNotNull = array_walk($data, function ($item) {
                return $item !== 'null';
            });
            return $FilledItems &&
                $ItemsNotNull &&
                array_count_values($data) === array_count_values($this->colums);
        });
    }

    private function openSqlAndWriteCsvArray(): void
    {
        if (!file_exists($this->sqlFile)) {
            throw new FileExistException;
        }

        $file = new SplFileObject($this->sqlFile, 'w');
        if (!$file) {
            throw new FileOpenException;
        }

        $file->fwrite($this->getSqlInstruction());

        fclose($file);
    }

    private function getHeaderColums(): array | false {
        $this->utilsFile->rewind();
        return $this->utilsFile->fgetcsv();
    }

    private function getNextLine(): ?iterable
    {
        //how do I set next line after headers?
        $result = null;
        while (!$this->utilsFile->eof()) {
            yield $this->utilsFile->fgetcsv();
        }
        return $result;
    }

    private function getSqlInstruction(): string
    {
        foreach ($this->getData() as $data) {
            return 'INSERT '.$this->usedTable.'('.$this->getLineColumns().') VALUES ('.$data.');\n';
        }
    }

    private function getLineColumns(): string
    {
        $columnsInLine = array_reduce($this->columns, function ($carry, $column) {
            return $carry.$column.', ';
        });
        return mb_substr($columnsInLine, 0, mb_strlen($columnsInLine) - 2);
    }

    private function getData(): iterable
    {
        foreach ($this->parseData as $data) {
            yield $this->getLineCsvArray($data);
        }
    }

    private function getLineCsvArray(array $data): string
    {
        $oneLineData = array_reduce($data, function ($carry, $item) {
            return $carry.$item.', ';
        });
        return mb_substr($oneLineData, 0, mb_strlen($oneLineData) - 2);
    }
}
