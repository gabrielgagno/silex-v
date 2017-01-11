<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/11/17
 * Time: 2:14 PM
 */

namespace App\Models;


/**
 * @Entity
 * @Table(name="message")
 * @package App\Models
 */
class Application
{
    /**
     * @Column(type="integer")
     */
    private $id;

    /**
     * @Column(type="string", length=140)
     */
    private $name;

    /**
     * @Column(type="string")
     */
    private $code;
}