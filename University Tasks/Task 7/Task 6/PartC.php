<?php

    class Binary_Tree_Node {

        public $data;

        public $left;
        public $right;

        public function __construct($d = NULL) 
        {
            $this->data = $d;
        }

        public function traversePreorder() 
        {

            $l = array();
            $r = array();

            if ($this->left) 
            { 
                $l = $this->left->traversePreorder(); 
            }
            if ($this->right) 
            { 
                $r = $this->right->traversePreorder(); 
            }

            return array_merge(array($this->data), $l, $r);
        }

        public function traversePostorder() 
        {

            $l = array();
            $r = array();

            if ($this->left) 
            { 
                $l = $this->left->traversePostorder(); 
            }
            if ($this->right) 
            { 
                $r = $this->right->traversePostorder(); 
            }

            return array_merge($l, $r, array($this->data));
        }

        public function traverseInorder() 
        {
            $l = array();
            $r = array();

            if ($this->left) 
            {
                 $l = $this->left->traverseInorder(); 
            }
            if ($this->right) 
            {
                 $r = $this->right->traverseInorder(); 
            }

            return array_merge($r, array($this->data), $l);
        }
    }

    class Sorting_Tree 
    {
        public $tree;

        public function insert($val) 
        {
            if (!(isset($this->tree))) 
            {
                $this->tree = new Binary_Tree_Node($val);
            } 
            else 
            {
                $pointer = $this->tree;
                for(;;) 
                {
                    if ($val <= $pointer->data) 
                    {
                        if ($pointer->left) 
                        {
                            $pointer = $pointer->left;
                        } 
                        else 
                        {
                            $pointer->left = new Binary_Tree_Node($val);
                            break;
                        }
                    }
                    else
                    {
                        if ($pointer->right) 
                        {
                            $pointer = $pointer->right;
                        } 
                        else 
                        {
                            $pointer->right = new Binary_Tree_Node($val);
                            break;
                        }
                    }
                }
            }
        }   
        public function returnSorted() 
        {
            return $this->tree->traverseInorder();
        }
    }

    $sort_as_you_go1 = new Sorting_Tree();
    $sort_as_you_go2 = new Sorting_Tree();
    $sort_as_you_go3 = new SOrting_Tree();

    for ($i = 0; $i < 20; $i++) 
    {
        $sort_as_you_go1->insert(rand(1,100));
        $sort_as_you_go2->insert(rand(1,100));
        $sort_as_you_go3->insert(rand(1,100));
    }
    echo "<p> Data Set 1: ", implode(", ", $sort_as_you_go1->returnSorted()), "</p>";
    echo "<p> Data Set 2: ", implode(", ", $sort_as_you_go2->returnSorted()), "</p>";
    echo "<p> Data Set 3: ", implode(", ", $sort_as_you_go3->returnSorted()), "</p>";
?>