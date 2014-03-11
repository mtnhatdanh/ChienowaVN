<?php
class Item extends Eloquent
{
    public $table="items";
    /**
     * One to many relationship
     * @return Object [description]
     */
    public function category(){
    	return $this->belongsTo("Category","category_id");
    }

    public function itematt(){
        return $this->hasMany("ItemAtt", 'item_id');
    }

    public function transaction(){
        return $this->hasMany("Transaction", 'item_id');
    }

    /**
     * get Name of an Item
     * @return string Namevalue
     */
    public function getItemName(){
        $name = $this->itematt()->where('attribute_id', '=', 1)->get()->first()->value;
        return $name;
    }

    public function getItemUnit(){
        $unit = $this->itematt()->where('attribute_id', '=', 8)->get()->first()->value;
        return $unit;
    }

    /**
     * Check ID Item exists or not
     * @param  integer $item_id Id of Item
     * @return boolean          true or false
     */
    public static function checkIdExist($item_id){
        if (Item::where('id', '=', $item_id)->count()>0) {
            return true;
        } else return false;
    }

    /**
     * get InStock amount of an Item
     * @param  integer $item_id ID of Item
     * @return array          result array
     */
    public function getInStock(){
        $item_id = $this->id;
        $sumImport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'I')
                    ->groupBy('item_id')
                    ->first();
        $sumExport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'E')
                    ->groupBy('item_id')
                    ->first();

        if(!$sumImport) $importVal = 0; else $importVal = $sumImport->total;
        if(!$sumExport) $exportVal = 0; else $exportVal = $sumExport->total;

        $inStock = $importVal - $exportVal;
        $result = array(
            'sumImport' =>$importVal,
            'sumExport' =>$exportVal,
            'inStock'   =>$inStock
            );

        return $result;
    }

    /**
     * get AmountFilerByDay
     * @param  integer $item_id  Item ID
     * @param  date $from_day from day
     * @param  date $to_day   to day
     * @return array           result
     */
    public static function getAmountFilterByDay($item_id, $from_day, $to_day){
        $sumImport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'I')
                    ->whereBetween('date', array($from_day, $to_day))
                    ->groupBy('item_id')
                    ->first();
        $sumExport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'E')
                    ->whereBetween('date', array($from_day, $to_day))
                    ->groupBy('item_id')
                    ->first();

        if(!$sumImport) $importVal = 0; else $importVal = $sumImport->total;
        if(!$sumExport) $exportVal = 0; else $exportVal = $sumExport->total;

        $inStock = $importVal - $exportVal;
        $result = array(
            'sumImport' =>$importVal,
            'sumExport' =>$exportVal,
            'inStock'   =>$inStock
            );

        return $result;
    }

    /**
     * Get OpenningStock amount by date
     * @param  integer $item_id    Item ID
     * @param  date $before_day before date
     * @return real             Amount
     */
    public static function getOpeningStock($item_id, $before_day){
        $sumImport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'I')
                    ->where('date', '<', $before_day)
                    ->groupBy('item_id')
                    ->first();
        $sumExport = DB::table('transactions')
                    ->select(DB::raw('sum(amount) as total, item_id'))
                    ->where('item_id', '=', $item_id)
                    ->where('type', '=', 'E')
                    ->where('date', '<', $before_day)
                    ->groupBy('item_id')
                    ->first();

        if(!$sumImport) $importVal = 0; else $importVal = $sumImport->total;
        if(!$sumExport) $exportVal = 0; else $exportVal = $sumExport->total;

        $openingStock = $importVal - $exportVal;

        return $openingStock;
    }
    
}