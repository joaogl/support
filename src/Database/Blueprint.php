<?php namespace jlourenco\support\Database;

use Illuminate\Database\Schema\Blueprint as IlluminateBlueprint;

/**
 * Extended version of Blueprint with
 * support of 'set' data type
 */
class Blueprint extends IlluminateBlueprint {

    /**
     * Create a new binary column on the table.
     *
     * @param  string  $column
     * @param  int  $length
     * @return \Illuminate\Support\Fluent
     */
    public function binary($column, $length = 255)
    {
        return $this->addColumn('binary', $column, compact('length'));
    }

    /**
     * Add creation and update user information to the table.
     *
     * @return void
     */
    public function creation()
    {
        $this->integer('created_by')->nullable()->unsigned();
        $this->integer('modified_by')->nullable()->unsigned();
        $this->integer('deleted_by')->nullable()->unsigned();
    }

    public function creationRelation()
    {
        $this->foreign('created_by')->references('id')->on('User');
        $this->foreign('modified_by')->references('id')->on('User');
        $this->foreign('deleted_by')->references('id')->on('User');
    }

    /**
     * Create a new 'set' column on the table.
     *
     * @param  string  $column
     * @param  array   $allowed
     * @return \Illuminate\Support\Fluent
     */
    public function set($column, array $allowed)
    {
        return $this->addColumn('set', $column, compact('allowed'));
    }

    /**
     * Specify a unique index for the table.
     *
     * @param  string|array  $columns
     * @param  string        $name
     * @param  int           $length
     * @return \Illuminate\Support\Fluent
     */
    public function unique($columns, $name = null, $length = null)
    {
        return $this->indexCommand('unique', $columns, $name, $length);
    }

    /**
     * Specify an index for the table.
     *
     * @param  string|array  $columns
     * @param  string        $name
     * @param  int           $length
     * @return \Illuminate\Support\Fluent
     */
    public function index($columns, $name = null, $length = null)
    {
        return $this->indexCommand('index', $columns, $name, $length);
    }

    /**
     * Determine if the given table exists.
     *
     * @param  string $table
     *
     * @return bool
     */
    public function hasForeign($table, $foreign)
    {
        $sql = $this->grammar->compileHasForeign();
        $table = $this->connection->getTablePrefix() . $table;
        return count($this->connection->select($sql, [$table, $foreign])) > 0;
    }

    /**
     * Add a new index command to the blueprint.
     *
     * @param  string        $type
     * @param  string|array  $columns
     * @param  string        $index
     * @param  int           $length
     * @return \Illuminate\Support\Fluent
     */
    protected function indexCommand($type, $columns, $index, $length = null)
    {
        $columns = (array) $columns;
        // If no name was specified for this index, we will create one using a basic
        // convention of the table name, followed by the columns, followed by an
        // index type, such as primary or index, which makes the index unique.
        if (is_null($index))
            $index = $this->createIndexName($type, $columns);
        return $this->addCommand($type, compact('index', 'columns', 'length'));
    }

}