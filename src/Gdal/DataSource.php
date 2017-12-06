<?php

/**
 * This file is part of the pgdal package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Gdal;


use Eddmash\PhpGis\Gdal\Exceptions\ExtensionMissingException;
use Eddmash\PhpGis\Gdal\Exceptions\GdalException;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

/**
 * Represents the file you are working with—though it doesn't have to be a file.
 * It could just as easily be a URL or some other source of data.
 *
 * Class DataSource
 * @package Eddmash\PhpGis\Gdal
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
class DataSource implements \Iterator
{

    private $iteratorPos = 0;
    private $_ptr;
    private $filename;

    /**
     * DataSource constructor.
     * @param $datasource
     * @throws GdalException
     */
    public function __construct($datasource)
    {
        if (!extension_loaded("pgdal")) :
            throw new ExtensionMissingException(
                "pgdal extension not installed,".
                " visit https://github.com/eddmash/pgdal for how to install"
            );
        endif;
        OGRRegisterAll();
        $this->filename = $datasource;

        $ptr = Gdal::datasourceOpen($datasource);
        if ($ptr):
            $this->_ptr = $ptr;
        else:
            throw new GdalException(sprintf("Invalid datasource %s", $datasource));
        endif;
    }

    public function __destruct()
    {
        Gdal::datasourceClose($this->_ptr);
    }

    public function getName()
    {
        return Gdal::getDatasourceName($this->_ptr);
    }

    /**
     * Get Total number of layers in the datasource.
     *
     * @return int
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getLayerCount()
    {
        return Gdal::getDatasourceLayerCount($this->_ptr);
    }

    /**
     * Get layer at a particular index in the datasource .
     * A layer index is between 0 and getLayerCount()-1.
     *
     * @param $index
     * @return Layer
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getLayerByIndex($index)
    {
        return Layer::getInstance(Gdal::getDatasourceLayer($this->_ptr, $index), $this->_ptr);
    }

    public function getLayerByName($name)
    {

        return Layer::getInstance(Gdal::getDatasourceLayerByName($this->_ptr, $name), $this->_ptr);
    }

    // ======================= ITERATE ================

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Layer.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->getLayerByIndex($this->iteratorPos);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->iteratorPos++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->iteratorPos;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->iteratorPos < $this->getLayerCount();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iteratorPos = 0;
    }


}