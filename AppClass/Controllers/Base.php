<?php
namespace AppClass\Controllers;
use Interop\Container\ContainerInterface;


abstract class Base {

    protected $container;
    protected $db;
    protected $upload_directory;

    public function __construct(ContainerInterface $c)

    {


        $this->container = $c;
        $this->db        = $c['db'];
        $this->upload_directory = $c['upload_directory'];

    }




}