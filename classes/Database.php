<?php

namespace AuthPhp;

class Database {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        echo 'добрались до бд';
    }

    public function read() {
        $jsonContent = file_get_contents($this->filePath);
        return json_decode($jsonContent, true);
    }

    public function write($data) {
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $jsonContent);
    }

    public function create($newRecord) {
        $data = $this->read();
        $data[] = $newRecord;
        $this->write($data);
    }

    public function update($id, $newData) {
        $data = $this->read();
        $data[$id] = $newData;
        $this->write($data);
    }

    public function delete($id) {
        $data = $this->read();
        unset($data[$id]);
        $this->write($data);
    }
}
