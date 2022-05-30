<?php


namespace modules\usecase;


use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class GetClassAll
{
    private $iterator;
    private $regex;
    private $check;
    private $path;

    public function __construct($check, $path)
    {
        $this->check = $check;
        $this->path = $path;
        $this->iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
        $this->regex    = new RegexIterator($this->iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
    }

    public function getAllClasses() {
        $a = [];
        foreach ($this->regex as $file => $value) {
            $current = $this->parseTokens(token_get_all(file_get_contents(str_replace('\\', '/', $file))));
            if ($current !== false) {
                list($namespace, $class) = $current;
                if($namespace === $this->check){
                    $a[] = $namespace.$class;
                }
            }
        }
        return $a;
    }

    private function parseTokens(array $tokens) {
        $nsStart    = false;
        $classStart = false;
        $namespace  = '';
        foreach ($tokens as $token) {
            if ($token[0] === T_CLASS) {
                $classStart = true;
            }
            if ($classStart && $token[0] === T_STRING) {
                return [$namespace, $token[1]];
            }
            if ($token[0] === T_NAMESPACE) {
                $nsStart = true;
            }
            if ($nsStart && $token[0] === ';') {
                $nsStart = false;
            }
            if ($nsStart && $token[0] === T_STRING) {
                $namespace .= $token[1] . '\\';
            }
        }

        return false;
    }

}