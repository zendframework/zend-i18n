<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_I18n_Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\I18n\Translator\Plural;

/**
 * Plural rule evaluator.
 *
 * @package    Zend_I18n_Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Rule
{
    /**
     * Parser instance.
     * 
     * @var Parser
     */
    protected static $parser;
    
    /**
     * Abstract syntax tree.
     * 
     * @var array
     */
    protected $ast;
    
    /**
     * Number of plurals in this rule.
     * 
     * @var integer
     */
    protected $numPlurals;
    
    /**
     * Create a new plural rule.
     * 
     * @param  array $ast
     * @return void
     */
    protected function __construct(array $ast)
    {
        $this->ast = $ast;
    }
    
    /**
     * Evaluate a number and return the plural index.
     * 
     * @param  integer $number
     * @return integer
     */
    public function evaluate($number)
    {
        $result = $this->evaluateAstPart($this->ast, abs((int) $number));
        
        if ($result < 0) {
            exit ('Invalid result');
        }
        
        return $result;
    }
    
    /**
     * Evaluate a part of an ast.
     * 
     * @param  array   $ast
     * @param  integer $number
     * @return integer
     */
    protected function evaluateAstPart(array $ast, $number)
    {
        switch ($ast['id']) {
            case 'number':
                return $ast['arguments'][0];
            
            case 'n':
                return $number;
            
            case '+':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       + $this->evaluateAstPart($ast['arguments'][1], $number);
            
            case '-':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       - $this->evaluateAstPart($ast['arguments'][1], $number);
            
            case '/':
                // Integer division
                return floor(
                    $this->evaluateAstPart($ast['arguments'][0], $number)
                    / $this->evaluateAstPart($ast['arguments'][1], $number)
                );
                
            case '*':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       * $this->evaluateAstPart($ast['arguments'][1], $number);
                
            case '%':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       % $this->evaluateAstPart($ast['arguments'][1], $number);
                
            case '>':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       > $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '>=':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       >= $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '<':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       < $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '<=':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       <= $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '==':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       == $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '!=':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       != $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '&&':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       && $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '||':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       || $this->evaluateAstPart($ast['arguments'][1], $number)
                       ? 1 : 0;
                
            case '!':
                return !$this->evaluateAstPart($ast['arguments'][0], $number)
                       ? 1 : 0;
                
            case '?':
                return $this->evaluateAstPart($ast['arguments'][0], $number)
                       ? $this->evaluateAstPart($ast['arguments'][1], $number)
                       : $this->evaluateAstPart($ast['arguments'][2], $number);
                
            default:
                exit('Unknown token: ' . $ast['id']);
        }
    }
    
    /**
     * Create a new rule from a string.
     * 
     * @param  string $string 
     * @return Rule
     */
    public static function fromString($string)
    {
        if (self::$parser === null) {
            self::$parser = new Parser();
        }
        
        $tree = self::$parser->parse($string);
        $ast  = self::createAst($tree);
        
        return new self($ast);
    }
    
    /**
     * Create an AST from a tree.
     * 
     * Theoretically we could just use the given Symbol, but that one is not
     * so easy to serialize and also takes up more memory.
     * 
     * @param  Symbol $symbol
     * @return array
     */
    protected static function createAst(Symbol $symbol)
    {       
        $ast = array('id' => $symbol->id, 'arguments' => array());
        
        switch ($symbol->id) {
            case 'n':
                break;
            
            case 'number':
                $ast['arguments'][] = $symbol->value;
                break;
            
            case '!':
                $ast['arguments'][] = self::createAst($symbol->first);
                break;
            
            case '?':
                $ast['arguments'][] = self::createAst($symbol->first);
                $ast['arguments'][] = self::createAst($symbol->second);
                $ast['arguments'][] = self::createAst($symbol->third);
                break;
            
            default:
                $ast['arguments'][] = self::createAst($symbol->first);
                $ast['arguments'][] = self::createAst($symbol->second);
                break;
        }
        
        return $ast;
    }
}
