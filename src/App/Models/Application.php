<?php
namespace App\Models;


/**
 * @Entity
 * @Table(name="applications")
 * @package App\Models
 */
class Application extends BaseModel
{
    /**
     * @Id
     * @Column(type="integer")
     *
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Application
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Application
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getApplication()
    {
        return array(
            'id'    =>  $this->id,
            'name'    =>  $this->name,
            'code'    =>  $this->code
        );
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Application
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
