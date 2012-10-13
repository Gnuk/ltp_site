<?php
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="user")
 **/
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $login;
    /** @Column(type="integer") **/
    protected $rights;
}