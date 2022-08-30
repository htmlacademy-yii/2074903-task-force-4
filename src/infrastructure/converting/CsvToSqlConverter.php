<?php declare(strict_types=1);

namespace omarinina\infrastructure\converting;

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
    private array $parseDate = [];

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

    /**
     * Импорт данных и их запись в текстовый файл с инструкцией SQL
     *
     * @param string $file_name  Путь и имя файла для записи
     *
     * @return bool
     */
    public function import() : bool
    {
        if (!file_exists($this->csvFile)) {
            throw new FileExistException;
        }

        $this->utilsFile = new SplFileObject($this->csvFile);
        if (!$this->utilsFile) {
            throw new FileOpenException;
        }

        $headerColums = $this->getHeaderColums();

        //как считать со второго столбца, а первый сразу заполнять автоинкрементом?
        if (count($headerColums) !== count($this->columns)) {
            throw new HeaderColumsException;
        }

        //оформить как генератор
        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

        return $this->writeSql();
    }
}
