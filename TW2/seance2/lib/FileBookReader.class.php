<?php
class FileBookReader implements BookReader{

	private $file; // file resource

	/**
	 * Creats an object which's a resource to pass as a parameter to the read or write functions.
	 * @param fileName The name of this file.
	 */
	function __construct(string $fileName){
		$this->file = fopen($fileName,'r');
	}

	/**
	 * Closes this file.
	 */
	 function closeFile(){
		 fclose($this->file);
	 }

	/**
	 * Returns an array which represents a book that have been read on the file, NULL otherwise.
	 * @param fileName The file name where the read the book.
	 * @return array which represents a book that have been read on the file, NULL otherwise.
	 */
	function readBook() : ?array {
		$ligne = fgets($this->file);
		$table = [];

		while($ligne !== FALSE && trim($ligne) === "") {
				$ligne = fgets($this->file);
		}

		while($ligne !== FALSE && trim($ligne) !== "") {
			if (strpos($ligne, ":") != 0) {
				$table[trim(explode(":", $ligne)[0])] = trim(explode(":", $ligne)[1]);
				$ligne = fgets($this->file);
			} else {
				throw new Exception("Invalid syntaxe for this book, one of those elements it dosen't contains the symbol ':'.\n{$ligne}");
			}
		}
		if (count($table) == 0) {
			return NULL;
		}
		return $table;
	}
}
