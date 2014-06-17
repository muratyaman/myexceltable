<?php
/**
 * Namespace definition
 */
namespace yaman;

/**
 * Class for a simple table with few Excel
 */
class myexceltable
{
    
    /**
     * Data array
     * @var array
     */
    public $data = array();
    
    /**
     * Formulae array
     * @var array
     */
    public $formulae = array();
    
    /**
     * Index of current row
     * @var int
     */
    public $current_row = 0;
    
    /**
     * Index of current column
     * @var int
     */
    public $current_column = 0;
    
    /**
     * Error message
     * null or empty means all OK, otherwise there's an error
     * @var string
     */
    public $error = '';
    
    /**
     * Constructor
     * @param array $data
     * @param array $formulae
     * @param int   $rowCount
     * @param int   $columnCount
     */
    function __construct (array $data = array(), array $formulae = array(), $rowCount = 10, $columnCount = 10)
    {
        error_log(__METHOD__);
        //$this->reset($data, $formulae, $rowCount, $columnCount);
    }
    
    /**
     * Reset table
     * @param array $data
     * @param array $formulae
     * @param int   $rowCount
     * @param int   $columnCount
     */
    private function reset(array $data = array(), array $formulae = array(), $rowCount = 10, $columnCount = 10)
    {
        error_log(__METHOD__);
        $this->data = array();
        $this->formulae = array();
        
        for ($r = 0; $r < $rowCount; $r++) {
            
            $this->data[$r] = array();
            $this->formulae[$r] = array();
            
            for ($c = 0; $c < $columnCount; $c++) {
                
                $this->data[$r][$c] = '';
                $this->formulae[$r][$c] = '';
                
                if (isset($data[$r][$c])) {
                    $this->data[$r][$c] = $data[$r][$c];
                }
                
                if (isset($formulae[$r][$c])) {
                    $this->formulae[$r][$c] = $formulae[$r][$c];
                }
                
            }
        }
    }
    
    /**
     * Refresh and calculate the table
     * @param array $post
     */
    public function refresh (array $post = array())
    {
        error_log(__METHOD__);
        $data     = isset($post['data']) ? (array) $post['data'] : array();
        $formulae = isset($post['formulae']) ? (array) $post['formulae'] : array();
        
        $this->current_row    = isset($post['current_row']) ? $post['current_row'] : 0;
        $this->current_column = isset($post['current_column']) ? $post['current_column'] : 0;
        
        $this->reset($data, $formulae);
        $this->calculateCell($this->current_row, $this->current_column);
        $this->error = '';
    }
    
    /**
     * Convert to JSON string
     * @return string
     */
    public function toJson()
    {
        error_log(__METHOD__);
        return json_encode((array) $this);
    }
    
    /**
     * Calculate cell
     * @param int $r
     * @param int $c
     */
    private function calculateCell($r, $c)
    {
        error_log(__METHOD__);
        $formula = trim($this->formulae[$r][$c]);
        if ($formula !== ''){
            if (substr($formula, 0, 1) === '=') {
                $formula = substr($formula, 1);//trim '='
                $this->data[$r][$c] = $this->calculateFormula($formula);
            } else {
                $data = $formula;//$this->data[$r][$c];
                $this->data[$r][$c] = $this->calculateData($data);
            }
        } else {
            $this->data[$r][$c] = '';
        }
    }
    
    /**
     * Calculate by using formula
     * @param string $formula
     * @return string
     */
    private function calculateFormula($formula)
    {
        error_log(__METHOD__);
        
        $digitPair = '\((\d),(\d)\)'; // to match '(x,y)'
        $range     = sprintf('\(%s,%s\)', $digitPair, $digitPair);
        $func      = sprintf('(SUM|COUNT|MAX|MIN)', $range);
        $pattern   = sprintf('/^%s%s$/', $func, $range);
        $matches   = array();
        if (preg_match($pattern, $formula, $matches)) {
            $function = 'eval' . $matches[1];
            $range = array(
                'start' => array('row' => $matches[2], 'column' => $matches[3]),
                'end'   => array('row' => $matches[4], 'column' => $matches[5]),
            );
            $val = $this->$function($range);
        } else {
            $val = '#error#';
        }
        
        return $val;
    }
    
    /**
     * Calculate by using data
     * @param string $data
     * @return string
     */
    private function calculateData ($data)
    {
        error_log(__METHOD__);
        $val = '';
        
        $matches = array();
        $intPattern = '/^\d+$/';
        $floatPattern = '/^\d+\.\d+$/';
        
        if (preg_match($floatPattern, $data, $matches)) {
            $val = floatval($data);
        } elseif (preg_match($intPattern, $data, $matches)) {
            $val = intval($data);
        }
        
        return $val;
    }
    
    /**
     * Sums all of the numerical values in the given range
     * @param array $range
     * @return float
     */
    private function evalSUM(array $range)
    {
        error_log(__METHOD__);
        $val = 0.0;
        
        for($r = $range['start']['row']; $r <= $range['end']['row']; $r++) {
            for($c = $range['start']['column']; $c <= $range['end']['column']; $c++) {
                $tmp = $this->calculateCell($r, $c);
                if (!empty($tmp)) {
                    $val += $tmp;
                }
            }
        }
        
        return $val;
    }
    
    /**
     * Returns the number of cells that are not empty in the given range
     * @param array $range
     * @return int
     */
    private function evalCOUNT(array $range)
    {
        error_log(__METHOD__);
        $val = 0;
        
        for($r = $range['start']['row']; $r <= $range['end']['row']; $r++) {
            for($c = $range['start']['column']; $c <= $range['end']['column']; $c++) {
                $tmp = $this->calculateCell($r, $c);
                if (!empty($tmp)) {
                    $val += 1;
                }
            }
        }
        
        return $val;
    }
    
    /**
     * Finds the maximum numerical value in the given range (ignoring empty cells)
     * @param array $range
     * @return type
     */
    private function evalMAX(array $range)
    {
        error_log(__METHOD__);
        $val = 0.0;
        
        for($r = $range['start']['row']; $r <= $range['end']['row']; $r++) {
            for($c = $range['start']['column']; $c <= $range['end']['column']; $c++) {
                $tmp = $this->calculateCell($r, $c);
                if (!empty($tmp) && $val < $tmp) {
                    $val = $tmp;
                }
            }
        }
        
        return $val;
    }
    
    /**
     * Finds the minimum numerical value in the given range (ignoring empty cells)
     * @param array $range
     * @return float
     */
    private function evalMIN(array $range)
    {
        error_log(__METHOD__);
        $val = 0.0;
        
        for($r = $range['start']['row']; $r <= $range['end']['row']; $r++) {
            for($c = $range['start']['column']; $c <= $range['end']['column']; $c++) {
                $tmp = $this->calculateCell($r, $c);
                if (!empty($tmp) && $tmp < $val) {
                    $val = $tmp;
                }
            }
        }
        
        return $val;
    }
    
}