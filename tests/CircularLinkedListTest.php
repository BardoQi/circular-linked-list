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

namespace bardoqi\Tests;

require_once(__DIR__ ."/../src/CircularLinkedList/CircularLinkedList.php");

use PHPUnit\Framework\TestCase as TestCase;
use bardoqi\CircularLinkedList\CircularLinkedList;
/**
 * Class CircularLinkedListTest
 *
 * @package bardoqi\Tests
 */
final class CircularLinkedListTest extends TestCase
{
    /** @var array */
    private $data;

    protected function setUp() {
        $this->data = range(0,7,1);
    }

    public function testCLLEmpty() {
        $cll = CircularLinkedList::of([]);
        $this->assertEquals(0, count($cll));
        $this->assertTrue($cll->isEmpty());
    }

    public function testNextPrevKey(){
        $cll = CircularLinkedList::of($this->data);
        $key = $cll->nextKey(7);
        $this->assertEquals(0,$key);
        $key = $cll->prevKey(0);
        $this->assertEquals(7,$key);
    }

    public function testNextPrevKeyWithJoint(){
        $cll = CircularLinkedList::of($this->data,1);
        $key = $cll->nextKey(6);
        $this->assertEquals(0,$key);
        $key = $cll->prevKey(0);
        $this->assertEquals(6,$key);
    }

    public function testNextPrevItemAndSetItem(){
        $cll = CircularLinkedList::of($this->data);
        $cll->setAt(7,7);
        $cll->setAt(0,0);
        $value = $cll->nextItem(7);
        $this->assertEquals(0,$value);
        $value = $cll->prevItem(0);
        $this->assertEquals(7,$value);
    }

    public function testForeachSetWithOrderAsc(){
        $cll = CircularLinkedList::of($this->data);
        foreach($cll->nextItems(3,10) as $key => $value){
            $cll->setAt($key,$value+1);
            $this->assertEquals($key+1,$cll->getItem($key));
        }
    }

    public function testForeachSetWithOrderDesc(){
        $cll = CircularLinkedList::of($this->data);
        foreach($cll->prevItems(3,10) as $key => $value){
            $cll->setAt($key,$value+1);
            $this->assertEquals($key+1,$cll->getItem($key));
        }
    }

    public function testForeachSetWithOrderAscWithCount(){
        $cll = CircularLinkedList::of($this->data);
        foreach($cll->nextItemsWithCount(3,8) as $key => $value){
            $cll->setAt($key,$value+1);
            $this->assertEquals($key+1,$cll->getItem($key));
        }
    }

    public function testForeachSetWithOrderDescWithCount(){
        $cll = CircularLinkedList::of($this->data);
        foreach($cll->prevItemsWithcount(5,8) as $key => $value){
            $cll->setAt($key,$value+1);
            $this->assertEquals($key+1,$cll->getItem($key));
        }
    }

    public function testStepCount(){
        $cll = CircularLinkedList::of($this->data);
        $this->assertEquals(4,$cll->prevCount(2,7));
        $this->assertEquals(5,$cll->nextCount(7,3));
    }

    public function testPushPop(){
        $cll = CircularLinkedList::of($this->data);
        $cll->push(9);
        $this->assertEquals(9,$cll->getItem(8));
        $this->assertEquals(9,$cll->pop());
    }

    public function testShiftUnshift(){
        $cll = CircularLinkedList::of($this->data);
        $cll->unshift(9);
        $this->assertEquals(9,$cll->getItem(0));
        $this->assertEquals(9,$cll->shift());
    }

    public function testIsNeighbours(){
        $cll = CircularLinkedList::of($this->data,1);
        $this->assertTrue($cll->isNeighbours(6,0));

    }

    public function testInsertRemove(){
        $cll = CircularLinkedList::of($this->data,1);
        $cll->insertAt(11,11);
        $this->assertEquals(11,$cll->getItem(4));
        $cll->removeAt(4);
        $this->assertEquals(4,$cll->getItem(4));

        $cll->insertAt(7,7);
        $this->assertEquals(0,$cll->getItem(8));
        $cll->removeAt(7);
        $this->assertEquals(0,$cll->getItem(7));

        $cll = CircularLinkedList::of($this->data);
        $cll->insertAt(11,11);
        $this->assertEquals(11,$cll->getItem(3));
        $cll->removeAt(3);
        $this->assertEquals(3,$cll->getItem(3));
    }

    public function testFind(){
        $cll = CircularLinkedList::of($this->data,1);
        $this->assertEquals(5,$cll->find(5));
        $this->assertEquals(4,$cll->findByPos(11));
    }
}
