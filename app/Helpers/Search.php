<?php

namespace App\Helpers;
use \App\Product;
use Illuminate\Contracts\Foundation\Application;


class Node {
    private $alpha;
    private $isLeaf;
    private $occurences;

    public function __construct() {
        $this->alpha = [];
        $this->isLeaf = false;
        $this->occurences = 0;
    }

    public function setLetter($letter) {
        $this->alpha[$letter] = new Node;
    }

    public function letterExist($letter) {
        return isset($this->alpha[$letter]);
    }

    public function getLetter($letter) {
        return $this->alpha[$letter];
    }

    public function setLeaf() {
        $this->isLeaf = true;
        $this->occurences++;
    }

    public function unsetLeaf() {
        if($this->occurences > 0) {
            $this->occurences--;
            if($this->occurences == 0) {
                $this->isLeaf = false;
            }
        }
    }

    public function unsetState($letter) {
        unset($this->alpha[$letter]);
    }

    public function isLeaf() {
        return $this->isLeaf;
    }

    public function getCurrentState() {
        return $this->alpha;
    }
}

class Trie {
    private $root;
    private static $trieObject;
    private $result;

    public static function getInstance() {
        if(! is_null(Trie::$trieObject)) {
            return Trie::$trieObject;
        }
        static::$trieObject = new Trie;

        return Trie::$trieObject;
    }

    private function __construct() {
        $this->root = new Node;
        $this->index();
    }

    private function index() {
        $products = Product::published()->get();
        foreach($products as $product) {
            $this->addProduct(strtolower(trim($product->name)));
        }
    }

    public function addProduct($product) {
        $this->insert($this->root, $product);
    }

    public function deleteProduct($product) {
        $this->delete($this->root, $product, 0);
    }

    public function delete(Node $root, $product, $i) {
        $n = strlen($product);
        if($i == $n && $root->isLeaf()) {
            $root->unsetLeaf();
            return true;
        }
        else if($i == $n) {
            return false;
        }
        else {
            if($root->letterExist($product[$i])) {
                $exist = $this->delete($root->getLetter($product[$i]), $product, $i + 1);
                if($exist) {
                    $root->unsetState($product[$i]);
                }
            }
            else {
                return false;
            }
        }
        return $exist;
    }

    private function insert($root, $word) {
        $n = strlen($word);

        for($i = 0; $i < $n; $i++) {

            if(! $root->letterExist($word[$i])) {
                $root->setLetter($word[$i]);
            }
            $root = $root->getLetter($word[$i]);
        }
        $root->setLeaf();
    }

    public function results($prefix, $limit) {
        $this->result = [];
        $this->search($this->root, $prefix, $limit, 0, "");
        return $this->result;
    }

    private function search($root, $prefix, $limit, $i, $word) {
        $n = strlen($prefix);
        if($i < $n) {
            if($root->letterExist($prefix[$i])) {
                $this->search($root->getLetter($prefix[$i]), $prefix, $limit, $i + 1, $word . $prefix[$i]);
            }
        }
        else {
            if($root->isLeaf()) {
                array_push($this->result, $word);
            }
            foreach($root->getCurrentState() as $key => $value) {
                    $this->search($value, $prefix, $limit, $i + 1, $word . $key);
            }
        }
    }

    public function dumpRoot() {
        return $this->root;
    }
}