<?php

namespace App\Helpers\Trie;

class Node {
    private $alpha;
    private $isLeaf;

    public function __construct() {
        $this->alpha = [];
        $this->isLeaf = false;
    }
}

class Trie {
    private $root;

    public function __construct() {
        $this->root = new Node;
    }

    public function index() {
        return __DIR__;
    }

    public function insert($root, $word) {
        $n = count($word);

        for($i = 0; $i < $n; $i++) {
            if(! isset($root->alpha[$word[$i]])) {
                $root->alpha[$word[$i]] = new Node;
            }
            $root = $root->alpha[$word[$i]];
        }
        $root->isLeaf = true;
    }

    public function results($prefix, $limit) {
        return $this->search($this->root, $prefix, $limit, 0, "");
    }

    public function search($root, $prefix, $limit, $i, $word) {
        $n = count($prefix);
        $result = [];
        if($i < $n) {
            if(isset($root->alpha[$word[$i]])) {
                $foundSoFar = search($root->alpha[$prefix[$i]], $prefix, $limit, $i + 1, $word . $prefix[$i]);
                if(! is_null($foundSoFar)) {
                    array_push($result, $foundSoFar);
                }
            }
        }
        else {
            if($root->isLeaf)
                return $word;
            else {
                foreach($root->alpha as $key => $value) {
                    $foundSoFar = search($value, $prefix, $limit, $i + 1, $word . $key);
                    if(! is_null($foundSoFar)) {
                        array_push($result, $foundSoFar);
                    }
                }
            }
        }

        if(count($result) >= $limit) {
            return null;
        }
    }
}