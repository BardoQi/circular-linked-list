<?php
declare(strict_types=1);
/*
 * This file is part of bardoqi/circular-linked-list.
 *
 * (c) Bardeen QI <bardoqi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace bardoqi\CircularLinkedList;

use Countable;

/**
 * Class CircularLinkedList
 *
 * @package bardoqi\CircularLinkedList
 */
class CircularLinkedList implements Countable
{
    /**
    * @var array
    */
    private $data = [];

    /**
     * @var int
     */
    private $count = 0;

    /**
     * @var int
     */
    private $joint = 0;

    /**
     * CircularLinkedList constructor
     *
     * @param array $src_data
     * @param array $joint  The value could be 0 or 1
     *
     */
    public function __construct($src_data,$joint=0)
    {
        $this->count = count($src_data) - $joint;
        $this->joint = $joint;
        $this->data = $src_data;
    }

    /**
     * @param int $key
     * @desc  get actual position with given any integer
     * @return int
     */
    public function getKey($key){
        return ($this->count+$key) % $this->count;
    }

    /**
     * @param     $src_data
     * @param int $joint
     * @desc static create object
     * @return \bardoqi\CircularLinkedList\CircularLinkedList
     */
    public static function of($src_data,$joint=0){
        return new static($src_data,$joint);
    }

    /**
     * @param $key
     * @desc get actual key with any integer
     * @return int
     */
    public function nextKey($key){
        return $this->getKey($key+1);
    }

    /**
     * @param $key
     * @desc get actual key with any integer
     * @return int
     */
    public function prevKey($key){
        return $this->getKey($key-1);
    }

    /**
     * @param $from
     * @param $to
     *
     * @return bool|\Generator
     */
    public function nextItems($from, $to){
        $key = $this->getKey($from);
        $toKey = $this->nextKey($to);
        for(;;){
            yield $key => $this->data[$key];
            $key = $this->nextKey($key);
            if($key===$toKey){
                return false;
            }
        }
    }

    /**
     * @param $from
     * @param $count
     *
     * @return bool|\Generator
     */
    public function nextItemsWithCount($from, $count){
        $key = $this->getKey($from);
        for(;;){
            if(0==$count){
                return false;
            }
            yield $key => $this->data[$key];
            $count--;
            $key = $this->nextKey($key);
        }
    }

    /**
     * @param $from
     * @param $to
     *
     * @return bool|\Generator
     */
    public function prevItems($from, $to){
        $key = $this->getKey($from);
        $toKey = $this->prevKey($to);
        for(;;){
            yield $key => $this->data[$key];
            $key = $this->prevKey($key);
            if($key===$toKey){
                return false;
            }
        }
    }

    /**
     * @param $from
     * @param $count
     *
     * @return bool|\Generator
     */
    public function prevItemsWithCount($from, $count){
        $key = $this->getKey($from);
        for(;;){
            if(0==$count){
                return false;
            }
            yield $key => $this->data[$key];
            $count--;
            $key = $this->prevKey($key);
        }
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function nextItem($key){
        $new_key = $this->nextKey($key);
        return $this->data[$new_key];
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function prevItem($key){
        $new_key = $this->prevKey($key);
        return $this->data[$new_key];
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return int
     */
    public function prevCount($from,$to){
        return ($this->count + ($from - $to)) % $this->count + 1;
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return int
     */
    public function nextCount($from,$to){
        return ($this->count + ($to - $from)) % $this->count + 1;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getItem($key){
        return $this->data[$key];
    }

    /**
     * @param $keyA
     * @param $keyB
     * @desc check if 2 items are neighgours.
     * @return bool
     */
    public function isNeighbours($keyA,$keyB){
        if($keyA == $this->nextKey($keyB)){
            return true;
        }
        if($keyA == $this->prevKey($keyB)){
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function count(){
        return count($this->data)-$this->joint;
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        return count($this->data)-$this->joint == 0;
    }

    /**
     * @return int
     */
    public function size(){
        return count($this->data)-$this->joint;;
    }

    /**
     * @param $pos
     *
     * @return int
     */
    public function findByPos($pos){
        return $this->getKey($pos);
    }

    /**
     * @param      $value
     * @param bool $strict
     *
     * @return false|int|string
     */
    public function find($value,$strict=false){
        return array_search($value,$this->data,$strict);
    }

    /**
     * @param $pos
     * @param $value
     *
     * @return void
     */
    public function setAt($pos,$value){
        $key = $this->getKey($pos);
        $this->data[$key] = $value;
        if(0==$key){
            if(1==$this->joint){
                $this->data[$this->count-1] = $value;
            }
        }
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function add($value){
        $this->count++;
        if(1==$this->joint){
            $this->data[$this->count-1] = $value;
            $this->data[] = $this->data[0];
            return;
        }
        $this->data[] = $value;
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function push($value){
        $this->add($value);
    }

    /**
     * @return mixed
     */
    public function pop(){
        $this->count++;
        $value = array_pop($this->data);
        if(0==$this->joint){
             return $value;
        }
        $value = array_pop($this->data);
        $this->data[] = $this->data[0] ;
        return $value;
    }

    /**
     * @return mixed
     */
    public function shift(){
        $this->count--;
        $value = array_shift($this->data);
        if(0==$this->joint){
            return $value;
        }
        $this->data[] = $this->data[0] ;
        return $value;
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function unshift($value){
        $this->count++;
        $pos = array_unshift($this->data,$value);
        if(0==$this->joint){
            return $pos;
        }
        $this->data[] = $this->data[0] ;
        return $pos;
    }

    /**
     * @param $pos
     *
     * @return void
     */
    public function removeAt($pos){
        $key = $this->getKey($pos);
        if(0==$pos){
            return $this->shift($value);
        }
        if(1==$this->joint){
            if(0==$key){
                return $this->pop();
            }
            if(1==$key){
                return $this->shift();
            }
        }
        array_splice($this->data,$key,1);
        $this->count--;
    }

    /**
     * @param $pos
     * @param $value
     *
     * @return void
     */
    public function insertAt($pos,$value){
        $inserted = [$value];
        if(0==$pos){
            return $this->unshift($value);
        }
        $position = $this->getKey($pos);
        if(1==$this->joint){
            if(0==$position){
                return $this->add($value);
            }
            if(1==$position){
                return $this->unshift($value);
            }
        }
        $this->count++;
        array_splice( $this->data, $position, 0, $inserted );

    }

    /**
     * @return array
     */
    public function toArray(){
        return $this->data;
    }
}
